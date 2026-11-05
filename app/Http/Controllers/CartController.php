<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        
        // Calculate total
        $total = 0;
        foreach ($products as $product) {
            if (isset($cart[$product->id])) {
                $cartItem = is_array($cart[$product->id]) ? $cart[$product->id] : ['quantity' => $cart[$product->id], 'linear_feet' => 0];
                $linearFeet = $cartItem['linear_feet'] ?? 0;
                $total += 0; // $product->price * $linearFeet;
            }
        }
        
        return view('cart', compact('cart', 'products', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $height = $request->input('height', 0);
        $width = $request->input('width', 0);
        
        // Calculate linear feet (perimeter formula: 2 * (height + width))
        $linearFeet = 2 * ($height + $width);
        
        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
                $cart[$productId]['linear_feet'] += $linearFeet;
            } else {
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'height' => $height,
                    'width' => $width,
                    'linear_feet' => $linearFeet
                ];
            }
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
