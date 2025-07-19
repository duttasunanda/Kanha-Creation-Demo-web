<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display products under a category.
     */
    public function show(Category $category, Request $request): View
    {
        // Load products in this category with relations
        // Build product query for this category via slug relationship
        $productsQuery = Product::with(['category', 'images'])
            ->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category->slug);
            })
            ->active()
            ->inStock();

        // Optional filters (price, search)
        if ($request->filled('search')) {
            $q = $request->input('search');
            $productsQuery->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%");
            });
        }
        if ($request->filled('min_price')) {
            $productsQuery->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $productsQuery->where('price', '<=', $request->input('max_price'));
        }

        $products = $productsQuery->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
