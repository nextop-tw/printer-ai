<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon" style="width:28px;height:28px;font-size:0.85rem"><i class="bi bi-printer-fill"></i></div>PrinterAI
  </div>
  <nav class="sidebar-nav">
    <div class="sidebar-section">主選單</div>
    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2"></i> 總覽
    </a>
    <a href="{{ route('upload') }}" class="sidebar-link {{ request()->routeIs('upload') ? 'active' : '' }}">
      <i class="bi bi-cloud-upload"></i> 新增訂單
    </a>
    <a href="{{ route('orders.index') }}" class="sidebar-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
      <i class="bi bi-box-seam"></i> 我的訂單
    </a>
    <a href="{{ route('detect') }}" class="sidebar-link {{ request()->routeIs('detect') ? 'active' : '' }}">
      <i class="bi bi-search"></i> 檔案分析
    </a>
    <div class="sidebar-section">帳號設定</div>
    <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
      <i class="bi bi-person"></i> 個人資料
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="sidebar-link" style="width:100%;text-align:left;background:none;border:none;color:rgba(255,255,255,0.58)">
        <i class="bi bi-box-arrow-left"></i> 登出
      </button>
    </form>
  </nav>
  <div class="sidebar-user">
    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
    <div>
      <div class="user-name">{{ Auth::user()->name }}</div>
      <div class="user-role">{{ Auth::user()->email }}</div>
    </div>
  </div>
</aside>
