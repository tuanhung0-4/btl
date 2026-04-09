@extends('layouts.master')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">Tạo đơn hàng mới</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            <!-- Cột trái: Chọn bàn -->
            <div class="card">
                <h4 style="margin-bottom: 1.5rem; font-weight: 600;">1. Chọn bàn trống</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @foreach($tables as $table)
                    <label style="{{ $table->status === 'occupied' ? 'opacity: 0.5; cursor: not-allowed;' : 'cursor: pointer;' }}">
                        <input type="radio" name="table_id" value="{{ $table->id }}" {{ $table->status === 'occupied' ? 'disabled' : 'required' }} style="display: none;" onchange="this.parentElement.parentElement.querySelectorAll('.table-card').forEach(el => { el.style.border = '1px solid #e2e8f0'; el.style.background = 'white'; }); const card = this.parentElement.querySelector('.table-card'); card.style.border = '2px solid var(--primary)'; card.style.background = '#f0f7ff';">
                        <div class="table-card" style="padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; text-align: center; transition: all 0.2s; background: {{ $table->status === 'occupied' ? '#f1f5f9' : 'white' }};">
                            <i class="fas fa-couch" style="display: block; margin-bottom: 0.5rem; color: {{ $table->status === 'occupied' ? 'var(--danger)' : 'var(--success)' }};"></i>
                            <span style="font-weight: 500;">{{ $table->name }}</span>
                            @if($table->status === 'occupied')
                                <div style="font-size: 0.65rem; color: var(--danger); font-weight: 600;">ĐANG CÓ KHÁCH</div>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cột phải: Chọn món -->
            <div class="card">
                <h4 style="margin-bottom: 1.5rem; font-weight: 600;">2. Chọn món & Số lượng</h4>
                
                <!-- Category Filter -->
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn active-cat" onclick="filterProducts('all', this)" style="padding: 0.4rem 1rem; border: 1px solid #e2e8f0; background: #6366f1; color: white;">Tất cả</button>
                    @foreach($categories as $category)
                        <button type="button" class="btn" onclick="filterProducts('{{ $category->id }}', this)" style="padding: 0.4rem 1rem; border: 1px solid #e2e8f0; background: white; color: #4b5563;">{{ $category->name }}</button>
                    @endforeach
                </div>

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
                            <tr class="product-item" data-category="{{ $product->category_id }}">
                                <td>
                                    <span style="font-weight: 500;">{{ $product->name }}</span>
                                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                </td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][quantity]" value="0" min="0" style="width: 100%; padding: 0.4rem; border: 1px solid #e2e8f0; border-radius: 0.25rem;">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('orders.index') }}" class="btn" style="background: #f1f5f9;">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-check"></i> Xác nhận đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function filterProducts(categoryId, btn) {
        // Update active button
        const buttons = btn.parentElement.querySelectorAll('button');
        buttons.forEach(b => {
            b.style.background = 'white';
            b.style.color = '#4b5563';
        });
        btn.style.background = '#6366f1';
        btn.style.color = 'white';

        // Filter table rows
        const rows = document.querySelectorAll('.product-item');
        rows.forEach(row => {
            if (categoryId === 'all' || row.getAttribute('data-category') === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
