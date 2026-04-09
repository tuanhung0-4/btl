# GIẢI THÍCH CODE CHÍNH (KEY CONCEPTS)

## 1. Quan hệ dữ liệu (Relationship)

Trong ứng dụng, các quan hệ được định nghĩa trong các `Models` (thư mục `app/Models`):

- **Course (1-N) Lesson**: Một khóa học có nhiều bài học. Dùng `hasMany` trong `Course.php` và `belongsTo` trong `Lesson.php`.
    ```php
    public function lessons() {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
    ```
- **Course (1-N) Enrollment**: Một khóa học có nhiều bản ghi đăng ký.
- **Student (1-N) Enrollment**: Một học viên có nhiều bản ghi đăng ký (đăng ký nhiều khóa học).
- **Course (Many-to-Many) Student**: Quan hệ giữa khóa học và học viên thông qua bảng trung gian `enrollments`. Dùng `belongsToMany`.
    ```php
    public function students() {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
    ```

---

## 2. Kiểm soát dữ liệu (Validation)

Chúng ta sử dụng **Form Request** để tách biệt logic kiểm tra dữ liệu ra khỏi Controller (xem `app/Http/Requests/CourseRequest.php`):

- **Rule `required`**: Bắt buộc nhập tên, giá, trạng thái.
- **Rule `numeric` & `min:0.01`**: Đảm bảo giá tiền là con số và lớn hơn 0.
- **Rule `image`**: Kiểm tra định dạng file và dung lượng ảnh (tối đa 2MB).
- **Rule `unique:courses,slug`**: Đảm bảo đường dẫn slug không bị trùng lặp.
    - *Lưu ý*: Khi cập nhật, chúng ta sử dụng `slug,id` để bỏ qua việc kiểm tra trùng lặp với chính bản ghi đang sửa.
    ```php
    'slug' => 'nullable|string|unique:courses,slug,' . $id,
    ```

---

## 3. Tối ưu hóa truy vấn (Optimization)

### Vấn đề N+1 Query
Khi bạn lấy 10 khóa học, nếu bạn không tối ưu, mỗi khi hiển thị "Số bài học" hay "Số học viên", Laravel sẽ gọi thêm một câu SQL cho từng khóa học (10 + 10 = 20 câu SQL).

### Giải pháp trong dự án:
Trong `CourseController@index`, chúng ta sử dụng:
1. **`withCount(['lessons', 'students'])`**: Laravel sẽ thực hiện đếm số lượng bài học và học viên trực tiếp bằng một câu SQL duy nhất bằng cách `JOIN`. Điều này cực kỳ nhanh và tiết kiệm bộ nhớ.
2. **`with(['lessons', 'enrollments'])`**: **Eager Loading** tải sẵn dữ liệu các bảng liên quan. Dữ liệu bài học đã nằm sẵn trong bộ nhớ, khi gọi `$course->lessons` trong Blade, nó sẽ không gọi thêm SQL nữa.

```php
Course::withCount(['lessons', 'students'])
      ->with(['lessons', 'enrollments'])
      ->paginate(10);
```

---

## 4. Các Scopes & Advanced Features
- **Soft Deletes**: Khóa học khi xóa sẽ không mất hẳn khỏi Database, cho phép "khôi phục" lại.
- **Local Scopes**: Định nghĩa `scopePublished()` để lấy nhanh các khóa học đã được đăng.
    ```php
    public function scopePublished($query) {
        return $query->where('status', 'published');
    }
    ```
