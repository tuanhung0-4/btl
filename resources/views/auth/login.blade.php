<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - IMAJI Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #8B6F47;
            --color-primary-light: #D4A574;
            --color-dark: #1A2332;
            --color-gray-100: #F1F3F5;
            --color-gray-200: #E9ECEF;
            --color-gray-500: #ADB5BD;
            --color-white: #FFFFFF;
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #F5DEB3 0%, #D4A574 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            gap: 3rem;
            align-items: center;
        }

        .auth-info {
            flex: 1;
            color: white;
            display: none;
        }

        @media (min-width: 768px) {
            .auth-info { display: block; }
        }

        .auth-info h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .auth-info p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .auth-info ul {
            list-style: none;
        }

        .auth-info li {
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .auth-info li i {
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            flex: 1;
            background: var(--color-white);
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .card-header-icon {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }

        .card-header p {
            color: var(--color-gray-500);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--color-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--color-gray-200);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: var(--color-gray-500);
        }

        .form-check input {
            cursor: pointer;
        }

        .error-message {
            background: #FFE5E5;
            color: #D32F2F;
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid #D32F2F;
            font-size: 0.9rem;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: #6B5438;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 111, 71, 0.2);
        }

        .card-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: var(--color-gray-500);
        }

        .card-footer a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .card-footer a:hover {
            color: var(--color-primary-light);
        }

        .demo-accounts {
            background: var(--color-gray-100);
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border: 1px solid var(--color-gray-200);
        }

        .demo-accounts strong {
            color: var(--color-primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .demo-account-item {
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--color-gray-200);
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
        }

        .demo-account-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .demo-account-role {
            display: inline-block;
            background: var(--color-primary);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-info">
            <h2>IMAJI Coffee</h2>
            <p>Hệ thống quản lý quán cà phê hiện đại</p>
            <ul>
                <li><i class="fas fa-check"></i> <span>Quản lý sản phẩm và danh mục</span></li>
                <li><i class="fas fa-check"></i> <span>Theo dõi đơn hàng và bàn</span></li>
                <li><i class="fas fa-check"></i> <span>Thống kê doanh thu chi tiết</span></li>
                <li><i class="fas fa-check"></i> <span>Quản lý nhân viên dễ dàng</span></li>
            </ul>
        </div>

        <div class="login-card">
            <div class="card-header">
                <div class="card-header-icon">
                    <i class="fas fa-mug-hot"></i>
                </div>
                <h1>Đăng nhập</h1>
                <p>Vào hệ thống quản lý</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Tên đăng nhập hoặc Email</label>
                    <input type="text" name="login" class="form-control" placeholder="Nhập tên đăng nhập hoặc email" 
                           value="{{ old('login') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" 
                           required>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" value="1">
                    <label for="remember">Ghi nhớ lần này</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>

            <div class="card-footer">
                Chưa có tài khoản? <a href="{{ route('register') }}">Tạo tài khoản mới</a>
            </div>
        </div>
    </div>
</body>
</html>
