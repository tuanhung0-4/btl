# GIẢI THÍCH CODE CHÍNH (KEY CONCEPTS) - QUẢN LÝ QUÁN CAFE

## 1. Quan hệ dữ liệu (Relationship)

Trong ứng dụng, các quan hệ được định nghĩa trong các `Models` (thư mục `app/Models`):

- **Category (1-N) Product**: Một danh mục (Cà phê, Trà...) có nhiều sản phẩm. Dùng `hasMany` trong `Category.php` và `belongsTo` trong `Product.php`.
    ```php
    public function products() {
        return $this->hasMany(Product::class);
    }
    ```
- **Table (1-N) Order**: Một bàn có thể có nhiều đơn hàng (theo thời gian). Một đơn hàng hiện tại thuộc về một bàn.
- **Order (1-N) OrderItem**: Một hóa đơn có nhiều chi tiết món ăn.
- **Product (1-N) OrderItem**: Một sản phẩm có thể xuất hiện trong nhiều chi tiết hóa đơn khác nhau.
- **Order (Many-to-Many) Product**: Quan hệ giữa hóa đơn và sản phẩm thông qua bảng trung gian `order_items`.
    ```php
    public function products() {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price');
    }
    ```

---

## 2. Kiểm soát dữ liệu (Validation)

Sử dụng **Form Request** để đảm bảo dữ liệu đầu vào sạch (ví dụ: `app/Http/Requests/ProductRequest.php`):

- **Rule `required`**: Tên sản phẩm, giá, danh mục là bắt buộc.
- **Rule `numeric` & `min:0`**: Đảm bảo giá tiền là con số hợp lệ.
- **Rule `image`**: Kiểm tra file ảnh tải lên đúng định dạng (jpg, png...).

---

## 3. Tối ưu hóa truy vấn (Optimization)

### Vấn đề N+1 Query
Khi hiển thị danh sách sản phẩm kèm tên danh mục, nếu không tối ưu, Laravel sẽ gọi thêm 1 câu SQL lấy Category cho mỗi Product.

### Giải pháp:
Sử dụng **Eager Loading** trong Controller:
```php
// ProductController.php
$products = Product::with('category')->get();
```
Điều này giúp gộp các truy vấn lại, chỉ tốn 2 câu SQL thay vì N+1.

---

## 4. Các tính năng nâng cao
- **Soft Deletes**: Sản phẩm khi xóa sẽ được đánh dấu `deleted_at`, cho phép khôi phục hoặc giữ bằng chứng lịch sử trong `orders`.
- **Query Scopes**: 
    - `scopeAvailable()`: Lấy nhanh các món còn hàng.
    ```php
    public function scopeAvailable($query) {
        return $query->where('status', 'available');
    }
    ```
- **Database Transactions**: Khi tạo Order và OrderItems, sử dụng `DB::beginTransaction()` để đảm bảo tính toàn vẹn dữ liệu (nếu lỗi ở bước lưu item thì order chính cũng sẽ roll back).
