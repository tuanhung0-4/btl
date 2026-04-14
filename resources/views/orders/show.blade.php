@extends('layouts.master')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Chi tiết đơn hàng #{{ $order->id }}</h2>
            <p style="color: #64748b; font-size: 0.875rem;">Thông tin cho {{ $order->table->name }}.</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card" style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px dashed #e2e8f0;">
            <div>
                <p style="color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Trạng thái đơn</p>
                <div style="padding: 0.4rem 1rem; border-radius: 9999px; display: inline-block; font-size: 0.8rem; font-weight: 600; background: {{ $order->status === 'completed' ? '#dcfce7' : ($order->status === 'pending' ? '#fef3c7' : '#fee2e2') }}; color: {{ $order->status === 'completed' ? '#166534' : ($order->status === 'pending' ? '#92400e' : '#991b1b') }};">
                    {{ $order->status === 'completed' ? 'Đã hoàn tất' : ($order->status === 'pending' ? 'Chưa thanh toán' : 'Đã hủy') }}
                </div>
            </div>
            <div>
                <p style="color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Khách hàng</p>
                <p style="font-weight: 600;">{{ $order->customer_name ?? 'Khách vãng lai' }}</p>
                <p style="font-size: 0.85rem; color: #64748b;">{{ $order->customer_phone ?? '---' }}</p>
            </div>
            <div style="text-align: right;">
                <p style="color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Thời gian</p>
                <p style="font-weight: 500;">{{ $order->created_at->format('H:i:s d/m/Y') }}</p>
            </div>
        </div>

        <h4 style="margin-bottom: 1rem; font-weight: 600;">Danh sách món đã gọi</h4>
        <table style="margin-bottom: 2rem;">
            <thead>
                <tr>
                    <th>Món ăn</th>
                    <th style="text-align: center;">SL</th>
                    <th style="text-align: right;">Đơn giá</th>
                    <th style="text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                    <td style="text-align: right; font-weight: 500;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; padding-top: 2rem; font-weight: 600; font-size: 1.1rem;">TỔNG CỘNG:</td>
                    <td style="text-align: right; padding-top: 2rem; font-weight: 700; font-size: 1.5rem; color: var(--primary);">
                        {{ number_format($order->total_amount, 0, ',', '.') }}đ
                    </td>
                </tr>
            </tfoot>
        </table>

        @if($order->status === 'pending')
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('orders.edit', $order->id) }}" class="btn" style="background: #e0e7ff; color: #4338ca; padding: 0.75rem 1.5rem; border: 1px solid #c7d2fe;">
                <i class="fas fa-edit"></i> CẬP NHẬT MÓN
            </a>
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 0.75rem 1.5rem;">
                    <i class="fas fa-times"></i> Hủy đơn
                </button>
            </form>
            <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; font-size: 1rem; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);">
                    <i class="fas fa-check-double"></i> THANH TOÁN & HOÀN TẤT
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
