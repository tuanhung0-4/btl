@extends('layouts.master')

@section('content')
<!-- Header Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <p style="color: var(--color-gray-500); font-size: 0.95rem; margin: 0;">Danh sách và phân quyền người dùng trong hệ thống.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm tài khoản
    </a>
</div>

<!-- Search Section -->
<div class="card mb-4" style="margin-bottom: 1.5rem;">
    <form action="{{ route('users.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex-grow: 1;">
            <label class="fw-semi-bold mb-2" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Tìm kiếm</label>
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-gray-400);"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Tìm theo tên hoặc email..." 
                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem;">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        @if(request('search'))
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Xóa</a>
        @endif
    </form>
</div>

<!-- Users Table -->
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th style="text-align: center;">Vai trò</th>
                    <th style="text-align: center;">Ngày tạo</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 35px; height: 35px; background: var(--color-accent-yellow); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--color-dark); font-size: 0.9rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td><code style="background: var(--color-gray-100); padding: 4px 8px; border-radius: 4px;">{{ $user->username }}</code></td>
                    <td style="font-size: 0.9rem; color: var(--color-gray-600);">{{ $user->email }}</td>
                    <td style="text-align: center;">
                        @if($user->role === 'admin')
                            <span class="badge badge-primary"><i class="fas fa-crown"></i> Admin</span>
                        @else
                            <span class="badge badge-info"><i class="fas fa-user"></i> Nhân viên</span>
                        @endif
                    </td>
                    <td style="text-align: center; color: var(--color-gray-500); font-size: 0.85rem;">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td style="text-align: right;">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline"
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== Auth::id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--secondary);">
                        <i class="fas fa-users-slash" style="font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                        Không tìm thấy tài khoản nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    input:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    table tr:hover {
        background-color: #f8fafc;
    }
</style>
@endpush
