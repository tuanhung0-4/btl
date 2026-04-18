<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo tài khoản - IMAJI Coffee</title>
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

        .register-card {
            background: var(--color-white);
            width: 100%;
            max-width: 500px;
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
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

        .error-message {
            background: #FFE5E5;
            color: #D32F2F;
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid #D32F2F;
            font-size: 0.9rem;
        }

        .btn-register {
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

        .btn-register:hover {
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
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <div class="card-header-icon">
                <i class="fas fa-mug-hot"></i>
            </div>
            <h1>Tạo tài khoản mới</h1>
            <p>Đăng ký để sử dụng hệ thống</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" 
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" 
                       value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="example@coffee.local" 
                       value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Tối thiểu 8 ký tự" 
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" 
                       placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Tạo tài khoản
            </button>
        </form>

        <div class="card-footer">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập tại đây</a>
        </div>
    </div>
</body>
</html>
