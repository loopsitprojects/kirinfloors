<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactEnquiries\Pages\ListContactEnquiries;
use App\Mail\ContactFormMail;
use App\Models\ContactEnquiry;
use App\Models\User;
use Exception;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class SendEnquiryEmailTest extends TestCase
{
    use RefreshDatabase;

    private ContactEnquiry $enquiry;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.contact_email' => 'inbox@example.com']);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create());

        $this->enquiry = ContactEnquiry::create(['name' => 'Asha', 'email' => 'asha@example.com', 'phone' => '0777000000', 'message' => 'Need a quote']);
    }

    private function clickSend(): void
    {
        Livewire::test(ListContactEnquiries::class)
            ->callAction(TestAction::make('sendEmail')->table($this->enquiry));
    }

    public function test_button_emails_the_enquiry_to_contact_email_and_records_the_time(): void
    {
        Mail::fake();

        $this->clickSend();

        Mail::assertSent(ContactFormMail::class, fn ($mail) => $mail->hasTo('inbox@example.com')
            && $mail->data['name'] === 'Asha'
            && $mail->data['email'] === 'asha@example.com'
            && $mail->data['phone'] === '0777000000'
            && $mail->data['message'] === 'Need a quote');
        $this->assertNotNull($this->enquiry->fresh()->emailed_at);
    }

    public function test_email_body_renders_from_a_saved_enquiry(): void
    {
        $html = (new ContactFormMail($this->enquiry->only(['name', 'email', 'phone', 'message'])))->render();

        $this->assertStringContainsString('Need a quote', $html);
        $this->assertStringContainsString('asha@example.com', $html);
    }

    public function test_failed_send_is_not_marked_as_emailed(): void
    {
        Mail::shouldReceive('to')->andThrow(new Exception('SMTP down'));

        $this->clickSend();

        $this->assertNull($this->enquiry->fresh()->emailed_at);
    }

    public function test_nothing_is_sent_when_contact_email_is_missing(): void
    {
        config(['services.contact_email' => '']);
        Mail::fake();

        $this->clickSend();

        Mail::assertNothingSent();
        $this->assertNull($this->enquiry->fresh()->emailed_at);
    }

    public function test_button_says_resend_after_it_has_been_sent(): void
    {
        $this->enquiry->update(['emailed_at' => now()]);

        Livewire::test(ListContactEnquiries::class)
            ->assertActionHasLabel(TestAction::make('sendEmail')->table($this->enquiry), 'Resend');
    }
}
