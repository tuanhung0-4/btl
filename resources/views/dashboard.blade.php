@extends('layouts.master')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="margin-bottom: 0; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="opacity: 0.8; font-size: 0.875rem; font-weight: 500;">Doanh thu hôm nay</p>
                <h3 style="font-size: 1.75rem; margin-top: 0.5rem;">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-wallet fa-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Tổng đơn hàng</p>
                <h3 style="font-size: 1.75rem; margin-top: 0.5rem; color: #1e293b;">{{ $totalOrders }}</h3>
            </div>
            <div style="background: #f1f5f9; color: #6366f1; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-shopping-bag fa-lg"></i>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Bàn đang có khách</p>
                <h3 style="font-size: 1.75rem; margin-top: 0.5rem; color: #1e293b;">{{ $occupiedTables }}</h3>
            </div>
            <div style="background: #f1f5f9; color: #f59e0b; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-users fa-lg"></i>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #64748b; font-size: 0.875rem; font-weight: 500;">Số lượng món</p>
                <h3 style="font-size: 1.75rem; margin-top: 0.5rem; color: #1e293b;">{{ $totalProducts }}</h3>
            </div>
            <div style="background: #f1f5f9; color: #22c55e; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-utensils fa-lg"></i>
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div class="card">
        <h4 style="font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-star" style="color: #f59e0b;"></i>
            Bán chạy nhất
        </h4>
        <table>
            <thead>
                <tr>
                    <th>Món ăn</th>
                    <th>Đã bán</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $item)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                            @else
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                            <span style="font-weight: 500;">{{ $item->product->name }}</span>
                        </div>
                    </td>
                    <td>{{ $item->total_sold }}</td>
                    <td style="font-weight: 600; color: #6366f1;">{{ number_format($item->total_sold * $item->product->price, 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h4 style="font-weight: 600; margin-bottom: 1.5rem;">Doanh thu theo loại</h4>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($revenueByCategory as $category)
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.875rem; font-weight: 500;">{{ $category['name'] }}</span>
                        <span style="font-size: 0.875rem; color: #64748b;">{{ number_format($category['revenue'], 0, ',', '.') }}đ</span>
                    </div>
                    <div style="height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                        @php
                            $percentage = $totalRevenue > 0 ? ($category['revenue'] / $totalRevenue) * 100 : 0;
                        @endphp
                        <div style="height: 100%; width: {{ $percentage }}%; background: var(--primary);"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
