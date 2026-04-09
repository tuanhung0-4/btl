@extends('layouts.master')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="font-weight: 700;">Thống kê doanh thu</h3>
        <form action="{{ route('statistics') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem;">Từ ngày</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control" style="padding: 0.5rem; border-radius: 0.4rem; border: 1px solid #e2e8f0;">
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem;">Đến ngày</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control" style="padding: 0.5rem; border-radius: 0.4rem; border: 1px solid #e2e8f0;">
            </div>
            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>
    </div>

    <div style="height: 400px; margin-bottom: 3rem;">
        <canvas id="revenueChart"></canvas>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        <div class="card" style="margin-bottom: 0; box-shadow: none; border: 1px solid #f1f5f9;">
            <h4 style="font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-fire" style="color: #ef4444;"></i>
                Top 10 sản phẩm bán chạy nhất
            </h4>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng bán</th>
                        <th>Tổng doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bestSellers as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                @endif
                                <span style="font-weight: 500;">{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $item->total_sold }}</td>
                        <td style="font-weight: 600; color: var(--primary);">{{ number_format($item->total_sold * $item->product->price, 0, ',', '.') }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Doanh thu (đ)',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#6366f1',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4, // Wave effect
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
                pointHoverRadius: 6,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection
