<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('table')->latest()->paginate(15);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $tables = Table::all();
        $products = Product::available()->with('category')->get();
        $categories = \App\Models\Category::all();
        return view('orders.create', compact('tables', 'products', 'categories'));
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $items = [];

            foreach ($request->products as $item) {
                if ($item['quantity'] <= 0) continue;

                $product = Product::findOrFail($item['id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ];
            }

            if (empty($items)) {
                return back()->with('error', 'Vui lòng chọn ít nhất một món để đặt!');
            }

            $order = Order::create([
                'table_id' => $request->table_id,
                'total_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            foreach ($items as $item) {
                $order->orderItems()->create($item);
            }

            // Update table status
            Table::where('id', $request->table_id)->update(['status' => 'occupied']);

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Đã tạo đơn hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['table', 'orderItems.product']);
        return view('orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        $order->table->update(['status' => 'empty']);
        
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã thanh toán và hoàn tất!');
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        $order->table->update(['status' => 'empty']);
        
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy!');
    }
}
