<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Table;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $occupiedTables = Table::where('status', 'occupied')->count();

        // Top 5 best selling products (completed orders only)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get();

        // Revenue by category
        $revenueByCategory = Category::with(['products.orderItems' => function($query) {
            $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                  ->where('orders.status', 'completed');
        }])->get()->map(function($category) {
            $revenue = $category->products->flatMap->orderItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
            return [
                'name' => $category->name,
                'revenue' => $revenue
            ];
        });

        return view('dashboard', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalProducts', 
            'occupiedTables',
            'topProducts',
            'revenueByCategory'
        ));
    }

    public function statistics(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        // 1. Revenue Statistics (Month, Quarter, Year)
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereYear('updated_at', $year)
            ->select(
                DB::raw('MONTH(updated_at) as month'), 
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $quarterlyRevenue = Order::where('status', 'completed')
            ->whereYear('updated_at', $year)
            ->select(DB::raw('QUARTER(updated_at) as quarter'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('quarter')
            ->orderBy('quarter')
            ->get();

        $yearlyRevenue = Order::where('status', 'completed')
            ->whereYear('updated_at', $year)
            ->sum('total_amount');

        // 2. Product Statistics (Quantity Sold + Best Sellers)
        $productStats = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * order_items.price) as total_revenue'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereYear('orders.updated_at', $year)
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->get();

        // 3. Potential Customers (Based on name/phone since we don't have separate table)
        // Analyzing "customer_name" or "customer_phone"
        $topCustomers = Order::where('status', 'completed')
            ->whereNotNull('customer_name')
            ->select('customer_name', 'customer_phone', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_spent'))
            ->groupBy('customer_name', 'customer_phone')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();

        return view('statistics.index', compact(
            'monthlyRevenue', 
            'quarterlyRevenue', 
            'yearlyRevenue', 
            'productStats', 
            'topCustomers',
            'year'
        ));
    }
}
