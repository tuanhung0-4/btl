<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Coffee Manager</title>
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

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 450px;
            padding: 3.5rem 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 43, 43, 0.5);
            z-index: 10;
            border: 1px solid rgba(0, 251, 255, 0.2);
            position: relative;
        }

        .brand {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand i {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 10px rgba(0, 251, 255, 0.4));
        }

        .brand h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
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
            padding: 1rem 1rem 1rem 3.2rem;
            border: 2px solid #e0f2f1;
            border-radius: 0.75rem;
            font-size: 1rem;
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
            transform: translateY(-50%) scale(1.2);
        }

        .btn-login {
            width: 100%;
            padding: 1.1rem;
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
            margin-top: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 128, 128, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 128, 128, 0.4);
            filter: brightness(1.1);
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            border: 1px solid #ffcdd2;
            font-weight: 500;
        }

        .footer {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 0.95rem;
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

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #64748b;
            cursor: pointer;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="login-card">
        <div class="brand">
            <i class="fas fa-coffee"></i>
            <h1>Coffee Manager</h1>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email hoặc Tên đăng nhập</label>
                <div class="input-group">
                    <input type="text" name="login" class="form-control" placeholder="Email hoặc username" required value="{{ old('login') }}">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Duy trì đăng nhập
                </label>
                {{-- <a href="#" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">Quên mật khẩu?</a> --}}
            </div>

            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>

        <div class="footer">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html>
