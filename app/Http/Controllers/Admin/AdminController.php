<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Get dashboard statistics
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        
        // Recent orders
        $recentOrders = Order::with(['user'])
            ->latest()
            ->take(10)
            ->get();
        
        // Top selling products
        $topProducts = Product::withCount(['orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();
        
        // Monthly revenue data for chart
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders', 
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'monthlyRevenue'
        ));
    }
}
