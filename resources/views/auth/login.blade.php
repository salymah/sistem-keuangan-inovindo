<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Keuangan Inovindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3fa0 0%, #2fb32f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-logo {
            width: 90px; height: 90px;
            margin: 0 auto 1.25rem;
            display: block;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.15));
        }
        .login-card {
            background: #fff; border-radius: 14px; padding: 2.25rem 2rem;
            width: 100%; max-width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .login-card h5 { font-weight: 700; color: #1f2937; }
        .login-card .subtitle { color: #8b93a7; font-size: .85rem; margin-bottom: 1.5rem; }
        .form-label { font-size: .82rem; color: #555; font-weight: 500; }
        .btn-login {
            background: #0d7377; border: none; font-weight: 600; padding: .6rem;
        }
        .btn-login:hover { background: #0a5c5f; }
    </style>
</head>
<body>

    <div>
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Inovindo Digital Media" class="login-logo">

        <div class="login-card">
            <h5 class="mb-1">Login Sistem Keuangan</h5>
            <div class="subtitle">Inovindo Digital Media</div>

            @if (session('status'))
                <div class="alert alert-success py-2 small">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label small text-muted" for="remember_me">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-login btn-primary w-100 text-white">LOGIN</button>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none">Lupa password?</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

</body>
</html>