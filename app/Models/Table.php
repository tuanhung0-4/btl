<?php

namespace App\Models; #Khai báo model này thuộc namespace của Laravel

use Illuminate\Database\Eloquent\Factories\HasFactory; #Dùng HasFactory để hỗ trợ tạo dữ liệu mmẫu cho model
use Illuminate\Database\Eloquent\Model; #Model cơ sở của Laravel, tất cả model khác sẽ kế thừa từ Model này

class Table extends Model #Định nghĩa lớp Table kế thừa từ Model của Laravel, đại diện cho bảng tables trong cơ sở dữ liệu
{
    use HasFactory; #Dùng HasFactory để hỗ trợ tạo dữ liệu mmẫu cho model

     #Khai báo các trường được phép gán dữ liệu hàng loạt vào model
    protected $fillable = ['name', 'status', 'description'];

    public function orders() #Định nghĩa quan hệ: mỗi bàn có nhiều đơn hàng
    {
        return $this->hasMany(Order::class);
    }

    public function currentOrder() #Định nghĩa quan hệ: mỗi bàn có một đơn hàng đang xử lý (pending)
    {
        return $this->hasOne(Order::class)->where('status', 'pending')->latest();
    }
}
