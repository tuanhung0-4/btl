@extends('layouts.master')

@section('content')
<!-- Header Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <p style="color: var(--color-gray-500); font-size: 0.95rem; margin: 0;">Tìm kiếm và lọc các đơn hàng của quán.</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tạo đơn hàng
    </a>
</div>

<!-- Filters Section -->
<div class="card mb-4" style="margin-bottom: 1.5rem;">
    <form action="{{ route('orders.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: flex-end;">
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Mã / Khách hàng</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã hoặc tên..." 
                style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Từ ngày</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Đến ngày</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: var(--radius); font-size: 0.9rem;">
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                <i class="fas fa-filter"></i> Lọc
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Xóa</a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="card">
    @if($orders->count() > 0)
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Bàn</th>
                    <th>Khách hàng</th>
                    <th style="text-align: right;">Tổng tiền</th>
                    <th style="text-align: center;">Trạng thái</th>
                    <th style="text-align: center;">Ngày tạo</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>
                        @if($order->table)
                            <span class="badge badge-primary">{{ $order->table->name }}</span>
                        @else
                            <span style="color: var(--color-gray-400);">-</span>
                        @endif
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->customer_name ?? 'N/A' }}</strong>
                            @if($order->customer_phone)
                                <p style="font-size: 0.8rem; color: var(--color-gray-500); margin: 0;">{{ $order->customer_phone }}</p>
                            @endif
                        </div>
                    </td>
                    <td style="font-weight: 600; color: var(--color-primary); text-align: right;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                    <td>
                        <span class="badge {{ $order->status === 'completed' ? 'badge-success' : ($order->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $order->status === 'completed' ? 'Đã thanh toán' : ($order->status === 'pending' ? 'Chưa thanh toán' : 'Đã hủy') }}
                        </span>
                    </td>
                    <td style="color: #64748b; font-size: 0.85rem;">{{ $order->created_at->format('H:i d/m/Y') }}</td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('orders.show', $order->id) }}" title="Xem chi tiết" class="btn" style="background: #f1f5f9; padding: 0.4rem 0.8rem; color: #475569;">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($order->status === 'pending')
                        <a href="{{ route('orders.edit', $order->id) }}" title="Cập nhật món" class="btn" style="background: #f1f5f9; padding: 0.4rem 0.8rem; color: #6366f1;">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Xóa đơn hàng này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $orders->links() }}
    </div>
    @else
    <div style="text-align: center; padding: 3rem;">
        <i class="fas fa-file-invoice" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 1rem;"></i>
        <p style="color: #94a3b8;">Không tìm thấy đơn hàng nào.</p>
    </div>
    @endif
</div>
@endsection
