<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function index(): View
    {
        // Mock user data for now
        $user = (object) [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+91 9876543210',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $recentOrders = [];
        
        return view('profile.index', compact('user', 'recentOrders'));
    }

    /**
     * Show edit profile form.
     */
    public function edit(): View
    {
        $user = (object) [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+91 9876543210'
        ];
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        // Mock update - just redirect back with success
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
