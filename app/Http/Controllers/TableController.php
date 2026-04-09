<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::with('currentOrder')->get();
        return view('tables.index', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables',
            'status' => 'required|in:empty,occupied',
            'description' => 'nullable|string'
        ]);

        Table::create($validated);

        return redirect()->route('tables.index')->with('success', 'Thêm bàn thành công!');
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tables,name,' . $table->id,
            'status' => 'required|in:empty,occupied',
            'description' => 'nullable|string'
        ]);

        $table->update($validated);

        return redirect()->route('tables.index')->with('success', 'Cập nhật bàn thành công!');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Xóa bàn thành công!');
    }
}
