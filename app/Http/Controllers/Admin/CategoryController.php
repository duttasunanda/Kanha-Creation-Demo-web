<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Mock categories data
        $categories = [
            (object) [
                'id' => 1,
                'name' => 'Living Room',
                'slug' => 'living-room',
                'description' => 'Comfortable living room furniture',
                'products_count' => 25,
                'created_at' => '2024-01-01'
            ],
            (object) [
                'id' => 2,
                'name' => 'Bedroom',
                'slug' => 'bedroom',
                'description' => 'Cozy bedroom furniture',
                'products_count' => 18,
                'created_at' => '2024-01-02'
            ],
            (object) [
                'id' => 3,
                'name' => 'Dining Room',
                'slug' => 'dining-room',
                'description' => 'Elegant dining room furniture',
                'products_count' => 12,
                'created_at' => '2024-01-03'
            ]
        ];
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Mock category creation
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = (object) [
            'id' => $id,
            'name' => 'Sample Category',
            'slug' => 'sample-category',
            'description' => 'Sample category description',
            'products_count' => 10
        ];
        
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = (object) [
            'id' => $id,
            'name' => 'Sample Category',
            'slug' => 'sample-category',
            'description' => 'Sample category description'
        ];
        
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Mock category update
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        // Mock category deletion
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category deleted successfully.');
    }
}
