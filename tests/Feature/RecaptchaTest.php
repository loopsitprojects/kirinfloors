<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{
    use RefreshDatabase;

    private const VERIFY = 'https://www.google.com/recaptcha/api/siteverify';

    private array $enquiry = ['name' => 'Test', 'email' => 'test@example.com', 'message' => 'Hello', 'g-recaptcha-response' => 'token'];

    private array $quote = ['name' => 'Test', 'phone' => '+94 77 000 0000', 'email' => 'test@example.com', 'city' => 'Colombo', 'property_type' => 'House', 'g-recaptcha-response' => 'token'];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        config(['services.recaptcha' => ['site_key' => 'site-key', 'secret_key' => 'secret-key', 'min_score' => 0.5]]);
    }

    private function google(array $body, int $status = 200): void
    {
        Http::fake([self::VERIFY => Http::response($body, $status)]);
    }

    public function test_real_visitor_gets_through_the_contact_form(): void
    {
        $this->google(['success' => true, 'score' => 0.9, 'action' => 'contact']);

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        $this->assertSame(1, ContactEnquiry::count());
        Http::assertSent(fn ($request) => $request->url() === self::VERIFY
            && $request['secret'] === 'secret-key'
            && $request['response'] === 'token');
    }

    public function test_real_visitor_gets_through_the_quote_form_at_the_minimum_score(): void
    {
        $this->google(['success' => true, 'score' => 0.5, 'action' => 'quote']);

        $this->withSession(['cart' => [999 => ['quantity' => 1, 'height' => 10, 'width' => 10, 'floor_area' => 100]]])->post('/checkout', $this->quote)->assertRedirect('/order/success');

        $this->assertSame(1, Order::count());
    }

    public function test_low_score_on_contact_form_is_stopped_and_keeps_the_message(): void
    {
        $this->google(['success' => true, 'score' => 0.1, 'action' => 'contact']);

        $this->from('/contact-us')->post('/contact-us', $this->enquiry)
            ->assertRedirect('/contact-us')
            ->assertSessionHasErrors('form')
            ->assertSessionHasInput('message', 'Hello');

        $this->assertSame(0, ContactEnquiry::count());
        Mail::assertNothingSent();
    }

    public function test_low_score_on_quote_form_is_stopped(): void
    {
        $this->google(['success' => true, 'score' => 0.1, 'action' => 'quote']);

        $this->withSession(['cart' => [999 => ['quantity' => 1, 'height' => 10, 'width' => 10, 'floor_area' => 100]]])->post('/checkout', $this->quote)->assertSessionHasErrors('form');

        $this->assertSame(0, Order::count());
    }

    public function test_token_from_a_different_form_is_rejected(): void
    {
        $this->google(['success' => true, 'score' => 0.9, 'action' => 'contact']);
        $this->withSession(['cart' => [999 => ['quantity' => 1, 'height' => 10, 'width' => 10, 'floor_area' => 100]]])->post('/checkout', $this->quote)->assertSessionHasErrors('form');
        $this->assertSame(0, Order::count());
    }

    public function test_missing_malformed_or_invalid_tokens_are_rejected(): void
    {
        $this->google(['success' => false, 'error-codes' => ['timeout-or-duplicate']]);

        foreach ([null, '', ['not', 'a', 'string'], 'token'] as $token) {
            $this->post('/contact-us', ['g-recaptcha-response' => $token] + $this->enquiry)->assertSessionHasErrors('form');
        }

        $this->assertSame(0, ContactEnquiry::count());
    }

    public function test_enquiry_is_kept_when_google_cannot_be_reached(): void
    {
        Http::fake([self::VERIFY => fn () => throw new ConnectionException('timeout')]);

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        $this->assertSame(1, ContactEnquiry::count());
    }

    public function test_enquiry_is_kept_when_google_returns_a_server_error(): void
    {
        $this->google([], 503);

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        $this->assertSame(1, ContactEnquiry::count());
    }

    public function test_enquiry_is_kept_when_our_secret_key_is_wrong(): void
    {
        $this->google(['success' => false, 'error-codes' => ['invalid-input-secret']]);

        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');

        $this->assertSame(1, ContactEnquiry::count());
    }

    public function test_forms_work_without_google_until_keys_are_added(): void
    {
        config(['services.recaptcha.secret_key' => null]);
        Http::fake();

        unset($this->enquiry['g-recaptcha-response']);
        $this->post('/contact-us', $this->enquiry)->assertRedirect('/contact-us/thank-you');
        Http::assertNothingSent();

        $this->get('/contact-us')->assertDontSee('recaptcha/api.js');
    }

    public function test_script_loads_only_on_the_contact_page_form_with_the_notice(): void
    {
        $this->get('/contact-us')
            ->assertSee('recaptcha/api.js?render=site-key', false)
            ->assertSee('data-recaptcha="contact"', false)
            ->assertSee('protected by reCAPTCHA')
            ->assertDontSee('secret-key');

        $this->get('/contact-us/thank-you')->assertDontSee('recaptcha/api.js');
    }
}
