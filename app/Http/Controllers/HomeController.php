<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Mock data for now - will be replaced with real database queries later
        $categories = [
            (object) ['id' => 1, 'name' => 'Chairs', 'slug' => 'chairs', 'image' => 'chair-category.jpg'],
            (object) ['id' => 2, 'name' => 'Tables', 'slug' => 'tables', 'image' => 'table-category.jpg'],
            (object) ['id' => 3, 'name' => 'Storage', 'slug' => 'storage', 'image' => 'storage-category.jpg'],
            (object) ['id' => 4, 'name' => 'Beds', 'slug' => 'beds', 'image' => 'bed-category.jpg'],
        ];
        
        $products = [
            (object) ['id' => 1, 'name' => 'Ergonomic Office Chair', 'price' => 15000, 'image' => 'chair1.jpg', 'slug' => 'ergonomic-office-chair'],
            (object) ['id' => 2, 'name' => 'Wooden Dining Table', 'price' => 25000, 'image' => 'table1.jpg', 'slug' => 'wooden-dining-table'],
            (object) ['id' => 3, 'name' => 'Storage Cabinet', 'price' => 12000, 'image' => 'cabinet1.jpg', 'slug' => 'storage-cabinet'],
            (object) ['id' => 4, 'name' => 'King Size Bed', 'price' => 35000, 'image' => 'bed1.jpg', 'slug' => 'king-size-bed'],
        ];

        return view('home', compact('categories', 'products'));
    }
}
