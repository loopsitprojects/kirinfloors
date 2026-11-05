<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $productsByCategory = Product::orderBy('category')->orderBy('name')->get()->groupBy('category');
        return view('products', compact('products', 'productsByCategory'));
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
