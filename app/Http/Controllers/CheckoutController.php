<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Recaptcha;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        return view('checkout', compact('cart', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\s-]{7,}$/'],
            'whatsapp' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\s-]{7,}$/'],
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'property_type' => 'required|in:House,Commercial property',
        ]);

        if (! Recaptcha::passes($request, 'quote')) {
            return back()->withInput()->withErrors([
                'form' => 'Sorry, we could not verify your request. Please try again, or call or email us directly.',
            ]);
        }

        $order = Order::create($validated + ['status' => 'pending']);

        $cart = session()->get('cart', []);
        foreach ($cart as $productId => $prod) {
            $product = Product::find($productId);
            if ($product) {
                $floorArea = CartController::floorArea($prod);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $floorArea,
                    'price' => $product->price * $floorArea,
                ]);
            }
        }            

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('thank-you-order')->with('success', 'Quote request received!');
    }
}
