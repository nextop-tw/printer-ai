<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>總覽 — PrinterAI</title>
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
        <span class="topbar-greeting">您好，<strong>{{ Auth::user()->name }}</strong>——以下是您的印刷概覽</span>
      </div>
      <div class="topbar-actions">
        <a href="{{ route('upload') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> 新增訂單</a>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
      <div class="stat-card">
        <div class="stat-card-top"><div class="stat-card-icon icon-orange"><i class="bi bi-box-seam"></i></div><span class="stat-card-delta delta-up">累計</span></div>
        <div class="stat-card-value">{{ $orderCount ?? 0 }}</div><div class="stat-card-label">總訂單數</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top"><div class="stat-card-icon icon-blue"><i class="bi bi-arrow-clockwise"></i></div><span class="stat-card-delta delta-up">進行中</span></div>
        <div class="stat-card-value">{{ $processingCount ?? 0 }}</div><div class="stat-card-label">製作中</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top"><div class="stat-card-icon icon-green"><i class="bi bi-check-circle"></i></div></div>
        <div class="stat-card-value">{{ $completedCount ?? 0 }}</div><div class="stat-card-label">已配送完成</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-top"><div class="stat-card-icon icon-gold"><i class="bi bi-currency-dollar"></i></div></div>
        <div class="stat-card-value">NT${{ number_format($totalSpent ?? 0) }}</div><div class="stat-card-label">累計消費</div>
      </div>
    </div>

    <!-- Grid -->
    <div class="dashboard-grid">
      <div class="widget">
        <div class="widget-header">
          <span class="widget-title">最近訂單</span>
          <a href="{{ route('orders.index') }}" class="widget-link">查看全部 <i class="bi bi-arrow-right"></i></a>
        </div>
        <table class="orders-table">
          <thead>
            <tr><th>訂單編號</th><th>品項</th><th>數量</th><th>狀態</th><th>金額</th></tr>
          </thead>
          <tbody>
            @forelse($recentOrders ?? [] as $order)
            <tr>
              <td><span class="mono" style="font-size:0.78rem">#{{ $order->order_no }}</span></td>
              <td>{{ $order->productType->name ?? '—' }}</td>
              <td>{{ $order->quantity }}</td>
              <td><span class="order-badge badge-{{ $order->status === 'completed' ? 'ready' : 'processing' }}">{{ $order->status }}</span></td>
              <td>NT${{ number_format($order->total_price) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--muted)">尚無訂單，<a href="{{ route('upload') }}" style="color:var(--accent)">立即下單</a></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div>
        <div class="widget" style="margin-bottom:1.5rem">
          <div class="widget-header"><span class="widget-title">快捷操作</span></div>
          <div style="display:flex;flex-direction:column;gap:0.75rem">
            <a href="{{ route('upload') }}" class="btn btn-primary" style="justify-content:flex-start"><i class="bi bi-upload"></i> 上傳新設計稿</a>
            <a href="{{ route('detect') }}" class="btn btn-outline" style="justify-content:flex-start"><i class="bi bi-search"></i> 分析檔案</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline" style="justify-content:flex-start"><i class="bi bi-arrow-repeat"></i> 查看所有訂單</a>
          </div>
        </div>
        <div class="widget">
          <div class="widget-header"><span class="widget-title">帳號資訊</span></div>
          <div class="activity-list">
            <div class="activity-item">
              <div class="activity-dot"></div>
              <div>
                <div class="activity-text">{{ Auth::user()->name }}</div>
                <div class="activity-time">{{ Auth::user()->email }}</div>
              </div>
            </div>
            <div class="activity-item">
              <div class="activity-dot" style="background:var(--gold)"></div>
              <div>
                <div class="activity-text">加入時間</div>
                <div class="activity-time">{{ Auth::user()->created_at->format('Y 年 m 月') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>
