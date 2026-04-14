@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Quản lý đơn hàng</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Tìm kiếm và lọc các đơn hàng của quán.</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tạo đơn hàng mới
    </a>
</div>

<!-- Filters Section -->
<div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
    <form action="{{ route('orders.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #64748b;">Mã đơn hàng</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="#ID..." 
                style="width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #64748b;">Từ ngày</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                style="width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #64748b;">Đến ngày</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                style="width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">
                <i class="fas fa-filter"></i> Lọc
            </button>
            <a href="{{ route('orders.index') }}" class="btn" style="background: #e2e8f0; color: #475569;">Xóa</a>
        </div>
    </form>
</div>

<div class="card">
    @if($orders->count() > 0)
    <div style="overflow-x: auto;">
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
                    <td>{{ $order->table ? $order->table->name : 'N/A' }}</td>
                    <td style="font-weight: 600; color: var(--primary);">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
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
