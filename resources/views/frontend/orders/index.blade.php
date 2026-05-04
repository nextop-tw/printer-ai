<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>我的訂單 — PrinterAI</title>
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
        <span class="topbar-greeting"><strong>我的訂單</strong></span>
      </div>
      <div class="topbar-actions"><a href="{{ route('upload') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> 新增訂單</a></div>
    </div>

    <div class="widget" style="margin-bottom:1.5rem">
      <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
        <div class="tab-bar" style="border-bottom:none;margin-bottom:0">
          <button class="tab-btn active" data-status="all">全部訂單</button>
          <button class="tab-btn" data-status="assigned">待製作</button>
          <button class="tab-btn" data-status="printing">印製中</button>
          <button class="tab-btn" data-status="completed">已完成</button>
        </div>
        <div style="margin-left:auto">
          <input type="text" class="form-control" placeholder="搜尋訂單..." style="width:200px;padding:8px 12px;font-size:0.85rem" id="searchInput" />
        </div>
      </div>
    </div>

    <div class="widget">
      <table class="orders-table" style="width:100%">
        <thead>
          <tr><th>訂單編號</th><th>品項</th><th>數量</th><th>日期</th><th>狀態</th><th>金額</th></tr>
        </thead>
        <tbody id="ordersBody">
          @forelse($orders as $order)
          <tr data-status="{{ $order->status }}">
            <td><span class="mono" style="font-size:0.78rem">#{{ $order->order_no }}</span></td>
            <td style="font-weight:600;font-size:0.88rem">{{ $order->productType->name ?? '—' }}</td>
            <td style="font-size:0.88rem">{{ $order->quantity }} 份</td>
            <td style="font-size:0.82rem;color:var(--muted)">{{ $order->created_at->format('Y-m-d') }}</td>
            <td>
              @php
                $badgeMap = ['pending'=>'badge-pending','assigned'=>'badge-processing','printing'=>'badge-processing','completed'=>'badge-ready','cancelled'=>'badge-pending'];
                $labelMap = ['pending'=>'待付款','assigned'=>'待製作','printing'=>'印製中','completed'=>'已完成','cancelled'=>'已取消'];
              @endphp
              <span class="order-badge {{ $badgeMap[$order->status] ?? 'badge-pending' }}">{{ $labelMap[$order->status] ?? $order->status }}</span>
            </td>
            <td style="font-weight:600;font-family:'JetBrains Mono',monospace;font-size:0.82rem">NT${{ number_format($order->total_price) }}</td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--muted)">
            尚無訂單，<a href="{{ route('upload') }}" style="color:var(--accent)">立即上傳設計稿</a>
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>
</div>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
<script>
document.querySelectorAll('.tab-btn[data-status]').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn[data-status]').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const status = btn.dataset.status;
    document.querySelectorAll('#ordersBody tr[data-status]').forEach(row => {
      row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
  });
});
document.getElementById('searchInput')?.addEventListener('input', function() {
  const kw = this.value.toLowerCase();
  document.querySelectorAll('#ordersBody tr[data-status]').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(kw) ? '' : 'none';
  });
});
</script>
</body>
</html>
