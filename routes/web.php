<?php

use App\Http\Controllers\ProductController;
use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $data = json_decode(Storage::get('home-content.json'), true);
    foreach ($data['hero_slides'] as &$slide) {
        $slide['title'] = nl2br($slide['title']);
        // convert words sorrounded by * to <strong> tags
        $slide['title'] = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $slide['title']);
    }
    // 4 latest blogs
    $data['products'] = Product::whereIn('category', ['TIMBERLINE', 'STONEDGE'])->latest()->take(12)->get();
    $data['latest_blogs'] = BlogPost::latest()->take(4)->get();
    return view('home', ['data' => $data]);
})->name('home');

Route::get('/about-us', function () {
    $data = json_decode(Storage::get('about-content.json'), true);
    return view('about_us', ['data' => $data]);
})->name('about_us');

Route::get('/services', function () {
    $data = json_decode(Storage::get('services-content.json'), true);
    return view('services', ['data' => $data]);
})->name('services');

Route::get('/resource', function () {
    $data = json_decode(Storage::get('technical-content.json'), true);
    return view('technical_data', ['data' => $data]);
})->name('technical_data');


Route::get('/contact-us', function () {
    $data = json_decode(Storage::get('contact-content.json'), true);
    return view('contact', ['data' => $data]);
})->name('contact_us');

Route::get('/contact-us/thank-you', function () {
    return view('thank-you-contact');
})->name('thank-you-contact');

Route::post('/contact-us', [App\Http\Controllers\ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact_us.store');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::resource('cart', App\Http\Controllers\CartController::class)->only(['index', 'store']);
Route::resource('checkout', App\Http\Controllers\CheckoutController::class)
    ->only(['index', 'store'])
    ->middlewareFor('store', 'throttle:5,1');

Route::get('/order/success', function () {
    return view('thank-you-order');
})->name('thank-you-order');

Route::resource('blog', App\Http\Controllers\BlogController::class)->only(['index', 'show']);
Route::resource('press-release', App\Http\Controllers\PressReleaseController::class)->only(['index', 'show']);
