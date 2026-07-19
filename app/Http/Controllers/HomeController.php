<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')
            ->latest()
            ->take(10)
            ->get();
        $totalProducts = Product::count();
        
        return view('home', compact('categories', 'products', 'totalProducts'));
    }

    public function categoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::with('category')
            ->where('category_id', $id)
            ->latest()
            ->get();
        $categories = Category::withCount('products')->get();

        return view('category-products', compact('category', 'products', 'categories'));
    }
}
