# Coffee Shop Management System (Laravel)

Dự án quản lý quán Cafe chuyên nghiệp được xây dựng trên nền tảng Laravel, tuân thủ các quy chuẩn kỹ thuật hiện đại.

## 🚀 Tính năng chính
- **Dashboard**: Thống kê doanh thu, món bán chạy, số lượng đơn hàng.
- **Quản lý thực đơn**: CRUD sản phẩm, phân loại danh mục, lọc theo giá/tên.
- **Thùng rác (Soft Delete)**: Khôi phục hoặc xóa vĩnh viễn món ăn.
- **Quản lý bàn**: Trạng thái bàn trống/có khách.
- **Xử lý đơn hàng**: Tạo đơn, tính tiền tự động và hoàn tất thanh toán.

## 🛠 Kỹ thuật áp dụng
- **Eloquent Relationships**: belongsTo, hasMany.
- **Advanced Query**: Eager Loading (`with`), Query Scopes (`available`, `priceRange`).
- **Validation**: Form Request chuyên biệt.
- **Blade Component**: Alert, Badge, Product Card tái sử dụng.
- **UI/UX**: Thiết kế Premium với Google Fonts (Outfit) và CSS hiện đại.

## 📦 Cài đặt
1. Clone dự án.
2. Sao chép `.env.coffee` thành `.env`.
3. Tạo cơ sở dữ liệu `coffee_shop_db` trong MySQL.
4. Chạy lệnh cài đặt:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed --seeder=CoffeeShopSeeder
   php artisan storage:link
   ```
5. Khởi chạy:
   ```bash
   php artisan serve
   ```

## 📂 Cấu trúc logic chuyển đổi
- `Category` (Danh mục) <- Thay thế Course Category.
- `Product` (Sản phẩm) <- Thay thế Course.
- `Table` (Bàn) <- Thực thể quản lý vị trí.
- `Order` (Đơn hàng) <- Thay thế Enrollment.
- `OrderItem` (Chi tiết) <- Thay thế Lesson (Chi tiết từng món).

## 🧩 Mô hình MVC và tương tác
Trong dự án này, mọi yêu cầu người dùng đều đi qua 4 thành phần chính:
- `Route` (`routes/web.php`): ánh xạ URL đến phương thức của controller.
- `Controller`: nhận request, xử lý kinh doanh, gọi `Model` và trả `View`.
- `Model`: tương tác với database qua Eloquent.
- `View`: hiển thị giao diện HTML cho người dùng.

### 1. Route xác định controller
Một số tuyến chính trong `routes/web.php` như sau:
```php
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::post('/login', [AuthController::class, 'login']);
```
Các route này cho biết đường dẫn nào gọi phương thức nào ở controller.

### 2. Controller xử lý logic
#### `AuthController`
- `showLogin()` trả view `auth.login`.
- `login(Request $request)`:
  - kiểm tra email/username bằng `filter_var`.
  - dùng `Auth::attempt($credentials)` xác thực.
  - nếu đúng, chuyển hướng đến dashboard.
- `register(Request $request)`:
  - validate dữ liệu.
  - tạo `User::create(...)` với `Hash::make($password)`.
  - `Auth::login($user)` và chuyển hướng.

#### `ProductController` (đầy đủ CRUD)
- `index(Request $request)`:
  - `Product::with('category')` lấy sản phẩm kèm category.
  - lọc `search`, `category_id`, `sort` nếu có.
  - phân trang `->paginate(12)`.
  - trả view `products.index`.
- `store(ProductRequest $request)`:
  - dùng `ProductRequest` xác thực.
  - tạo `slug` bằng `Str::slug($data['name'])`.
  - lưu ảnh nếu có và `Product::create($data)`.
- `update(ProductRequest $request, Product $product)`:
  - cập nhật dữ liệu và ảnh mới.
  - gọi `$product->update($data)`.
- `destroy(Product $product)`:
  - xóa mềm `$product->delete()`.
- `trash()`, `restore($id)`, `forceDelete($id)`:
  - thao tác với `Product::onlyTrashed()` để quản lý thùng rác.

#### `OrderController`
- `create()`:
  - lấy `Table::all()`, `Product::available()->with('category')->get()`, `Category::all()`.
  - trả view `orders.create`.
- `store(OrderRequest $request)`:
  - dùng transaction `DB::beginTransaction()`.
  - tính tổng tiền, tạo `Order::create(...)`.
  - tạo chi tiết đơn hàng với `$order->orderItems()->create($item)`.
  - cập nhật trạng thái bàn `Table::where('id', ...)->update(['status' => 'occupied'])`.
- `complete(Order $order)`:
  - `$order->update(['status' => 'completed'])`.
  - `$order->table->update(['status' => 'empty'])`.
- `cancel(Order $order)`:
  - tương tự nhưng trạng thái là `cancelled`.

### 3. Model và quan hệ dữ liệu
#### `Product`
```php
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'name', 'slug', 'price', 'image', 'status', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
```
- `category()` liên kết sản phẩm với danh mục.
- `orderItems()` liên kết sản phẩm với chi tiết đơn hàng.
- `scopeAvailable` lọc sản phẩm còn bán.

#### `Order`
```php
class Order extends Model
{
    protected $fillable = ['table_id', 'customer_name', 'customer_phone', 'total_amount', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
```
- `table()` lấy bàn đặt.
- `orderItems()` lấy chi tiết món.

### 4. View trả về giao diện
Controller trả về view như:
```php
return view('products.index', compact('products', 'categories', 'topProductIds'));
return view('orders.create', compact('tables', 'products', 'categories'));
return view('dashboard', compact('totalRevenue', ...));
```
View ở thư mục `resources/views` hiển thị dữ liệu bằng Blade.

### 5. Luồng tương tác thực tế
#### Ví dụ: mở trang sản phẩm
1. Người dùng truy cập `/products`.
2. Route `GET /products` gọi `ProductController@index`.
3. Controller truy vấn `Product::with('category')->paginate(12)`.
4. Controller trả view `products.index` với dữ liệu `products`.
5. View hiển thị danh sách sản phẩm.

#### Ví dụ: tạo đơn mới
1. Người dùng gửi form `POST /orders`.
2. Route `orders.store` gọi `OrderController@store`.
3. Controller tính tổng tiền, tạo đơn và chi tiết đơn.
4. Controller cập nhật trạng thái bàn.
5. Chuyển hướng đến `orders.show` với thông báo thành công.

### 6. Toàn bộ hành trình dự án
- `routes/web.php` định tuyến tất cả yêu cầu.
- `app/Http/Controllers` chứa controller xử lý login, sản phẩm, đơn hàng, báo cáo.
- `app/Models` chứa model dữ liệu và quan hệ Eloquent.
- `resources/views` chứa giao diện HTML Blade.
- `database/migrations` định nghĩa cấu trúc bảng.
- `database/seeders` tạo dữ liệu mẫu.

> Luồng chính: Route -> Controller -> Model -> View.
