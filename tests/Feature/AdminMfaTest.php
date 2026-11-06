<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminMfaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_reach_their_profile_to_turn_on_mfa(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('Authenticator app');
    }

    public function test_mfa_secret_and_recovery_codes_are_stored_encrypted_and_hidden(): void
    {
        $user = User::factory()->create();
        $user->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $user->saveAppAuthenticationRecoveryCodes(['aaaa-bbbb', 'cccc-dddd']);

        $raw = DB::table('users')->where('id', $user->id)->first();
        $this->assertStringNotContainsString('JBSWY3DPEHPK3PXP', $raw->app_authentication_secret);
        $this->assertStringNotContainsString('aaaa-bbbb', $raw->app_authentication_recovery_codes);

        $fresh = $user->fresh();
        $this->assertSame('JBSWY3DPEHPK3PXP', $fresh->getAppAuthenticationSecret());
        $this->assertSame(['aaaa-bbbb', 'cccc-dddd'], $fresh->getAppAuthenticationRecoveryCodes());
        $this->assertArrayNotHasKey('app_authentication_secret', $fresh->toArray());
    }
}
