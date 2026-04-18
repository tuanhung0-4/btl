@extends('layouts.master')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <p style="color: var(--color-gray-500); font-size: 0.95rem; margin: 0;">Danh sách tất cả các sản phẩm trong quán.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('products.trash') }}" class="btn btn-secondary">
            <i class="fas fa-trash-alt"></i> Thùng rác
        </a>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4" style="margin-bottom: 1.5rem;">
    <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
        <div style="flex-grow: 1;">
            <label class="fw-semi-bold mb-2" style="display: block; margin-bottom: 0.5rem;">Tìm kiếm</label>
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-gray-400);"></i>
                <input type="text" name="search" placeholder="Nhập tên sản phẩm..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem;">
            </div>
        </div>
        <div>
            <label class="fw-semi-bold mb-2" style="display: block; margin-bottom: 0.5rem;">Danh mục</label>
            <select name="category_id" style="padding: 0.75rem 1rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); background: white; font-size: 0.9rem; cursor: pointer;">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="fw-semi-bold mb-2" style="display: block; margin-bottom: 0.5rem;">Sắp xếp</label>
            <select name="sort" style="padding: 0.75rem 1rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); background: white; font-size: 0.9rem; cursor: pointer;">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Lọc
        </button>
        @if(request()->hasAny(['search', 'category_id', 'sort']))
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Xóa
            </a>
        @endif
    </form>
</div>

<!-- Products Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    @forelse($products as $product)
        @php 
            $rank = array_search($product->id, $topProductIds);
            $bestSellerRank = ($rank !== false) ? $rank + 1 : null;
        @endphp
        <x-product-card :product="$product" :bestSellerRank="$bestSellerRank" />
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: var(--color-white); border-radius: var(--radius); border: 2px dashed var(--color-gray-300);">
            <i class="fas fa-box-open" style="font-size: 3rem; color: var(--color-gray-300); margin-bottom: 1rem;"></i>
            <h3 style="color: var(--color-gray-500); margin-bottom: 0.5rem;">Không tìm thấy sản phẩm</h3>
            <p style="color: var(--color-gray-400); margin: 0;">Hãy thêm sản phẩm mới hoặc thay đổi bộ lọc</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
{{ $products->appends(request()->query())->links() }}
@endsection
