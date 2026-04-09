# TÀI LIỆU TỔNG HỢP DỰ ÁN QUẢN LÝ QUÁN CAFE

## 1. PHÂN TÍCH QUAN HỆ DỮ LIỆU (ENTITY RELATIONSHIP)
| Bảng | Quan hệ | Mô tả |
| :--- | :--- | :--- |
| **Category** | HasMany `Product` | Phân loại món (Cà phê, Trà, Bánh...) |
| **Product** | BelongsTo `Category` | Thông tin món ăn, giá, ảnh |
| **Table** | HasMany `Order` | Quản lý trạng thái bàn (Trống/Bận) |
| **Order** | BelongsTo `Table`, HasMany `OrderItem` | Thông tin hóa đơn tổng thể |
| **OrderItem** | BelongsTo `Product` | Chi tiết từng món trong hóa đơn |

## 2. CẤU TRÚC KỸ THUẬT CHI TIẾT

### 2.1. Model & Eloquent (app/Models)
- **Soft Deletes**: Áp dụng trong `Product.php` để tránh mất dữ liệu khi xóa nhầm.
- **Query Scopes**:
    - `scopeAvailable()`: Lọc món đang kinh doanh.
    - `scopePriceRange($min, $max)`: Lọc theo khoảng giá.
- **Relationships**:
    - Sử dụng `withCount('products')` trong `CategoryController` để đếm số lượng món nhanh chóng.
    - Sử dụng `belongsToMany` trong `Order.php` thông qua `order_items` để truy xuất danh sách món đã gọi.

### 2.2. Xử lý logic (app/Http/Controllers)
- **Eager Loading**: Luôn sử dụng `with(['category'])` trong `ProductController` để tối ưu hóa 1 truy vấn thay vì N+1.
- **Transaction**: Sử dụng `DB::beginTransaction()` trong `OrderController@store` để đảm bảo khi tạo đơn hàng, nếu lỗi ở bất kỳ bước nào (trừ tiền, cập nhật bàn) thì toàn bộ dữ liệu sẽ được hoàn tác.

### 2.3. Validation (app/Http/Requests)
- **ProductRequest**: Kiểm tra tên không trống, giá phải là số dương, ảnh đúng định dạng file.
- **OrderRequest**: Ràng buộc phải chọn bàn và có ít nhất 1 sản phẩm với số lượng > 0.

### 2.4. Giao diện & Component (resources/views)
- **Master Layout**: Tách biệt Sidebar (navigation) và Header (user info).
- **Reusable Blade Components**:
    - `<x-alert>`: Hiển thị thông báo Toast/Alert.
    - `<x-badge>`: Hiển thị trạng thái màu sắc (Thành công, Cảnh báo...).
    - `<x-product-card>`: Hiển thị thông tin món ăn đồng nhất toàn website.

## 3. HƯỚNG DẪN SQL (CƠ SỞ DỮ LIỆU)
Bạn cần tạo database tên là `coffee_shop_db`. Hệ thống sử dụng 5 bảng chính được khởi tạo qua Migration.

**Dữ liệu mẫu (Seeder):**
Chạy `php artisan db:seed --class=CoffeeShopSeeder` để có ngay danh sách bàn và các loại cà phê mẫu.

## 4. QUY TRÌNH NGHIỆP VỤ (WORKFLOW)
1. **Quản lý kho**: Admin thêm Category -> Thêm Product vào Category đó.
2. **Tiếp khách**: Khách vào bàn -> Mở đơn hàng (chọn bàn trống).
3. **Gọi món**: Chọn món từ danh sách -> Nhập số lượng -> Hệ thống tính tổng tiền.
4. **Thanh toán**: Bấm hoàn tất -> Đơn hàng chuyển sang 'completed' -> Bàn tự động chuyển về trạng thái 'empty'.
