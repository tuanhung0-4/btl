<?php

namespace App\Http\Controllers; #Khai báo controller này thuộc namespace của Laravel

use App\Http\Requests\OrderRequest; #Sử dụng lớp OrderRequest để xử lý các yêu cầu liên quan đến đơn hàng
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\OrderItem;
use App\Models\Category; #Import các model
use Illuminate\Http\Request; #Nhận request từ khách hàng
use Illuminate\Support\Facades\DB; #Sử dụng DB facade để thực hiện các giao dịch cơ sở dữ liệu
use Carbon\Carbon; #Sử dụng Carbon để xử lý ngày tháng

class OrderController extends Controller #Định nghĩa lớp OrderController kế thừa từ Controller của Laravel
{
    public function index(Request $request) #Hiển thị danh sách đơn hàng
    {
        $query = Order::with('table');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
 
        // Search by ID (Exact match for numeric, like search for string if applicable)
        if ($request->filled('search')) {
            $search = $request->search;
            if (is_numeric($search)) {
                $query->where('id', $search);
            } else {
                $query->where('id', 'like', "%$search%");
            }
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        return view('orders.index', compact('orders'));
    }

    public function create() #Hiển thị form tạo đơn hàng mới
    {
        $tables = Table::all();
        $products = Product::available()->with('category')->get();
        $categories = Category::all();
        return view('orders.create', compact('tables', 'products', 'categories'));
    }

    public function store(OrderRequest $request) #Xử lý lưu đơn hàng mới vào cơ sở dữ liệu
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
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
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

    public function show(Order $order) #hiển thị chi tiết đơn hàng 
    {
        $order->load(['table', 'orderItems.product']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order) #Hiển thị form sửa đơn hàng
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)->with('error', 'Không thể sửa đơn hàng đã hoàn tất hoặc đã hủy.');
        }
  
        $tables = Table::all();
        $products = Product::available()->with('category')->get();
        $categories = Category::all();
        $order->load('orderItems');
        
        return view('orders.edit', compact('order', 'tables', 'products', 'categories'));
    }

    public function update(Request $request, Order $order) #Xử lý cập nhật đơn hàng vào cơ sở dữ liệu
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)->with('error', 'Không thể sửa đơn hàng đã hoàn tất hoặc đã hủy.');
        }

        try {
            DB::beginTransaction();

            // Clear old items
            $order->orderItems()->delete();

            $totalAmount = 0;
            foreach ($request->products as $item) {
                if ($item['quantity'] <= 0) continue;

                $product = Product::findOrFail($item['id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);
            }

            $order->update([
                'table_id' => $request->table_id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'total_amount' => $totalAmount,
            ]);

            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Cập nhật đơn hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function complete(Order $order) #Xử lý hoàn tất đơn hàng và cập nhật trạng thái bàn
    {
        $order->update(['status' => 'completed']);
        $order->table()->update(['status' => 'empty']);
        
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã thanh toán và hoàn tất!');
    }

    public function cancel(Order $order) #Xử lý hủy đơn hàng và cập nhật trạng thái bàn
    {
        $order->update(['status' => 'cancelled']);
        $order->table()->update(['status' => 'empty']);
        
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy!');
    }

    public function destroy(Order $order) #Xử lý xóa đơn hàng khỏi cơ sở dữ liệu
    {
        if ($order->status === 'pending') {
            $order->table()->update(['status' => 'empty']);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đã xóa đơn hàng!');
    }
}
