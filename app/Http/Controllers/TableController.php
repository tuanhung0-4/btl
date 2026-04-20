<?php

namespace App\Http\Controllers; #Khai báo controller này thuộc namespace của Laravel

use App\Models\Table; #Import model Table để tương tác với bảng trong cơ sở dữ liệu
use Illuminate\Http\Request; #Nhận request từ khách hàng

class TableController extends Controller #Định nghĩa lớp TableController kế thừa từ Controller của Laravel
{
    public function index() #Hiển thị danh sách bàn và trạng thái hiện tại
    {
        $tables = Table::with('currentOrder')->get();
        return view('tables.index', compact('tables'));
    }

    public function create() #Hiển thị form tạo bàn mới
    {
        return view('tables.create');
    }

    public function store(Request $request) #Xử lý lưu bàn mới vào cơ sở dữ liệu
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables',
            'status' => 'required|in:empty,occupied',
            'description' => 'nullable|string'
        ]);

        Table::create($validated);

        return redirect()->route('tables.index')->with('success', 'Thêm bàn thành công!');
    }

    public function edit(Table $table) #Hiển thị form sửa thông tin bàn
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table) #Xử lý cập nhật thông tin bàn vào cơ sở dữ liệu
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name,' . $table->id,
            'status' => 'required|in:empty,occupied',
            'description' => 'nullable|string'
        ]);

        $table->update($validated);

        return redirect()->route('tables.index')->with('success', 'Cập nhật bàn thành công!');
    }

    public function destroy(Table $table) #Xử lý xóa bàn khỏi cơ sở dữ liệu
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Xóa bàn thành công!');
    }
}
