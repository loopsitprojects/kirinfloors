<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Recaptcha
{
    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    // Google answering with these means our setup is wrong, not that the visitor is a bot.
    private const SETUP_ERRORS = ['missing-input-secret', 'invalid-input-secret', 'bad-request'];

    public static function enabled(): bool
    {
        return filled(config('services.recaptcha.site_key')) && filled(config('services.recaptcha.secret_key'));
    }

    public static function passes(Request $request, string $action): bool
    {
        if (! self::enabled()) {
            return true;
        }

        $token = $request->input('g-recaptcha-response');

        if (! is_string($token) || $token === '') {
            Log::warning('reCAPTCHA rejected: no token', ['action' => $action]);

            return false;
        }

        // A Google outage or a setup mistake must not cost Kirin a real enquiry.
        try {
            $response = Http::asForm()->timeout(5)->post(self::VERIFY_URL, [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
            ]);

            if (! $response->successful()) {
                Log::error('reCAPTCHA unavailable, form allowed', ['status' => $response->status()]);

                return true;
            }
        } catch (Throwable $e) {
            report($e);

            return true;
        }

        $result = $response->json();

        if (! ($result['success'] ?? false)) {
            $errors = $result['error-codes'] ?? [];

            if (array_intersect($errors, self::SETUP_ERRORS)) {
                Log::error('reCAPTCHA setup problem, form allowed', ['errors' => $errors]);

                return true;
            }

            Log::warning('reCAPTCHA rejected: invalid token', ['action' => $action, 'errors' => $errors]);

            return false;
        }

        $score = (float) ($result['score'] ?? 0);
        $passed = ($result['action'] ?? null) === $action
            && $score >= (float) config('services.recaptcha.min_score');

        if (! $passed) {
            Log::warning('reCAPTCHA rejected: low score or wrong action', [
                'action' => $action,
                'returned_action' => $result['action'] ?? null,
                'score' => $score,
            ]);
        }

        return $passed;
    }
}
