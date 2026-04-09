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
