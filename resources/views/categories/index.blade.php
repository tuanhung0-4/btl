@extends('layouts.master')

@section('content')
<!-- Header Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <p style="color: var(--color-gray-500); font-size: 0.95rem; margin: 0;">Quản lý các nhóm sản phẩm (Cà phê, Trà, Bánh...).</p>
    </div>
    <form action="{{ route('categories.store') }}" method="POST" style="display: flex; gap: 0.75rem; align-items: flex-end;">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Nhập tên danh mục..." required style="padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem; width: 250px;">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục
        </button>
    </form>
</div>

<!-- Categories Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($categories as $category)
    <div class="card" style="position: relative; overflow: hidden; border-left: 4px solid var(--color-primary);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <h3 style="font-weight: 700; color: var(--color-dark); margin-bottom: 0.25rem;">{{ $category->name }}</h3>
                <p style="color: var(--color-gray-500); font-size: 0.85rem; margin: 0;">
                    <i class="fas fa-cube"></i> {{ $category->products_count }} sản phẩm
                </p>
            </div>
        </div>
        <p style="color: var(--color-gray-600); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5;">
            {{ $category->description ?? 'Chưa có mô tả cho danh mục này.' }}
        </p>
        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này? Tất cả sản phẩm sẽ không còn danh mục.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: var(--color-white); border-radius: var(--radius); border: 2px dashed var(--color-gray-300);">
        <i class="fas fa-layer-group" style="font-size: 3rem; color: var(--color-gray-300); margin-bottom: 1rem;"></i>
        <h3 style="color: var(--color-gray-500); margin-bottom: 0.5rem;">Chưa có danh mục nào</h3>
        <p style="color: var(--color-gray-400); margin: 0;">Hãy thêm danh mục sản phẩm mới</p>
    </div>
    @endforelse
</div>
@endsection
