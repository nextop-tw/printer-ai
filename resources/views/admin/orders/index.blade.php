@extends('admin.layouts.app')

@section('title', '訂單管理')
@section('page-title', '訂單管理')

@section('breadcrumb')
    <li class="breadcrumb-item active">訂單列表</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex align-items-center gap-2">
            <select name="status" class="form-control form-control-sm mr-2" style="width:150px" onchange="this.form.submit()">
                <option value="">全部狀態</option>
                @foreach(['pending'=>'待付款','paid'=>'已付款','reviewing'=>'審核中','assigned'=>'已指派','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成','cancelled'=>'取消'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control form-control-sm mr-2"
                   placeholder="搜尋訂單號" value="{{ request('search') }}" style="width:180px">
            <button type="submit" class="btn btn-sm btn-default">搜尋</button>
            @if(request('status') || request('search'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-link">清除</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>訂單編號</th>
                    <th>用戶</th>
                    <th>產品</th>
                    <th>數量</th>
                    <th>金額</th>
                    <th>狀態</th>
                    <th>建立時間</th>
                    <th style="width:60px">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><code>{{ $order->order_no }}</code></td>
                    <td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->email }}</small></td>
                    <td>{{ $order->productType->name }}</td>
                    <td>{{ number_format($order->quantity) }}</td>
                    <td>${{ number_format($order->total_price) }}</td>
                    <td>
                        @php
                            $badges = ['pending'=>'secondary','paid'=>'warning','reviewing'=>'info','assigned'=>'primary','printing'=>'primary','shipped'=>'success','completed'=>'success','cancelled'=>'danger'];
                            $labels = ['pending'=>'待付款','paid'=>'已付款','reviewing'=>'審核中','assigned'=>'已指派','printing'=>'生產中','shipped'=>'已出貨','completed'=>'完成','cancelled'=>'取消'];
                        @endphp
                        <span class="badge badge-{{ $badges[$order->status] ?? 'secondary' }}">
                            {{ $labels[$order->status] ?? $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="btn btn-sm btn-info" title="查看詳情">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">沒有符合的訂單</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
