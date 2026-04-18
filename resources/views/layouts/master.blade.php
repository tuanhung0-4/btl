<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Coffee Manager') }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- IMAJI Coffee Style -->
    <link rel="stylesheet" href="{{ asset('css/imaji-style.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- Brand -->
            <div class="sidebar-brand">
                <i class="fas fa-mug-hot" style="font-size: 2rem; color: #F5DEB3;"></i>
                <span class="sidebar-brand-text">COFFEE</span>
            </div>

            <!-- User Profile -->
            @auth
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info" style="color: white;">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->role }}</p>
                </div>
            </div>
            @endauth

            <!-- Navigation Menu -->
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Trang chủ</span>
                        </a>
                    </li>

                    @if(Auth::user() && Auth::user()->role === 'admin')
                    <div class="nav-section-title">Quản lý</div>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    @endif

                    <div class="nav-section-title">Hoạt động</div>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-coffee"></i>
                            <span>Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                            <i class="fas fa-chair"></i>
                            <span>Bàn & Chỗ ngồi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>

                    @if(Auth::user() && Auth::user()->role === 'admin')
                    <div class="nav-section-title">Báo cáo</div>
                    <li class="nav-item">
                        <a href="{{ route('statistics') }}" class="nav-link {{ request()->routeIs('statistics') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Thống kê</span>
                        </a>
                    </li>
                    @endif

                    <div class="nav-section-title">Khác</div>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #FFB6C6;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Đăng xuất</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- HEADER -->
            <header>
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: var(--color-dark); margin: 0;">
                        @switch(Route::current()->getName())
                            @case('dashboard') Trang chủ @break
                            @case('products.index') Quản lý sản phẩm @break
                            @case('products.create') Thêm sản phẩm @break
                            @case('products.edit') Chỉnh sửa sản phẩm @break
                            @case('categories.index') Danh mục @break
                            @case('tables.index') Bàn & Chỗ ngồi @break
                            @case('orders.index') Đơn hàng @break
                            @case('users.index') Quản lý tài khoản @break
                            @case('statistics') Thống kê @break
                            @default Dashboard @endswitch
                    </h2>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="text-align: right;">
                        <p style="margin: 0; color: var(--color-gray-600); font-size: 0.9rem;">
                            Xin chào, <strong>{{ Auth::user()->name }}</strong>
                        </p>
                        <p style="margin: 0; color: var(--color-gray-500); font-size: 0.8rem;">
                            {{ date('l, d/m/Y', strtotime('now')) }}
                        </p>
                    </div>
                    <div style="width: 45px; height: 45px; background: var(--color-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap (for advanced components if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
