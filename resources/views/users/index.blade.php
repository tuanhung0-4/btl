@extends('layouts.master')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark);">Quản lý tài khoản</h3>
            <p style="color: var(--secondary); font-size: 0.9rem;">Danh sách và phân quyền người dùng trong hệ thống.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm tài khoản mới
        </a>
    </div>

    <!-- Search Section (Admin Only - though this page is already admin-only) -->
    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid #e2e8f0;">
        <form action="{{ route('users.index') }}" method="GET" style="display: flex; gap: 1rem;">
            <div style="flex-grow: 1; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Tìm kiếm theo tên hoặc email..." 
                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: all 0.2s;">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            @if(request('search'))
                <a href="{{ route('users.index') }}" class="btn" style="background: #e2e8f0; color: #475569;">Xóa lọc</a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td style="font-weight: 500;">{{ $user->name }}</td>
                    <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">{{ $user->username }}</code></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-success" style="background: #dbeafe; color: #1e40af;">Quản trị viên</span>
                        @else
                            <span class="badge badge-warning" style="background: #fef3c7; color: #92400e;">Nhân viên</span>
                        @endif
                    </td>
                    <td style="color: var(--secondary); font-size: 0.85rem;">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('users.edit', $user) }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.8rem;">
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
