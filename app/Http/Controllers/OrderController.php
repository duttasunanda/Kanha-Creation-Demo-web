<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display user's orders.
     */
    public function index(): View
    {
        // For now, return empty orders until Order model is properly set up
        $orders = [];
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function show($orderId): View
    {
        // Mock order data for now
        $order = (object) [
            'id' => $orderId,
            'order_number' => 'ORD-' . $orderId,
            'total_amount' => 5000,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'items' => []
        ];

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel($orderId)
    {
        return back()->with('success', 'Order cancelled successfully.');
    }
}
