<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $order = Order::create([
            'status' => 'pending',
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'address_line_2' => $request->input('address_line_2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'email' => $request->input('email'),
        ]);

        $cart = session()->get('cart', []);
        foreach ($cart as $productId => $prod) {
            $product = Product::find($productId);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $prod['linear_feet'],
                    'price' => $product->price * $prod['linear_feet'],
                ]);
            }
        }            

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('thank-you-order')->with('success', 'Order placed successfully!');
    }
}
