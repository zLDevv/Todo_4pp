<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/theme.js') }}"></script>
    <style>
        html, body {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .login-card h1 {
            font-size: 28px;
            margin: 0 0 10px 0;
            color: #1f2937;
            text-align: center;
        }

        .login-card p {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .login-card form {
            gap: 16px;
        }

        .login-card input::placeholder {
            color: rgba(0, 0, 0, 0.45);
        }
        
        .form-group placeholder {
            color: rgba(0, 0, 0, 0.45);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: #595f69;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #17a2b8;
            box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
        }

        .form-group input {
            margin: 0;
        }

        .login-btn {
            width: 100%;
            padding: 12px 16px;
            background: linear-gradient(135deg, #17a2b8 0%, #0d1b2a 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(23, 162, 184, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #dc2626;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }

        .signup-link a {
            color: #17a2b8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .signup-link a:hover {
            color: #0f7d8f;
        }

        .logo {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .login-card {
                padding: 20px;
                border-radius: 12px;
            }

            .login-card h1 {
                font-size: 22px;
                margin-bottom: 8px;
            }

            .login-card p {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 12px;
            }

            input[type="email"],
            input[type="password"] {
                padding: 10px 12px;
                font-size: 16px;
            }

            .login-btn {
                padding: 10px 12px;
                font-size: 14px;
            }

            .error-message {
                padding: 10px 12px;
                font-size: 12px;
            }

            .signup-link {
                font-size: 12px;
                margin-top: 16px;
            }

            .logo {
                font-size: 28px;
                margin-bottom: 16px;
            }
        }

        @media (max-width: 360px) {
            .login-card {
                padding: 16px;
            }

            .login-card h1 {
                font-size: 18px;
            }

            .login-card p {
                font-size: 11px;
            }

            input[type="email"],
            input[type="password"] {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="logo"></div>
        <h1>Welcome To Todo App</h1>
        <p>Sign in to manage your tasks</p>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #10b981;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="/register">Sign up here</a>
        </div>
    </div>
</div>

</body>
</html>