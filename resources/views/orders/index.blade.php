@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Danh sách đơn hàng</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Quản lý các đơn hàng hiện có.</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tạo đơn hàng mới
    </a>
</div>

<div class="card">
    @if($orders->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Bàn</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th style="text-align: right;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td><strong>#{{ $order->id }}</strong></td>
                <td>{{ $order->table->name }}</td>
                <td style="font-weight: 600; color: var(--primary);">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                <td>
                    <x-badge :type="$order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger')">
                        {{ $order->status === 'completed' ? 'Đã hoàn tất' : ($order->status === 'pending' ? 'Chưa thanh toán' : 'Đã hủy') }}
                    </x-badge>
                </td>
                <td style="color: #64748b; font-size: 0.85rem;">{{ $order->created_at->format('H:i d/m/Y') }}</td>
                <td style="text-align: right;">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn" style="background: #f1f5f9; padding: 0.4rem 0.8rem;">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 1.5rem;">
        {{ $orders->links() }}
    </div>
    @else
    <div style="text-align: center; padding: 3rem;">
        <p style="color: #94a3b8;">Chưa có đơn hàng nào.</p>
    </div>
    @endif
</div>
@endsection
