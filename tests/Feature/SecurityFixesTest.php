<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SecurityFixesTest extends TestCase
{
    use RefreshDatabase;

    private array $enquiry = ['name' => 'Test', 'email' => 'test@example.com', 'message' => 'Hello'];

    private array $quote = ['name' => 'Test', 'phone' => '+94 77 000 0000', 'email' => 'test@example.com', 'city' => 'Colombo', 'property_type' => 'House'];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    public function test_account_creation_url_is_gone(): void
    {
        $this->get('/adduser231412341234')->assertNotFound();
        $this->assertSame(0, User::count());
    }

    public function test_only_users_marked_as_admin_can_open_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/orders')->assertForbidden();

        $this->actingAs(User::factory()->create(['is_admin' => true]))->get('/admin/orders')->assertOk();
    }

    public function test_contact_form_is_limited_to_five_tries_a_minute(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');
        }

        $this->post('/contact-us', $this->enquiry)->assertStatus(429);
        $this->assertSame(5, ContactEnquiry::count());
    }

    public function test_quote_form_is_limited_too(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/checkout', []);
        }

        $this->post('/checkout', [])->assertStatus(429);
    }

    public function test_contact_message_is_capped(): void
    {
        $this->post('/contact-us', ['message' => str_repeat('a', 5001)] + $this->enquiry)->assertSessionHasErrors('message');
        $this->assertSame(0, ContactEnquiry::count());
    }

    public function test_quote_with_an_empty_cart_creates_nothing(): void
    {
        $this->post('/checkout', $this->quote)->assertRedirect('/checkout');
        $this->assertSame(0, Order::count());
    }

    public function test_cart_rejects_bad_input_instead_of_crashing(): void
    {
        $product = Product::create(['name' => 'Ashford', 'category' => 'TIMBERLINE', 'description' => 'd', 'price' => 1, 'image' => 'x.jpg']);

        $this->post('/cart', ['product_id' => ['a'], 'quantity' => 1, 'height' => 1, 'width' => 1])->assertSessionHasErrors('product_id');
        $this->post('/cart', ['product_id' => 9999, 'quantity' => 1, 'height' => 1, 'width' => 1])->assertSessionHasErrors('product_id');
        $this->post('/cart', ['product_id' => $product->id, 'quantity' => 'abc', 'height' => 1, 'width' => 1])->assertSessionHasErrors('quantity');
        $this->assertEmpty(session('cart'));

        $this->post('/cart', ['product_id' => $product->id, 'quantity' => 1, 'height' => 2, 'width' => 3])->assertSessionHasNoErrors();
        $this->assertSame(6.0, (float) session('cart')[$product->id]['floor_area']);
    }

    public function test_unfinished_cart_and_checkout_routes_are_gone(): void
    {
        foreach (['/cart/create', '/cart/1', '/cart/1/edit', '/checkout/create', '/checkout/1'] as $url) {
            $this->get($url)->assertNotFound();
        }
    }

    public function test_security_headers_are_sent(): void
    {
        $response = $this->get('https://localhost/contact-us/thank-you');

        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeaderMissing('X-Powered-By');

        $this->get('http://localhost/contact-us/thank-you')->assertHeaderMissing('Strict-Transport-Security');
    }

    public function test_admin_html_is_cleaned_before_it_reaches_visitors(): void
    {
        $html = Blade::render("{!! Str::sanitizeHtml((string) (\$x ?? '')) !!}", [
            'x' => '<p class="lead">Kirin <span>floors</span><br><strong>SPC</strong></p><script>steal()</script><img src="x.png" onerror="steal()"><a href="javascript:steal()">x</a>',
        ]);

        $this->assertStringContainsString('<p class="lead">Kirin <span>floors</span><br /><strong>SPC</strong></p>', $html);
        $this->assertStringNotContainsString('script', $html);
        $this->assertStringNotContainsString('onerror', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertSame('', Blade::render("{!! Str::sanitizeHtml((string) (\$x ?? '')) !!}", ['x' => null]));
    }

    public function test_footer_address_is_escaped_but_keeps_line_breaks(): void
    {
        $html = Blade::render("{!! nl2br(e(\$a ?? '')) !!}", ['a' => "No 5, Main St\n<script>x()</script>"]);

        $this->assertSame("No 5, Main St<br />\n&lt;script&gt;x()&lt;/script&gt;", $html);
    }

    public function test_uploads_accept_only_plain_images(): void
    {
        $this->assertSame(['image/jpeg', 'image/png', 'image/webp'], FileUpload::make('x')->getAcceptedFileTypes());
    }

    public function test_unknown_columns_cannot_be_mass_assigned(): void
    {
        $enquiry = ContactEnquiry::create($this->enquiry + ['id' => 500, 'created_at' => '2000-01-01']);

        $this->assertNotSame(500, $enquiry->id);
        $this->assertNotSame('2000-01-01', $enquiry->created_at->toDateString());
    }
}
