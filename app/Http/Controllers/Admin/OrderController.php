<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Mock orders data
        $orders = [
            (object) [
                'id' => 1,
                'order_number' => 'ORD-2024-001',
                'user_name' => 'John Doe',
                'total' => 25000,
                'status' => 'pending',
                'created_at' => '2024-01-15',
                'items_count' => 3
            ],
            (object) [
                'id' => 2,
                'order_number' => 'ORD-2024-002',
                'user_name' => 'Jane Smith',
                'total' => 18500,
                'status' => 'processing',
                'created_at' => '2024-01-14',
                'items_count' => 2
            ],
            (object) [
                'id' => 3,
                'order_number' => 'ORD-2024-003',
                'user_name' => 'Mike Johnson',
                'total' => 32000,
                'status' => 'shipped',
                'created_at' => '2024-01-13',
                'items_count' => 4
            ],
            (object) [
                'id' => 4,
                'order_number' => 'ORD-2024-004',
                'user_name' => 'Sarah Wilson',
                'total' => 12500,
                'status' => 'delivered',
                'created_at' => '2024-01-12',
                'items_count' => 1
            ]
        ];
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = (object) [
            'id' => $id,
            'order_number' => 'ORD-2024-00' . $id,
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'user_phone' => '+91 9876543210',
            'total' => 25000,
            'subtotal' => 23000,
            'tax' => 2000,
            'shipping' => 0,
            'status' => 'pending',
            'created_at' => '2024-01-15',
            'shipping_address' => [
                'street' => '123 Main Street',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400001'
            ],
            'items' => [
                (object) [
                    'product_name' => 'Modern Sofa Set',
                    'quantity' => 1,
                    'price' => 15000,
                    'total' => 15000
                ],
                (object) [
                    'product_name' => 'Coffee Table',
                    'quantity' => 1,
                    'price' => 8000,
                    'total' => 8000
                ]
            ]
        ];
        
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $status = $request->input('status');
        
        // Mock order update
        return redirect()->route('admin.orders.show', $id)
                        ->with('success', 'Order status updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        
        // Mock status update
        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order status updated to ' . $status);
    }
}
