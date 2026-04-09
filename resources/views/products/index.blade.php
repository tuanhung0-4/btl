@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Quản lý thực đơn</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Danh sách tất cả các món ăn trong quán.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('products.trash') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-trash-alt"></i> Thùng rác
        </a>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm món mới
        </a>
    </div>
</div>

<div class="card" style="padding: 1rem;">
    <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <div style="flex-grow: 1; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
            <input type="text" name="search" placeholder="Tìm theo tên..." value="{{ request('search') }}" style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
        </div>
        <select name="category_id" style="padding: 0.6rem 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
            <option value="">Tất cả danh mục</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="sort" style="padding: 0.6rem 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
        </select>
        <button type="submit" class="btn btn-primary">Lọc</button>
        @if(request()->hasAny(['search', 'category_id', 'sort']))
            <a href="{{ route('products.index') }}" class="btn" style="background: #f1f5f9;">Xóa lọc</a>
        @endif
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
    @forelse($products as $product)
        @php 
            $rank = array_search($product->id, $topProductIds);
            $bestSellerRank = ($rank !== false) ? $rank + 1 : null;
        @endphp
        <x-product-card :product="$product" :bestSellerRank="$bestSellerRank" />
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: white; border-radius: 1rem;">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 120px; opacity: 0.5; margin-bottom: 1rem;">
            <h3 style="color: #64748b;">Không tìm thấy món ăn nào</h3>
        </div>
    @endforelse
</div>

<div style="margin-top: 2rem;">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
