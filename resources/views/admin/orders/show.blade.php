@extends('admin.layouts.app')

@section('title', '訂單詳情')
@section('page-title', '訂單 ' . $order->order_no)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">訂單管理</a></li>
    <li class="breadcrumb-item active">{{ $order->order_no }}</li>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> 返回列表
    </a>
</div>

<div class="row">
    {{-- 左欄：訂單資訊 --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">訂單資訊</div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><th style="width:140px">訂單編號</th><td><code>{{ $order->order_no }}</code></td></tr>
                    <tr><th>用戶</th><td>{{ $order->user->name }} &lt;{{ $order->user->email }}&gt;</td></tr>
                    <tr><th>產品</th><td>{{ $order->productType->name }}</td></tr>
                    <tr><th>數量</th><td>{{ number_format($order->quantity) }}</td></tr>
                    <tr><th>金額</th><td>${{ number_format($order->total_price) }}</td></tr>
                    <tr><th>折扣率</th><td>{{ $order->discount_rate * 100 }}%</td></tr>
                    <tr><th>付款時間</th><td>{{ $order->paid_at?->format('Y-m-d H:i') ?? '—' }}</td></tr>
                    <tr><th>建立時間</th><td>{{ $order->created_at->format('Y-m-d H:i') }}</td></tr>
                </table>
            </div>
        </div>

        {{-- 圖檔分析 --}}
        @if($order->file_analysis)
        <div class="card">
            <div class="card-header">圖檔分析</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        解析度
                        @if(($order->file_analysis['dpi'] ?? 0) >= 300)
                            <span class="badge badge-success">{{ $order->file_analysis['dpi'] }} DPI ✅</span>
                        @else
                            <span class="badge badge-danger">{{ $order->file_analysis['dpi'] ?? '未知' }} DPI ⚠️</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        色彩模式
                        @if(($order->file_analysis['color_mode'] ?? '') === 'CMYK')
                            <span class="badge badge-success">CMYK ✅</span>
                        @else
                            <span class="badge badge-warning">{{ $order->file_analysis['color_mode'] ?? '未知' }} ⚠️</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        出血區域
                        @if($order->file_analysis['has_bleed'] ?? false)
                            <span class="badge badge-success">有 ✅</span>
                        @else
                            <span class="badge badge-warning">未確認 ⚠️</span>
                        @endif
                    </li>
                    @foreach($order->file_analysis['warnings'] ?? [] as $warning)
                    <li class="list-group-item text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $warning }}</li>
                    @endforeach
                </ul>
                <div class="mt-2">
                    <a href="{{ route('admin.orders.file', $order) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-download"></i> 下載圖檔
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- 右欄：操作區 --}}
    <div class="col-md-5">
        {{-- 狀態 --}}
        <div class="card">
            <div class="card-header">目前狀態</div>
            <div class="card-body">
                @php
                    $badges = ['pending'=>'secondary','paid'=>'warning','reviewing'=>'info','assigned'=>'primary','printing'=>'primary','shipped'=>'success','completed'=>'success','cancelled'=>'danger'];
                    $labels = ['pending'=>'待付款','paid'=>'已付款','reviewing'=>'審核中','assigned'=>'已指派','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成','cancelled'=>'取消'];
                @endphp
                <span class="badge badge-{{ $badges[$order->status] ?? 'secondary' }} badge-lg" style="font-size:1rem;padding:.5rem 1rem">
                    {{ $labels[$order->status] ?? $order->status }}
                </span>
                @if($order->estimated_completion_date)
                    <p class="mt-2 mb-0 text-muted">預計完成：{{ $order->estimated_completion_date->format('Y-m-d') }}</p>
                @endif
                @if($order->printer)
                    <p class="mt-1 mb-0 text-muted">指派廠商：{{ $order->printer->name }}</p>
                @endif
            </div>
        </div>

        {{-- 指派印刷廠 --}}
        @if(in_array($order->status, ['paid', 'reviewing']))
        <div class="card">
            <div class="card-header">指派印刷廠</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.assign', $order) }}">
                    @csrf
                    <div class="form-group">
                        <select name="printer_id" class="form-control" required>
                            <option value="">選擇印刷廠</option>
                            @foreach($availablePrinters as $printer)
                                <option value="{{ $printer->id }}">
                                    {{ $printer->name }}（{{ $printer->working_days }} 工作天）
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fab fa-line"></i> 指派並發 LINE 通知
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- 更新狀態 --}}
        @if(!in_array($order->status, ['pending', 'completed', 'cancelled']))
        <div class="card">
            <div class="card-header">更新狀態</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="input-group">
                        <select name="status" class="form-control">
                            @foreach(['reviewing'=>'審核中','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成','cancelled'=>'取消'] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning">更新</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
