# Coffee Shop Management System (Laravel)

Dự án quản lý quán Cafe chuyên nghiệp được xây dựng trên nền tảng Laravel, tuân thủ các quy chuẩn kỹ thuật hiện đại.

## 🚀 Tính năng chính
- **Xác thực người dùng**: Đăng nhập, đăng ký, đăng xuất với vai trò Admin và Staff.
- **Quản lý người dùng**: CRUD tài khoản người dùng (chỉ dành cho Admin).
- **Dashboard**: Thống kê doanh thu, món bán chạy, số lượng đơn hàng, trạng thái bàn.
- **Quản lý danh mục**: CRUD danh mục sản phẩm (chỉ dành cho Admin).
- **Quản lý sản phẩm**: CRUD sản phẩm với phân loại danh mục, lọc theo giá/tên, upload ảnh, trạng thái available/unavailable, thùng rác (Soft Delete) để khôi phục hoặc xóa vĩnh viễn.
- **Quản lý bàn**: CRUD bàn và chỗ ngồi với trạng thái trống/có khách.
- **Quản lý đơn hàng**: Tạo đơn hàng mới, thêm sản phẩm vào đơn, tính tiền tự động, hoàn tất thanh toán, hủy đơn hàng.
- **Thống kê**: Báo cáo doanh thu theo danh mục, thống kê chi tiết (chỉ dành cho Admin).

## 📊 Dashboard
Dashboard và sidebar được tạo bởi các file chính sau:
- `routes/web.php`: định nghĩa tất cả route cho trang chủ, tài khoản, danh mục, sản phẩm, bàn, đơn hàng và thống kê.
- `app/Http/Controllers/DashboardController.php`: trả dữ liệu cho trang chủ dashboard và trang thống kê.
- `resources/views/layouts/master.blade.php`: layout chung chứa sidebar, header và vùng nội dung chính.
- `resources/views/dashboard.blade.php`: nội dung trang chủ dashboard.
- `public/css/imaji-style.css`: style chung cho dashboard, sidebar và layout.

### Các mục chính trên sidebar và file tạo nên chúng
- `Trang chủ` (Tất cả)
  - Route: `GET /`
  - Controller: `DashboardController@index`
  - View: `resources/views/dashboard.blade.php`
- `Tài khoản` (Chỉ Admin)
  - Route resource: `users`
  - Controller: `UserController`
  - Views: `resources/views/users/index.blade.php`, `resources/views/users/create.blade.php`, `resources/views/users/edit.blade.php`
- `Danh mục` (Chỉ Admin)
  - Route resource: `categories`
  - Controller: `CategoryController`
  - Views: `resources/views/categories/index.blade.php`, `resources/views/categories/edit.blade.php`
- `Sản phẩm` (Tất cả: index/show; Admin: full CRUD + trash)
  - Route resource: `products`
  - Controller: `ProductController`
  - Views: `resources/views/products/index.blade.php`, `resources/views/products/create.blade.php`, `resources/views/products/edit.blade.php`, `resources/views/products/trash.blade.php`
- `Bàn & Chỗ ngồi` (Tất cả)
  - Route resource: `tables`
  - Controller: `TableController`
  - Views: `resources/views/tables/index.blade.php`, `resources/views/tables/create.blade.php`, `resources/views/tables/edit.blade.php`
- `Đơn hàng` (Tất cả: full CRUD + complete/cancel)
  - Route resource: `orders`
  - Controller: `OrderController`
  - Views: `resources/views/orders/index.blade.php`, `resources/views/orders/create.blade.php`, `resources/views/orders/edit.blade.php`, `resources/views/orders/show.blade.php`
- `Thống kê` (Chỉ Admin)
  - Route: `GET /statistics`
  - Controller: `DashboardController@statistics`
  - View: `resources/views/statistics/index.blade.php`

### Cấu tạo sidebar trong dashboard
- Sidebar chính được tạo trong `resources/views/layouts/master.blade.php`.
- Menu sidebar sử dụng các route và tên sau, với quyền truy cập dựa trên vai trò:
  - `route('dashboard')` -> Trang chủ (Tất cả)
  - `route('users.index')` -> Tài khoản (Chỉ Admin)
  - `route('categories.index')` -> Danh mục (Chỉ Admin)
  - `route('products.index')` -> Sản phẩm (Tất cả)
  - `route('tables.index')` -> Bàn & Chỗ ngồi (Tất cả)
  - `route('orders.index')` -> Đơn hàng (Tất cả)
  - `route('statistics')` -> Thống kê (Chỉ Admin)
- Khi chọn một mục, layout sẽ hiển thị view tương ứng trong `@yield('content')`.

### Thành phần chính trên trang chủ dashboard
- Thẻ thông tin tổng quan (stat cards): tổng doanh thu, tổng đơn, bàn có khách, số lượng món.
- Bảng "Bán chạy nhất" dựa trên `OrderItem` và `Order`.
- Khối "Doanh thu theo loại" tính toán doanh thu theo `Category`.
- Header trên cùng hiển thị tên trang và lời chào người dùng.
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
