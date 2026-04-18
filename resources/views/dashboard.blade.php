@extends('layouts.master')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-4" style="margin-bottom: 2rem;">
    <!-- Revenue Card -->
    <div class="card card-primary stat-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p class="stat-label">Doanh thu hôm nay</p>
                <p class="stat-value">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
            </div>
            <div style="font-size: 2rem; opacity: 0.3;">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="card card-yellow stat-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p class="stat-label" style="color: #666;">Tổng đơn hàng</p>
                <p class="stat-value" style="color: var(--color-dark);">{{ $totalOrders }}</p>
            </div>
            <div style="font-size: 2rem; color: var(--color-warning); opacity: 0.3;">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>

    <!-- Tables Card -->
    <div class="card card-cyan stat-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p class="stat-label" style="color: #666;">Bàn có khách</p>
                <p class="stat-value" style="color: var(--color-dark);">{{ $occupiedTables }}</p>
            </div>
            <div style="font-size: 2rem; color: var(--color-success); opacity: 0.3;">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="card card-blue stat-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p class="stat-label" style="color: #666;">Số lượng món</p>
                <p class="stat-value" style="color: var(--color-dark);">{{ $totalProducts }}</p>
            </div>
            <div style="font-size: 2rem; color: var(--color-info); opacity: 0.3;">
                <i class="fas fa-coffee"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Grid -->
<div class="grid" style="grid-template-columns: 2fr 1fr; margin-bottom: 2rem;">
    <!-- Top Selling Products -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-fire" style="color: var(--color-warning); margin-right: 0.5rem;"></i>
                Bán chạy nhất
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th style="text-align: center;">Số lượng</th>
                        <th style="text-align: right;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover; background: var(--color-gray-100);">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 6px; background: var(--color-gray-100); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-coffee" style="color: var(--color-gray-400);"></i>
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $item->product->name }}</strong>
                                    <p style="font-size: 0.8rem; color: var(--color-gray-500); margin: 0;">{{ $item->product->category->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-primary">{{ $item->total_sold }}</span>
                        </td>
                        <td style="text-align: right; font-weight: 600; color: var(--color-primary);">
                            {{ number_format($item->total_sold * $item->product->price, 0, ',', '.') }}đ
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem; color: var(--color-gray-500);">
                            Chưa có dữ liệu bán hàng
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Revenue by Category -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-chart-pie" style="color: var(--color-primary); margin-right: 0.5rem;"></i>
                Doanh thu theo loại
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            @forelse($revenueByCategory as $category)
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.9rem; font-weight: 500;">{{ $category['name'] }}</span>
                        <span style="font-size: 0.85rem; font-weight: 600; color: var(--color-primary);">
                            {{ number_format($category['revenue'], 0, ',', '.') }}đ
                        </span>
                    </div>
                    <div style="height: 8px; background: var(--color-gray-200); border-radius: 4px; overflow: hidden;">
                        @php
                            $percentage = $totalRevenue > 0 ? ($category['revenue'] / $totalRevenue) * 100 : 0;
                        @endphp
                        <div style="height: 100%; width: {{ $percentage }}%; background: linear-gradient(90deg, var(--color-primary), var(--color-primary-light)); border-radius: 4px;"></div>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: var(--color-gray-500); padding: 2rem 0;">
                    Chưa có dữ liệu
                </p>
            @endforelse
        </div>
    </div>
</div>

@endsection
