@extends('layouts.master')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Chỉnh sửa danh mục</h2>
        </div>
        <a href="{{ route('categories.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tên danh mục <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                @error('name') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mô tả</label>
                <textarea name="description" rows="3" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">{{ old('description', $category->description) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
