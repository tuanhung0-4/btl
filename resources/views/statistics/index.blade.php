@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Thống kê</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Phân tích hoạt động kinh doanh của quán.</p>
    </div>
    <form action="{{ route('statistics') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
        <label style="font-weight: 500; font-size: 0.9rem;">Năm:</label>
        <select name="year" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: white;">
            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </form>
</div>

<!-- Weekly Chart Section -->
<div class="card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h4 style="font-weight: 600;">Biểu đồ doanh thu & Đơn hàng theo ngày trong tuần</h4>
        <form action="{{ route('statistics') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="date" name="week_date" value="{{ $weekDate }}" style="padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
            <button type="submit" style="padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 0.5rem; cursor: pointer;">Cập nhật</button>
        </form>
    </div>
    <div style="height: 350px;">
        <canvas id="dailyRevenueChart"></canvas>
    </div>
</div>

<!-- Daily Revenue Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Daily Revenue Card -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-calendar-week" style="color: var(--primary);"></i> Chi tiết theo ngày trong tuần
        </h4>
        <div style="height: 300px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th style="text-align: center;">Lượng đơn</th>
                        <th style="text-align: right;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
                    @endphp
                    @for($i = 0; $i < 7; $i++)
                        @php 
                            $date = $currentWeekStart->copy()->addDays($i);
                            $dayData = $dailyRevenue->firstWhere('date', $date->format('Y-m-d'));
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $dayNames[$i] }}</strong><br>
                                <span style="font-size: 0.8rem; color: #64748b;">{{ $date->format('d/m') }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge" style="background: #e0e7ff; color: #4338ca;">
                                    {{ $dayData ? $dayData->count : 0 }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 600;">
                                {{ number_format($dayData ? $dayData->total : 0, 0, ',', '.') }}đ
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Weekly Summary -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card" style="background: var(--primary); color: white;">
            <p style="opacity: 0.8; font-size: 0.9rem; margin-bottom: 0.5rem;">Doanh thu tuần ({{ $currentWeekStart->format('d/m') }} - {{ $currentWeekEnd->format('d/m') }})</p>
            <h2 style="font-size: 2.2rem; font-weight: 700;">{{ number_format($dailyRevenue->sum('total'), 0, ',', '.') }}đ</h2>
        </div>

        <div class="card" style="flex-grow: 1;">
            <h4 style="margin-bottom: 1.5rem; font-weight: 600;">Thống kê tuần</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 0.5rem;">Tổng đơn hàng</p>
                    <p style="font-weight: 700; font-size: 1.1rem; color: var(--dark);">{{ $dailyRevenue->sum('count') }}</p>
                </div>
                <div style="padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                    <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 0.5rem;">TB doanh thu/ngày</p>
                    <p style="font-weight: 700; font-size: 1.1rem; color: var(--dark);">{{ number_format($dailyRevenue->count() > 0 ? $dailyRevenue->sum('total') / 7 : 0, 0, ',', '.') }}đ</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Chart Section -->
<div class="card" style="margin-bottom: 2rem;">
    <h4 style="margin-bottom: 1.5rem; font-weight: 600;">Biểu đồ doanh thu & Lượng đơn hàng theo tháng (Năm {{ $year }})</h4>
    <div style="height: 350px;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Revenue Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Monthly Revenue Card -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-calendar-alt" style="color: var(--primary);"></i> Chi tiết theo tháng
        </h4>
        <div style="height: 300px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th style="text-align: center;">Lượng đơn</th>
                        <th style="text-align: right;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @for($m = 1; $m <= 12; $m++)
                        @php $monthData = $monthlyRevenue->firstWhere('month', $m); @endphp
                        <tr>
                            <td>Tháng {{ $m }}</td>
                            <td style="text-align: center;">
                                <span class="badge" style="background: #e0e7ff; color: #4338ca;">
                                    {{ $monthData ? $monthData->count : 0 }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 600;">
                                {{ number_format($monthData ? $monthData->total : 0, 0, ',', '.') }}đ
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quarterly & Yearly Summary -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card" style="background: var(--primary); color: white;">
            <p style="opacity: 0.8; font-size: 0.9rem; margin-bottom: 0.5rem;">Tổng doanh thu năm {{ $year }}</p>
            <h2 style="font-size: 2.2rem; font-weight: 700;">{{ number_format($yearlyRevenue, 0, ',', '.') }}đ</h2>
        </div>

        <div class="card" style="flex-grow: 1;">
            <h4 style="margin-bottom: 1.5rem; font-weight: 600;">Doanh thu theo quý</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                @for($q = 1; $q <= 4; $q++)
                    @php $qData = $quarterlyRevenue->firstWhere('quarter', $q); @endphp
                    <div style="padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                        <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 0.5rem;">Quý {{ $q }}</p>
                        <p style="font-weight: 700; font-size: 1.1rem; color: var(--dark);">{{ number_format($qData ? $qData->total : 0, 0, ',', '.') }}đ</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<!-- Products & Customers Grid -->
<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem;">
    <!-- Top Selling Products -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem; font-weight: 600;">
            <i class="fas fa-mug-hot" style="color: #f59e0b;"></i> Thống kê sản phẩm (Số lượng bán)
        </h4>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th style="text-align: center;">Đã bán</th>
                        <th style="text-align: right;">Doanh thu SP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productStats as $stat)
                    <tr>
                        <td><strong>{{ $stat->product->name }}</strong></td>
                        <td style="text-align: center;"><span class="badge badge-success">{{ $stat->total_sold }}</span></td>
                        <td style="text-align: right;">{{ number_format($stat->total_revenue, 0, ',', '.') }}đ</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align: center; padding: 2rem;">Chưa có dữ liệu sản phẩm.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Potential Customers -->
    <div class="card">
        <h4 style="margin-bottom: 1.5rem; font-weight: 600;">
            <i class="fas fa-crown" style="color: #ec4899;"></i> Khách hàng mua nhiều
        </h4>
        @forelse($topCustomers as $customer)
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 40px; height: 40px; background: #e0e7ff; color: #4338ca; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                {{ substr($customer->customer_name, 0, 1) }}
            </div>
            <div style="flex-grow: 1;">
                <p style="font-weight: 600; font-size: 0.95rem;">{{ $customer->customer_name }}</p>
                <p style="font-size: 0.8rem; color: #64748b;">{{ $customer->customer_phone ?? 'K/H' }}</p>
            </div>
            <div style="text-align: right;">
                <p style="font-weight: 700; color: var(--primary);">{{ number_format($customer->total_spent, 0, ',', '.') }}đ</p>
                <p style="font-size: 0.75rem; color: #94a3b8;">{{ $customer->total_orders }} đơn hàng</p>
            </div>
        </div>
        @empty
        <p style="text-align: center; color: #94a3b8; padding: 2rem;">Chưa có dữ liệu khách hàng.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    // Daily Revenue Chart
    const dailyCtx = document.getElementById('dailyRevenueChart').getContext('2d');
    
    const dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
    const dailyLabels = [];
    const dailyRevenueData = [];
    const dailyOrderData = [];
    
    @php
        $currentDate = $currentWeekStart->copy();
        for($i = 0; $i < 7; $i++) {
            echo "dailyLabels.push('" . $dayNames[$i] . " " . $currentDate->format('d/m') . "');\n";
            $dayData = $dailyRevenue->firstWhere('date', $currentDate->format('Y-m-d'));
            echo "dailyRevenueData.push(" . ($dayData ? $dayData->total : 0) . ");\n";
            echo "dailyOrderData.push(" . ($dayData ? $dayData->count : 0) . ");\n";
            $currentDate->addDay();
        }
    @endphp

    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [
                {
                    label: 'Doanh thu (VNĐ)',
                    data: dailyRevenueData,
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 1,
                    yAxisID: 'y',
                    borderRadius: 5,
                },
                {
                    label: 'Lượng đơn hàng',
                    data: dailyOrderData,
                    backgroundColor: 'rgba(236, 72, 153, 0.5)',
                    borderColor: 'rgb(236, 72, 153)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Doanh thu'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Lượng đơn'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.dataset.yAxisID === 'y') {
                                label += context.parsed.y.toLocaleString('vi-VN') + 'đ';
                            } else {
                                label += context.parsed.y + ' đơn';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Monthly Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    const months = [@foreach(range(1, 12) as $m)'T{{ $m }}',@endforeach];
    const revenueData = [@foreach(range(1, 12) as $m){{ $monthlyRevenue->firstWhere('month', $m)->total ?? 0 }},@endforeach];
    const orderData = [@foreach(range(1, 12) as $m){{ $monthlyRevenue->firstWhere('month', $m)->count ?? 0 }},@endforeach];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 1,
                    yAxisID: 'y',
                    borderRadius: 5,
                },
                {
                    label: 'Lượng đơn hàng',
                    data: orderData,
                    backgroundColor: 'rgba(236, 72, 153, 0.5)',
                    borderColor: 'rgb(236, 72, 153)',
                    borderWidth: 1,
                    type: 'line', // Mix line for orders to make it distinct
                    yAxisID: 'y1',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Doanh thu'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Lượng đơn'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.dataset.yAxisID === 'y') {
                                label += context.parsed.y.toLocaleString('vi-VN') + 'đ';
                            } else {
                                label += context.parsed.y + ' đơn';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
