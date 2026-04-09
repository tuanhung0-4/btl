@extends('layouts.master')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Chỉnh sửa món ăn</h2>
            <p style="color: #64748b; font-size: 0.875rem;">Cập nhật thông tin cho: {{ $product->name }}</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tên món ăn <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Danh mục <span style="color: var(--danger);">*</span></label>
                    <select name="category_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Giá bán (VNĐ) <span style="color: var(--danger);">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Trạng thái <span style="color: var(--danger);">*</span></label>
                    <select name="status" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
                        <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Còn món</option>
                        <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Hết món</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ảnh hiện tại</label>
                @if($product->image)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $product->image) }}" style="width: 150px; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                    </div>
                @endif
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Thay đổi ảnh</label>
                <input type="file" name="image" style="width: 100%; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: #f8fafc;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mô tả chi tiết</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">{{ old('description', $product->description) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <i class="fas fa-save"></i> Cập nhật món
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
