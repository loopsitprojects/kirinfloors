<?php

namespace Tests\Feature;

use App\Mail\ContactFormMail;
use App\Models\ContactEnquiry;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContactAndQuoteTest extends TestCase
{
    use RefreshDatabase;

    private array $enquiry = ['name' => 'Test', 'email' => 'test@example.com', 'phone' => '+94 77 000 0000', 'message' => 'Hello'];

    private array $quote = ['name' => 'Test', 'phone' => '+94 77 000 0000', 'email' => 'test@example.com', 'city' => 'Colombo', 'property_type' => 'House'];

    private function product(): Product
    {
        return Product::create(['name' => 'Ashford', 'category' => 'TIMBERLINE', 'description' => 'd', 'price' => 0, 'image' => 'x.png']);
    }

    public function test_enquiry_is_emailed_saved_and_lands_on_thank_you_page(): void
    {
        Mail::fake();

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        Mail::assertSent(ContactFormMail::class);
        $this->assertNotNull(ContactEnquiry::first()->emailed_at);
        $this->get('/contact-us/thank-you')->assertOk()->assertSee('within 24 hours')->assertSee('GTM-5TR2NRB5');
    }

    public function test_enquiry_is_kept_when_the_mail_server_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new Exception('535 Incorrect authentication data'));

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        $this->assertNull(ContactEnquiry::first()->emailed_at);
    }

    public function test_enquiry_is_still_emailed_when_it_cannot_be_saved(): void
    {
        Mail::fake();
        Schema::drop('contact_enquiries');

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        Mail::assertSent(ContactFormMail::class);
    }

    public function test_visitor_sees_an_error_and_keeps_their_message_when_save_and_email_both_fail(): void
    {
        Mail::shouldReceive('to')->andThrow(new Exception('535 Incorrect authentication data'));
        Schema::drop('contact_enquiries');

        $this->from('/contact-us')->post('/contact-us', $this->enquiry)
            ->assertRedirect('/contact-us')
            ->assertSessionHasErrors('form')
            ->assertSessionHasInput('message', 'Hello');

        $this->get('/contact-us')->assertSee('could not send your message')->assertSee('Hello');
    }

    public function test_phone_and_email_are_links(): void
    {
        $this->get('/contact-us')
            ->assertSee('href="tel:+94777385059"', false)
            ->assertSee('href="mailto:kirinfloors@sais.lk"', false)
            ->assertDontSee('href="tel:+94"', false);
    }

    public function test_quote_form_requires_the_five_fields(): void
    {
        $this->post('/checkout', [])->assertSessionHasErrors(['name', 'phone', 'email', 'city', 'property_type']);
        $this->post('/checkout', [])->assertSessionDoesntHaveErrors('whatsapp');
        $this->post('/checkout', ['property_type' => 'Castle'])->assertSessionHasErrors('property_type');
    }

    public function test_same_floor_area_from_cart_to_saved_request(): void
    {
        $product = $this->product();

        $this->post('/cart', ['product_id' => $product->id, 'quantity' => 1, 'height' => 12.5, 'width' => 10]);

        foreach (['/cart', '/checkout'] as $page) {
            $this->get($page)->assertSee('125.00 sq ft')->assertSee('On quote')->assertDontSee('Rs.')->assertDontSee('Linear');
        }

        $this->post('/checkout', $this->quote)->assertRedirect('/order/success');

        $order = Order::first();
        $this->assertSame('House', $order->property_type);
        $this->assertEquals(125, $order->order_items()->first()->quantity);
        $this->get('/order/success')->assertSee('Quote Request Received')->assertDontSee('Order Confirmed');
    }

    public function test_item_can_be_removed_without_dimensions(): void
    {
        $product = $this->product();
        $this->post('/cart', ['product_id' => $product->id, 'quantity' => 1, 'height' => 12, 'width' => 10]);

        $this->post('/cart', ['product_id' => $product->id, 'quantity' => 0])->assertSessionHasNoErrors();

        $this->assertSame([], session('cart'));
    }
}
