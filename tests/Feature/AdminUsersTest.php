<?php

namespace Tests\Feature;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    private User $me;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->me = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->me);
    }

    public function test_new_users_start_without_admin_access(): void
    {
        $this->assertFalse(User::factory()->create()->fresh()->is_admin);
    }

    public function test_admin_can_create_a_user_and_grant_access(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Nimal', 'email' => 'nimal@example.com', 'password' => 'long-enough-pass', 'is_admin' => true])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'nimal@example.com')->first();
        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('long-enough-pass', $user->password));
    }

    public function test_short_passwords_are_refused(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Nimal', 'email' => 'nimal@example.com', 'password' => 'short'])
            ->call('create')
            ->assertHasFormErrors(['password']);
    }

    public function test_access_can_be_switched_off_for_someone_else(): void
    {
        $other = User::factory()->create(['is_admin' => true]);

        Livewire::test(ListUsers::class)->call('updateTableColumnState', 'is_admin', (string) $other->getKey(), false);

        $this->assertFalse($other->fresh()->is_admin);
    }

    public function test_you_cannot_switch_off_or_delete_yourself(): void
    {
        Livewire::test(ListUsers::class)->call('updateTableColumnState', 'is_admin', (string) $this->me->getKey(), false);
        $this->assertTrue($this->me->fresh()->is_admin);

        Livewire::test(EditUser::class, ['record' => $this->me->getKey()])
            ->fillForm(['is_admin' => false])
            ->call('save');
        $this->assertTrue($this->me->fresh()->is_admin);

        Livewire::test(ListUsers::class)->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->me));
    }

    public function test_editing_without_a_password_keeps_the_old_one(): void
    {
        $other = User::factory()->create(['password' => 'original-password']);

        Livewire::test(EditUser::class, ['record' => $other->getKey()])
            ->fillForm(['name' => 'Renamed', 'password' => ''])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Renamed', $other->fresh()->name);
        $this->assertTrue(Hash::check('original-password', $other->fresh()->password));
    }

    public function test_grant_command_gives_access_from_the_server(): void
    {
        $user = User::factory()->create(['email' => 'locked@example.com']);

        $this->assertSame(0, Artisan::call('admin:grant', ['email' => 'locked@example.com']));
        $this->assertTrue($user->fresh()->is_admin);
        $this->assertSame(1, Artisan::call('admin:grant', ['email' => 'nobody@example.com']));
    }

    public function test_migration_keeps_access_for_users_who_already_existed(): void
    {
        $migration = require database_path('migrations/2026_11_06_000001_add_is_admin_to_users.php');
        $user = User::factory()->create();

        $migration->down();
        $migration->up();

        $this->assertTrue((bool) DB::table('users')->where('id', $user->id)->value('is_admin'));
    }

    public function test_lost_phone_authenticator_can_be_reset_for_someone_else(): void
    {
        $other = User::factory()->create(['is_admin' => true]);
        $other->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $other->saveAppAuthenticationRecoveryCodes(['aaaa-bbbb']);
        $this->me->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        Livewire::test(ListUsers::class)
            ->assertActionHidden(TestAction::make('resetAuthenticator')->table($this->me))
            ->callAction(TestAction::make('resetAuthenticator')->table($other));

        $this->assertNull($other->fresh()->getAppAuthenticationSecret());
        $this->assertNull($other->fresh()->getAppAuthenticationRecoveryCodes());
        $this->assertNotNull($this->me->fresh()->getAppAuthenticationSecret());
    }
}
