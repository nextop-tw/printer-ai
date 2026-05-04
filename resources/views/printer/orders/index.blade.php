<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的訂單 | 印刷媒合平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark navbar-success">
        <ul class="navbar-nav">
            <li class="nav-item"><span class="nav-link font-weight-bold">🖨️ {{ $printer->name }}</span></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="POST" action="{{ route('printer.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-white">登出</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="content-wrapper p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 接單狀態控制 --}}
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    目前狀態：
                    @if($printer->admin_suspended)
                        <span class="badge badge-danger badge-lg">管理員強制暫停（請聯繫平台）</span>
                    @elseif($printer->status === 'active')
                        <span class="badge badge-success" style="font-size:.9rem;padding:.4rem .8rem">接單中</span>
                    @else
                        <span class="badge badge-secondary" style="font-size:.9rem;padding:.4rem .8rem">暫停接單</span>
                    @endif
                </div>
                @if(!$printer->admin_suspended)
                <form method="POST" action="{{ route('printer.status.update') }}">
                    @csrf @method('PATCH')
                    @if($printer->status === 'active')
                        <input type="hidden" name="status" value="suspended">
                        <button type="submit" class="btn btn-danger btn-sm">暫停接單</button>
                    @else
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="btn btn-success btn-sm">恢復接單</button>
                    @endif
                </form>
                @endif
                <form method="POST" action="{{ route('printer.status.update') }}" class="form-inline">
                    @csrf @method('PATCH')
                    <label class="mr-2">工作天數</label>
                    <input type="number" name="working_days" class="form-control form-control-sm mr-2"
                           value="{{ $printer->working_days }}" min="1" max="30" style="width:70px">
                    <button type="submit" class="btn btn-outline-primary btn-sm">更新</button>
                </form>
            </div>
        </div>

        {{-- 訂單列表 --}}
        <div class="card">
            <div class="card-header"><strong>指派給我的訂單</strong></div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>訂單編號</th>
                            <th>產品</th>
                            <th>數量</th>
                            <th>狀態</th>
                            <th>預計完成</th>
                            <th>圖檔</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><code>{{ $order->order_no }}</code></td>
                            <td>{{ $order->productType->name }}</td>
                            <td>{{ number_format($order->quantity) }}</td>
                            <td>
                                @php
                                    $labels = ['assigned'=>'已指派','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成'];
                                    $badges = ['assigned'=>'primary','printing'=>'warning','shipped'=>'info','completed'=>'success'];
                                @endphp
                                <span class="badge badge-{{ $badges[$order->status] ?? 'secondary' }}">
                                    {{ $labels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->estimated_completion_date?->format('Y-m-d') ?? '—' }}</td>
                            <td>
                                <a href="{{ route('printer.orders.file', $order) }}"
                                   class="btn btn-sm btn-secondary" title="下載圖檔">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">目前沒有指派的訂單</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $orders->links() }}</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
