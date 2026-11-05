<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Storage::macro('publicUrl', function ($path) {
            $disk = Storage::disk('public');
            if ($disk->exists($path)) {
                return $disk->url($path);
            }
            return null;
        });

        // if session have cart, make sure the array items have ['quantity'], else clear the cart
        if (session()->has('cart')) {
            $cart = session()->get('cart', []);
            foreach ($cart as $key => $item) {
                if (!is_array($item) || !array_key_exists('quantity', $item)) {
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
        }
    }
}
