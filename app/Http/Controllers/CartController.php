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

        return view('cart', compact('cart', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:0|max:100',
            'height' => 'exclude_if:quantity,0|required|numeric|min:0.01|max:1000',
            'width' => 'exclude_if:quantity,0|required|numeric|min:0.01|max:1000',
        ]);

        $cart = session()->get('cart', []);
        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        $height = $request->input('height', 0);
        $width = $request->input('width', 0);

        // Floor area in sq ft
        $floorArea = $height * $width;

        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
                $cart[$productId]['floor_area'] = self::floorArea($cart[$productId]) + $floorArea;
            } else {
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'height' => $height,
                    'width' => $width,
                    'floor_area' => $floorArea,
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Carts saved before floor_area existed only hold the dimensions.
     */
    public static function floorArea(array $item): float
    {
        return $item['floor_area'] ?? (float) ($item['height'] ?? 0) * (float) ($item['width'] ?? 0);
    }
}
