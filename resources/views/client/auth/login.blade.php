<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登入 | 印刷媒合平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .login-card { max-width: 400px; margin: 80px auto; }
        .btn-google {
            background: #fff;
            border: 1px solid #dadce0;
            color: #3c4043;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 10px;
            transition: background .2s;
        }
        .btn-google:hover { background: #f8f9fa; border-color: #bbb; color: #3c4043; }
        .btn-google img { width: 20px; height: 20px; }
        .divider { display: flex; align-items: center; gap: 12px; color: #aaa; margin: 1.2rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; border-top: 1px solid #dee2e6; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <h3>🖨️ 印刷媒合平台</h3>
        <p class="text-muted">登入查看我的訂單</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            @if($errors->any())
                <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif

            {{-- Google 登入 --}}
            <a href="{{ route('auth.google') }}" class="btn btn-google w-100 mb-3">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                使用 Google 帳號登入
            </a>

            <div class="divider">或</div>

            {{-- Email 登入 --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="your@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">密碼</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">登入</button>
            </form>

            <hr>
            <p class="text-center text-muted small mb-0">
                還沒有帳號？<a href="{{ route('order.create') }}">直接下單</a>，付款後自動建立帳號。
            </p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
