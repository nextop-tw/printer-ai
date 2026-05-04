<nav class="navbar">
  <div class="navbar-inner">
    <a href="{{ route('home') }}" class="navbar-brand">
      <div class="brand-icon"><i class="bi bi-printer-fill"></i></div>PrinterAI
    </a>
    <ul class="navbar-nav">
      <li><a href="{{ route('home') }}" class="nav-link" data-page="">首頁</a></li>
      <li><a href="{{ route('features') }}" class="nav-link" data-page="features">功能介紹</a></li>
      <li><a href="{{ route('pricing') }}" class="nav-link" data-page="pricing">方案定價</a></li>
      <li><a href="{{ route('upload') }}" class="nav-link" data-page="upload">免費試用</a></li>
    </ul>
    <div class="navbar-actions">
      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-nav-cta">我的後台</a>
      @else
        <a href="{{ route('login') }}" class="btn-nav-login">登入</a>
        <a href="{{ route('upload') }}" class="btn btn-nav-cta">立即開始</a>
      @endauth
    </div>
    <button class="hamburger" aria-label="選單"><span></span><span></span><span></span></button>
  </div>
  <div class="mobile-menu">
    <a href="{{ route('home') }}" class="nav-link">首頁</a>
    <a href="{{ route('features') }}" class="nav-link">功能介紹</a>
    <a href="{{ route('pricing') }}" class="nav-link">方案定價</a>
    <a href="{{ route('upload') }}" class="nav-link">免費試用</a>
    <a href="{{ route('login') }}" class="nav-link">登入</a>
  </div>
</nav>
