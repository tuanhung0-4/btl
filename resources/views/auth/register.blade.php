<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Coffee Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #008080;
            --primary-light: #4db6ac;
            --secondary: #00ced1;
            --vibrant-cyan: #00fbff;
            --dark: #002b2b;
            --light: #e0f2f1;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background */
        body::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 251, 255, 0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 500px;
            padding: 3rem 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 43, 43, 0.5);
            z-index: 10;
            border: 1px solid rgba(0, 251, 255, 0.2);
            position: relative;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 0 10px rgba(0, 251, 255, 0.4));
        }

        .brand h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
            transition: all 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 3.2rem;
            border: 2px solid #e0f2f1;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s;
            background: #f8fafc;
            color: var(--dark);
        }

        .form-control:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 20px rgba(0, 128, 128, 0.1);
        }

        .form-control:focus + i {
            color: var(--secondary);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 128, 128, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 128, 128, 0.4);
            filter: brightness(1.1);
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ffcdd2;
            font-weight: 500;
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #64748b;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }

        .footer a:hover {
            border-bottom-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="register-card">
        <div class="brand">
            <i class="fas fa-coffee"></i>
            <h1>Tạo tài khoản mới</h1>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Họ và tên</label>
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required value="{{ old('name') }}">
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tên đăng nhập (Username)</label>
                <div class="input-group">
                    <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required value="{{ old('username') }}">
                    <i class="fas fa-id-badge"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required value="{{ old('email') }}">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Tối thiểu 8 ký tự" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Xác nhận mật khẩu</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">Đăng ký tài khoản</button>
        </form>

        <div class="footer">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
        </div>
    </div>
</body>
</html>
