@extends('layouts.master')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Thêm bàn mới</h2>
        </div>
        <a href="{{ route('tables.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <form action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tên bàn <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                @error('name') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Trạng thái <span style="color: var(--danger);">*</span></label>
                <select name="status" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; background: white;">
                    <option value="empty" {{ old('status') == 'empty' ? 'selected' : '' }}>Trống</option>
                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Có khách</option>
                </select>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mô tả/Vị trí</label>
                <textarea name="description" rows="3" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <i class="fas fa-save"></i> Lưu bàn
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
