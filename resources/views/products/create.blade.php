@extends('layouts.master')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Thêm món mới</h2>
            <p style="color: #64748b; font-size: 0.875rem;">Điền thông tin bên dưới để tạo món mới.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tên món ăn <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                    @error('name') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Danh mục <span style="color: var(--danger);">*</span></label>
                    <select name="category_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Giá bán (VNĐ) <span style="color: var(--danger);">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Trạng thái <span style="color: var(--danger);">*</span></label>
                    <select name="status" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn món</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Hết món</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ảnh món ăn</label>
                <input type="file" name="image" style="width: 100%; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: #f8fafc;">
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">Hỗ trợ: JPG, PNG. Tối đa 2MB.</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mô tả chi tiết</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="reset" class="btn" style="background: #f1f5f9; color: #475569;">Nhập lại</button>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <i class="fas fa-save"></i> Lưu món ăn
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
