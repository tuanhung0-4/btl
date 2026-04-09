<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Table;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $startDate = $request->get('start_date', now()->subDays(6)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Revenue by day for Chart
        $revenueData = Order::where('status', 'completed')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        
        // Fill missing dates with 0
        $current = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        while ($current->lte($end)) {
            $dateStr = $current->format('Y-m-d');
            $chartLabels[] = $current->format('d/m');
            $dayRevenue = $revenueData->firstWhere('date', $dateStr);
            $chartValues[] = $dayRevenue ? $dayRevenue->total : 0;
            $current->addDay();
        }

        // Top Selling Products
        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->with('product')
            ->get();

        return view('statistics.index', compact('chartLabels', 'chartValues', 'bestSellers', 'startDate', 'endDate'));
    }
}
