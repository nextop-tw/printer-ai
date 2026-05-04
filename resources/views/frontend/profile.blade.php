<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>個人資料 — PrinterAI</title>
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
<div class="dashboard-layout">
  @include('frontend.partials.sidebar')
  <main class="main-content">
    <div class="topbar">
      <div style="display:flex;align-items:center;gap:0.75rem">
        <button class="sidebar-toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <span class="topbar-greeting"><strong>帳號設定</strong></span>
      </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(40,202,65,0.07);border:1px solid rgba(40,202,65,0.28);border-radius:6px;padding:10px 14px;font-size:0.84rem;color:#1a7a2e;margin-bottom:1rem">
      {{ session('success') }}
    </div>
    @endif

    <div style="display:grid;grid-template-columns:280px 1fr;gap:2rem;align-items:start">
      <!-- Avatar Panel -->
      <div class="widget" style="text-align:center">
        @if(Auth::user()->avatar)
          <img src="{{ Auth::user()->avatar }}" alt="頭像" style="width:80px;height:80px;border-radius:50%;margin:0 auto 1rem;display:block;object-fit:cover">
        @else
          <div style="width:80px;height:80px;border-radius:50%;background:var(--accent);color:white;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;margin:0 auto 1rem">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        @endif
        <div style="font-weight:700;font-size:1.1rem">{{ Auth::user()->name }}</div>
        <div style="font-size:0.82rem;color:var(--muted);margin-bottom:1rem">{{ Auth::user()->email }}</div>
        <div style="font-size:0.78rem;color:var(--muted);line-height:1.8">
          <div>加入時間：{{ Auth::user()->created_at->format('Y 年 m 月') }}</div>
        </div>
      </div>

      <!-- Form -->
      <div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')
          <div class="widget" style="margin-bottom:1.5rem">
            <h4 style="margin-bottom:1.5rem;font-size:1rem">基本資料</h4>
            <div class="form-group">
              <label class="form-label">姓名</label>
              <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required />
            </div>
            <div class="form-group">
              <label class="form-label">電子信箱</label>
              <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled style="background:var(--cream);cursor:not-allowed" />
              <p class="form-hint">Email 透過 Google 登入，無法直接修改。</p>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> 儲存變更</button>
          </div>
        </form>

        @if(!Auth::user()->google_id)
        <form method="POST" action="{{ route('profile.password') }}">
          @csrf
          @method('PATCH')
          <div class="widget">
            <h4 style="margin-bottom:1.5rem;font-size:1rem">變更密碼</h4>
            @error('current_password')<p style="color:var(--accent);font-size:0.84rem;margin-bottom:0.5rem">{{ $message }}</p>@enderror
            <div class="form-group"><label class="form-label">目前密碼</label><input type="password" class="form-control" name="current_password" placeholder="••••••••" /></div>
            <div class="form-group"><label class="form-label">新密碼</label><input type="password" class="form-control" name="password" placeholder="最少 8 個字元" /></div>
            <div class="form-group"><label class="form-label">確認新密碼</label><input type="password" class="form-control" name="password_confirmation" placeholder="再次輸入新密碼" /></div>
            <button type="submit" class="btn btn-outline">更新密碼</button>
          </div>
        </form>
        @endif
      </div>
    </div>
  </main>
</div>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>
