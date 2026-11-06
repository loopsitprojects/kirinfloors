<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTimezoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_shows_sri_lankan_time_for_times_stored_in_utc(): void
    {
        $enquiry = ContactEnquiry::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '0777000000',
            'message' => 'Hello',
        ]);
        $enquiry->forceFill(['created_at' => '2026-11-05 05:08:10'])->saveQuietly();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get('/admin/contact-enquiries')
            ->assertOk()
            ->assertSee('Nov 5, 2026 10:38:10')
            ->assertDontSee('Nov 5, 2026 05:08:10');
    }
}
