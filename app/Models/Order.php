<?php

namespace App\Models; #Khai báo model này thuộc namespace của Laravel

use Illuminate\Database\Eloquent\Factories\HasFactory; #Dùng HasFactory để hỗ trợ tạo dữ liệu mmẫu cho model
use Illuminate\Database\Eloquent\Model; #Model cơ sở của Laravel, tất cả model khác sẽ kế thừa từ Model này

class Order extends Model #Định nghĩa lớp Order kế thừa từ Model của Laravel, đại diện cho bảng orders trong cơ sở dữ liệu
{   
    use HasFactory; #Dùng HasFactory để hỗ trợ tạo dữ liệu mmẫu cho model
     #Khai báo các trường được phép gán dữ liệu hàng loạt vào model
    protected $fillable = ['table_id', 'customer_name', 'customer_phone', 'total_amount', 'status'];

    public function table() #Định nghĩa quan hệ: mỗi đơn hàng thuộc về một bàn
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems() #Định nghĩa quan hệ: mỗi đơn hàng có nhiều mục đơn hàng (sản phẩm đã đặt)
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products() #Định nghĩa quan hệ: mỗi đơn hàng có nhiều sản phẩm thông qua bảng trung gian order_items
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
