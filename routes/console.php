<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:grant {email}', function (string $email) {
    $user = App\Models\User::where('email', $email)->first();

    if (! $user) {
        $this->error("No user with email {$email}.");

        return 1;
    }

    $user->forceFill(['is_admin' => true])->save();
    $this->info("{$email} can now sign in to /admin.");
})->purpose('Give a user access to the admin panel (for when nobody can sign in)');
