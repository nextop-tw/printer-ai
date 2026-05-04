<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>登入 — PrinterAI</title>
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
<div class="auth-page">
  <!-- Left Panel -->
  <div class="auth-left">
    <div>
      <a href="{{ route('home') }}" class="auth-brand">
        <div class="brand-icon"><i class="bi bi-printer-fill"></i></div>PrinterAI
      </a>
    </div>
    <div>
      <p class="auth-tagline">從 AI 生成的設計稿，到專業印刷品——省去所有技術障礙，讓創意直達紙上。</p>
      <div class="auth-features">
        <div class="auth-feature"><i class="bi bi-shield-check"></i> 自動印刷品質偵測</div>
        <div class="auth-feature"><i class="bi bi-magic"></i> 一鍵自動修正檔案</div>
        <div class="auth-feature"><i class="bi bi-eye"></i> 視覺化出血與安全區預覽</div>
        <div class="auth-feature"><i class="bi bi-truck"></i> 全球印刷配送網絡</div>
        <div class="auth-feature"><i class="bi bi-graph-up"></i> 完整訂單追蹤後台</div>
      </div>
    </div>
    <div style="font-size:0.78rem;color:rgba(255,255,255,0.25)">© 2025 PrinterAI</div>
  </div>
  <!-- Right Panel -->
  <div class="auth-right">
    <div class="auth-form-box">
      <h2>歡迎回來</h2>
      <p class="sub">登入你的 PrinterAI 帳號</p>

      @if ($errors->any())
        <div class="error-msg show">
          <i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}
        </div>
      @endif

      @if (session('status'))
        <div style="background:rgba(40,202,65,0.07);border:1px solid rgba(40,202,65,0.28);border-radius:6px;padding:10px 14px;font-size:0.84rem;color:#1a7a2e;margin-bottom:1rem">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
          <label class="form-label" for="email">電子信箱</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="請輸入 Email" autocomplete="email" required />
        </div>
        <div class="form-group">
          <label class="form-label" for="password">密碼</label>
          <div style="position:relative">
            <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" autocomplete="current-password" required />
            <button type="button" id="togglePw" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;color:var(--muted);font-size:1rem;cursor:pointer;border:none;padding:0">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
          <label style="display:flex;align-items:center;gap:6px;font-size:0.85rem;cursor:pointer">
            <input type="checkbox" name="remember" style="accent-color:var(--accent)" /> 保持登入狀態
          </label>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="bi bi-box-arrow-in-right"></i> 登入
        </button>
      </form>

      <div class="auth-divider"><span>或使用以下方式登入</span></div>

      <a href="{{ route('auth.google') }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-bottom:0.75rem">
        <i class="bi bi-google"></i> 使用 Google 登入
      </a>

      <p style="text-align:center;font-size:0.85rem;color:var(--muted);margin-top:2rem">
        還沒有帳號？<a href="{{ route('auth.google') }}" style="color:var(--accent);font-weight:600">使用 Google 快速註冊</a>
      </p>
    </div>
  </div>
</div>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
<script>
document.getElementById('togglePw')?.addEventListener('click', function() {
  const pw = document.getElementById('password');
  const icon = this.querySelector('i');
  if (pw.type === 'password') { pw.type = 'text'; icon.className = 'bi bi-eye-slash'; }
  else { pw.type = 'password'; icon.className = 'bi bi-eye'; }
});
</script>
</body>
</html>
