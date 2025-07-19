<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mock users data
        $users = [
            (object) [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@nilkamal.com',
                'role' => 'admin',
                'email_verified' => true,
                'created_at' => '2024-01-01',
                'orders_count' => 0
            ],
            (object) [
                'id' => 2,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role' => 'customer',
                'email_verified' => true,
                'created_at' => '2024-01-15',
                'orders_count' => 3
            ],
            (object) [
                'id' => 3,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role' => 'customer',
                'email_verified' => true,
                'created_at' => '2024-01-20',
                'orders_count' => 1
            ],
            (object) [
                'id' => 4,
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'role' => 'customer',
                'email_verified' => false,
                'created_at' => '2024-02-01',
                'orders_count' => 0
            ]
        ];
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Mock user creation
        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = (object) [
            'id' => $id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'customer',
            'email_verified' => true,
            'created_at' => '2024-01-15',
            'orders_count' => 3,
            'total_spent' => 45000,
            'last_login' => '2024-01-25',
            'addresses' => [
                (object) [
                    'type' => 'shipping',
                    'street' => '123 Main Street',
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'pincode' => '400001'
                ]
            ]
        ];
        
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = (object) [
            'id' => $id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'customer',
            'email_verified' => true
        ];
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Mock user update
        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Mock user deletion
        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully.');
    }

    public function toggleAdmin(Request $request, $id)
    {
        // Mock admin toggle
        $newRole = $request->input('make_admin') ? 'admin' : 'customer';
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'User role updated to ' . $newRole);
    }
}
