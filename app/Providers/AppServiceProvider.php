<?php

namespace App\Providers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Facades\FilamentTimezone;
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
        // Uploads become public files, so only plain image formats (no SVG, which can carry scripts).
        FileUpload::configureUsing(fn (FileUpload $upload) => $upload->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']));
        RichEditor::configureUsing(fn (RichEditor $editor) => $editor->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']));

        // Times stay stored in UTC; the admin panel shows them in Sri Lankan time.
        FilamentTimezone::set('Asia/Colombo');

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
