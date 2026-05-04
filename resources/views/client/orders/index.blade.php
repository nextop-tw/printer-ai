<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的訂單 | 印刷媒合平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-light bg-white border-bottom px-4">
    <span class="navbar-brand">🖨️ 印刷媒合平台</span>
    <div class="d-flex align-items-center gap-3">
        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" class="rounded-circle" width="32" height="32" alt="avatar">
        @endif
        <span class="text-muted small">{{ auth()->user()->name }}</span>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-secondary">登出</a>
    </div>
</nav>

<div class="container py-4" style="max-width:800px">
    <h4 class="mb-4">我的訂單</h4>

    @forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1">
                        <code>{{ $order->order_no }}</code>
                        &nbsp;
                        @php
                            $badges = ['pending'=>'secondary','paid'=>'warning','reviewing'=>'info','assigned'=>'primary','printing'=>'primary','shipped'=>'info','completed'=>'success','cancelled'=>'danger'];
                            $labels = ['pending'=>'待付款','paid'=>'已付款','reviewing'=>'審核中','assigned'=>'已指派','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成','cancelled'=>'取消'];
                        @endphp
                        <span class="badge bg-{{ $badges[$order->status] ?? 'secondary' }}">
                            {{ $labels[$order->status] ?? $order->status }}
                        </span>
                    </p>
                    <p class="mb-1 text-muted small">
                        {{ $order->productType->name }} &times;{{ number_format($order->quantity) }}
                        &nbsp;｜&nbsp;
                        ${{ number_format($order->total_price) }}
                    </p>
                    @if($order->estimated_completion_date)
                    <p class="mb-0 text-muted small">
                        預計完成：{{ $order->estimated_completion_date->format('Y-m-d') }}
                    </p>
                    @endif
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">{{ $order->created_at->format('Y-m-d') }}</small>
                    @if($order->status === 'pending')
                        <a href="{{ route('orders.show', $order->order_no) }}"
                           class="btn btn-sm btn-primary mt-1">前往付款</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-5">
        <p>還沒有訂單</p>
        <a href="{{ route('order.create') }}" class="btn btn-primary">立即下單</a>
    </div>
    @endforelse

    {{ $orders->links() }}
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
