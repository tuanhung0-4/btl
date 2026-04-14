@extends('layouts.master')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">Cập nhật đơn hàng #{{ $order->id }}</h2>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            <!-- Cột trái: Chọn bàn -->
            <div class="card">
                <h4 style="margin-bottom: 1.5rem; font-weight: 600;">1. Thông tin khách hàng</h4>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #64748b;">Tên khách hàng</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" placeholder="Ví dụ: Anh Tuấn" style="width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
                </div>
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #64748b;">Số điện thoại</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" placeholder="090..." style="width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; outline: none;">
                </div>

                <h4 style="margin-bottom: 1.5rem; font-weight: 600;">2. Chọn bàn</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @foreach($tables as $table)
                    @php
                        $isCurrentTable = $order->table_id === $table->id;
                    @endphp
                    <label style="{{ ($table->status === 'occupied' && !$isCurrentTable) ? 'opacity: 0.5; cursor: not-allowed;' : 'cursor: pointer;' }}">
                        <input type="radio" name="table_id" value="{{ $table->id }}" {{ $order->table_id === $table->id ? 'checked' : '' }} {{ ($table->status === 'occupied' && !$isCurrentTable) ? 'disabled' : 'required' }} style="display: none;" onchange="updateTableStyle(this)">
                        <div class="table-card" style="padding: 1rem; border: {{ $isCurrentTable ? '2px solid var(--primary)' : '1px solid #e2e8f0' }}; border-radius: 0.5rem; text-align: center; transition: all 0.2s; background: {{ $isCurrentTable ? '#f0f7ff' : (($table->status === 'occupied' && !$isCurrentTable) ? '#f1f5f9' : 'white') }};">
                            <i class="fas fa-couch" style="display: block; margin-bottom: 0.5rem; color: {{ ($table->status === 'occupied' && !$isCurrentTable) ? 'var(--danger)' : 'var(--success)' }};"></i>
                            <span style="font-weight: 500;">{{ $table->name }}</span>
                            @if($table->status === 'occupied' && !$isCurrentTable)
                                <div style="font-size: 0.65rem; color: var(--danger); font-weight: 600;">ĐANG CÓ KHÁCH</div>
                            @elseif($isCurrentTable)
                                <div style="font-size: 0.65rem; color: var(--primary); font-weight: 600;">HIỆN TẠI</div>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cột phải: Chọn món -->
            <div class="card">
                <h4 style="margin-bottom: 1.5rem; font-weight: 600;">2. Cập nhật món & Số lượng</h4>
                
                <div style="max-height: 400px; overflow-y: auto; padding-right: 0.5rem;">
                    <table style="margin-top: 0;">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th style="width: 120px;">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                            @foreach($products as $index => $product)
                            @php
                                $orderedItem = $order->orderItems->where('product_id', $product->id)->first();
                                $quantity = $orderedItem ? $orderedItem->quantity : 0;
                            @endphp
                            <tr class="product-item" data-category="{{ $product->category_id }}">
                                <td>
                                    <span style="font-weight: 500;">{{ $product->name }}</span>
                                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                </td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][quantity]" value="{{ $quantity }}" min="0" style="width: 100%; padding: 0.4rem; border: 1px solid #e2e8f0; border-radius: 0.25rem;">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('orders.index') }}" class="btn" style="background: #f1f5f9;">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-save"></i> Cập nhật đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateTableStyle(input) {
        input.parentElement.parentElement.querySelectorAll('.table-card').forEach(el => {
            el.style.border = '1px solid #e2e8f0';
            el.style.background = 'white';
        });
        const card = input.parentElement.querySelector('.table-card');
        card.style.border = '2px solid var(--primary)';
        card.style.background = '#f0f7ff';
    }
</script>
@endpush
@endsection
