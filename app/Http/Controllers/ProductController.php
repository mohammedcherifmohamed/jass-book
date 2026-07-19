<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        $similarProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->limit(4)
            ->get();
        
        return view('details', compact('product', 'similarProducts'));
    }
}
