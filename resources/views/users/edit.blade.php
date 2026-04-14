@extends('layouts.master')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark);">{{ isset($user) ? 'Cập nhật tài khoản' : 'Thêm tài khoản mới' }}</h3>
        <p style="color: var(--secondary); font-size: 0.9rem;">Điền đầy đủ thông tin bên dưới để {{ isset($user) ? 'cập nhật' : 'tạo' }} tài khoản.</p>
    </div>

    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Họ và tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Vai trò</label>
            <select name="role" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none; background: white;">
                <option value="staff" {{ old('role', $user->role ?? '') === 'staff' ? 'selected' : '' }}>Nhân viên</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Mật khẩu {{ isset($user) ? '(Để trống nếu không đổi)' : '' }}</label>
            <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
                style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center; padding: 0.8rem;">
                <i class="fas fa-save"></i> {{ isset($user) ? 'Lưu thay đổi' : 'Tạo tài khoản' }}
            </button>
            <a href="{{ route('users.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.8rem 1.5rem;">Hủy</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    input:focus, select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
</style>
@endpush
