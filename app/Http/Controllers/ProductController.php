<?php // Khai báo file PHP

namespace App\Http\Controllers; // Không gian tên cho controller

use App\Http\Requests\ProductRequest; // Form Request kiểm tra dữ liệu sản phẩm
use App\Models\Category; // Model Category tương tác bảng categories
use App\Models\Product; // Model Product tương tác bảng products
use Illuminate\Http\Request; // Lớp Request để lấy dữ liệu HTTP
use Illuminate\Support\Str; // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\Storage; // Lớp lưu/ xóa file trong storage

class ProductController extends Controller // Controller xử lý logic sản phẩm
{
    public function index(Request $request) // Hiển thị danh sách sản phẩm
    {
        $query = Product::with('category'); // Tạo query lấy sản phẩm kèm dữ liệu category

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%'); // Lọc theo tên sản phẩm
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id); // Lọc theo danh mục
        }

        if ($request->has('sort')) {
            $query->orderBy('price', $request->sort); // Sắp xếp theo giá tăng/giảm
        }

        $products = $query->paginate(12); // Phân trang 12 sản phẩm mỗi trang
        $categories = Category::all(); // Lấy tất cả danh mục để hiển thị bộ lọc

        // Lấy top 3 sản phẩm bán chạy dựa trên đơn hàng đã hoàn thành
        $topProductIds = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Nối bảng order_items với orders
            ->where('orders.status', 'completed') // Chỉ lấy đơn đã hoàn thành
            ->groupBy('product_id') // Gom nhóm theo product_id
            ->orderByDesc('total_qty') // Sắp xếp theo số lượng giảm dần
            ->take(3) // Lấy 3 sản phẩm đứng đầu
            ->pluck('product_id') // Lấy mảng id sản phẩm
            ->toArray(); // Chuyển về mảng PHP
        
        return view('products.index', compact('products', 'categories', 'topProductIds')); // Trả về view danh sách sản phẩm
    }

    public function create() // Hiển thị form thêm sản phẩm
    {
        $categories = Category::all(); // Lấy danh sách danh mục để chọn khi tạo
        return view('products.create', compact('categories')); // Trả view form tạo sản phẩm
    }

    public function store(ProductRequest $request) // Lưu sản phẩm mới vào database
    {
        $data = $request->validated(); // Lấy dữ liệu đã xác thực
        $data['slug'] = Str::slug($data['name']); // Tạo slug từ tên sản phẩm

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public'); // Lưu ảnh vào storage
        }

        Product::create($data); // Tạo bản ghi sản phẩm mới

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!'); // Chuyển hướng về danh sách và hiện thông báo
    }

    public function edit(Product $product) // Hiển thị form sửa sản phẩm
    {
        $categories = Category::all(); // Lấy danh mục để chọn lại
        return view('products.edit', compact('product', 'categories')); // Trả view sửa sản phẩm
    }

    public function update(ProductRequest $request, Product $product) // Cập nhật sản phẩm
    {
        $data = $request->validated(); // Lấy dữ liệu đã xác thực
        $data['slug'] = Str::slug($data['name']); // Cập nhật slug nếu cần

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image); // Xóa ảnh cũ nếu có
            }
            $data['image'] = $request->file('image')->store('products', 'public'); // Lưu ảnh mới
        }

        $product->update($data); // Cập nhật dữ liệu sản phẩm

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!'); // Quay lại danh sách với thông báo
    }

    public function destroy(Product $product) // Xóa sản phẩm (soft delete)
    {
        $product->delete(); // Đánh dấu xóa mềm
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được chuyển vào thùng rác!'); // Chuyển hướng về danh sách
    }

    public function trash() // Hiển thị sản phẩm đã xóa tạm
    {
        $products = Product::onlyTrashed()->with('category')->get(); // Lấy sản phẩm trong thùng rác cùng category
        return view('products.trash', compact('products')); // Trả view thùng rác sản phẩm
    }

    public function restore($id) // Khôi phục sản phẩm đã xóa
    {
        $product = Product::onlyTrashed()->findOrFail($id); // Tìm sản phẩm trong thùng rác
        $product->restore(); // Khôi phục sản phẩm
        return redirect()->route('products.trash')->with('success', 'Khôi phục sản phẩm thành công!'); // Quay lại trang thùng rác
    }

    public function forceDelete($id) // Xóa vĩnh viễn sản phẩm
    {
        $product = Product::onlyTrashed()->findOrFail($id); // Tìm sản phẩm đã xóa trong thùng rác
        if ($product->image) {
            Storage::disk('public')->delete($product->image); // Xóa ảnh khỏi storage nếu có
        }
        $product->forceDelete(); // Xóa hoàn toàn bản ghi
        return redirect()->route('products.trash')->with('success', 'Xóa vĩnh viễn sản phẩm thành công!'); // Quay lại trang thùng rác với thông báo
    }
}
