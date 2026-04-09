@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Danh mục sản phẩm</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Quản lý các nhóm món ăn (Cà phê, Trà, Bánh...).</p>
    </div>
    <form action="{{ route('categories.store') }}" method="POST" class="card" style="margin-bottom: 0; padding: 0.75rem 1rem; display: flex; gap: 0.75rem; align-items: center;">
        @csrf
        <input type="text" name="name" placeholder="Tên danh mục mới..." required style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.4rem;">
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">
            <i class="fas fa-plus"></i> Thêm
        </button>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
    @foreach($categories as $category)
    <div class="card" style="margin-bottom: 0; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-weight: 700; color: #1e293b;">{{ $category->name }}</h3>
            <x-badge type="info">{{ $category->products_count }} món</x-badge>
        </div>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">
            {{ $category->description ?? 'Chưa có mô tả cho danh mục này.' }}
        </p>
        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn" style="background: #f1f5f9; color: #475569;">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này? Tất cả sản phẩm thuộc danh mục cũng sẽ bị ảnh hưởng!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #fee2e2; color: #b91c1c;">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; width: 4px; height: 100%; background: var(--primary);"></div>
    </div>
    @endforeach
</div>
@endsection
