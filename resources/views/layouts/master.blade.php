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
    <style>
        :root {
            --primary: #008080; /* Teal */
            --primary-light: #4db6ac;
            --secondary: #00ced1; /* Dark Turquoise / Cyan */
            --vibrant-cyan: #00fbff;
            --dark: #002b2b; /* Deep Dark Teal */
            --light: #e0f2f1; /* Light Teal background */
            --white: #ffffff;
            --danger: #ff5252;
            --success: #00c853;
            --warning: #ffd600;
            --sidebar-width: 250px;
            --card-shadow: 0 4px 6px -1px rgba(0, 128, 128, 0.1), 0 2px 4px -1px rgba(0, 128, 128, 0.06);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar - Flat Teal Style */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary) 0%, var(--dark) 100%);
            color: white;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0, 43, 43, 0.2);
        }

        .sidebar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--vibrant-cyan);
        }

        .nav-list {
            list-style: none;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 0.4rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.25rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            background: rgba(0, 251, 255, 0.1);
            color: var(--vibrant-cyan);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: var(--vibrant-cyan);
            box-shadow: inset 4px 0 0 var(--vibrant-cyan);
            font-weight: 700;
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: relative;
        }

        header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 1.2rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 128, 128, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .content-body {
            padding: 2.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Grid Cards - Flat Card Style */
        .card {
            background: var(--white);
            border-radius: 0.75rem;
            border: 1px solid rgba(0, 128, 128, 0.05);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 128, 128, 0.15);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.7rem 1.4rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--dark); transform: scale(1.05); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-warning { background: var(--warning); color: var(--dark); }
        
        /* Table Styles - Teal Accents */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-top: 1rem;
        }

        th {
            text-align: left;
            padding: 1rem 1.5rem;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        td {
            padding: 1.2rem 1.5rem;
            background: var(--white);
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        td:first-child { border-left: 1px solid #f1f5f9; border-radius: 0.75rem 0 0 0.75rem; }
        td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 0.75rem 0.75rem 0; }

        .badge {
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success { background: #e8f5e9; color: var(--success); }
        .badge-danger { background: #ffebee; color: var(--danger); }
        .badge-warning { background: #fffde7; color: var(--warning); }

        /* Floating Navigation Pill (Home/Contact etc as requested) */
        .floating-nav {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            background: rgba(0, 43, 43, 0.85);
            backdrop-filter: blur(10px);
            padding: 0.6rem;
            border-radius: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .float-item {
            padding: 0.6rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 1.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .float-item:hover, .float-item.active {
            background: var(--primary);
            color: white;
        }

        /* Weather Widget Simulation */
        .weather-widget {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            background: var(--white);
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--card-shadow);
            z-index: 1000;
            border-left: 4px solid var(--vibrant-cyan);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            justify-content: center;
        }
        .page-item .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.4rem;
            text-decoration: none;
            color: var(--secondary);
            background: white;
        }
        .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-mug-hot" style="color: var(--vibrant-cyan); font-size: 2rem;"></i>
            <span>Coffee Manager</span>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Tổng quan</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Quản lý tài khoản</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-mug-hot"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                    <i class="fas fa-table"></i>
                    <span>Bàn & Chỗ ngồi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Đơn hàng</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
            <li class="nav-item">
                <a href="{{ route('statistics') }}" class="nav-link {{ request()->routeIs('statistics') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Thống kê</span>
                </a>
            </li>
            @endif
        </ul>
        <div style="margin-top: auto;">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2 id="page-title">Coffee Manager</h2>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="text-align: right;">
                    <div style="font-weight: 600;">{{ Auth::user()->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--secondary);">{{ Auth::user()->role === 'admin' ? 'Quản trị viên' : 'Nhân viên' }}</div>
                </div>
                <div style="position: relative;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=008080&color=fff" style="width: 45px; border-radius: 12px; border: 2px solid var(--primary-light);">
                </div>
                <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="padding: 0.5rem; border-radius: 10px;" title="Đăng xuất">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <div class="content-body">
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="danger" :message="session('error')" />
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Floating Navigation (From user request) -->
    <div class="floating-nav">
        <a href="{{ route('dashboard') }}" class="float-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
        <a href="{{ route('products.index') }}" class="float-item {{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
        <a href="{{ route('orders.index') }}" class="float-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a>
        <a href="#" class="float-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--danger);">Logout</a>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
