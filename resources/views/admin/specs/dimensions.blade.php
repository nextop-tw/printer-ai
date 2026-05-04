@extends('admin.layouts.app')

@section('title', '規格維度')
@section('page-title', '規格維度管理')

@section('breadcrumb')
    <li class="breadcrumb-item">規格設定</li>
    <li class="breadcrumb-item active">規格維度</li>
@endsection

@section('content')
{{-- 新增維度 --}}
<div class="card">
    <div class="card-header">新增規格維度</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.specs.dimensions.store') }}" class="form-inline">
            @csrf
            <input type="text" name="name" class="form-control mr-2" placeholder="維度名稱（如：尺寸）" required>
            <input type="number" name="sort_order" class="form-control mr-2" placeholder="排序" style="width:80px" value="0">
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> 新增</button>
        </form>
    </div>
</div>

{{-- 維度列表 --}}
@foreach($dimensions as $dim)
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>{{ $dim->name }}</strong>
        <span class="text-muted small">排序 {{ $dim->sort_order }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead class="thead-light">
                <tr><th>選項名稱</th><th>加價（元）</th><th>排序</th></tr>
            </thead>
            <tbody>
                @forelse($dim->options as $opt)
                <tr>
                    <td>{{ $opt->label }}</td>
                    <td>{{ $opt->price_addon > 0 ? '+$' . number_format($opt->price_addon) : '—' }}</td>
                    <td>{{ $opt->sort_order }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-muted text-center py-2">尚無選項</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3 bg-light border-top">
            <form method="POST" action="{{ route('admin.specs.options.store') }}" class="form-inline">
                @csrf
                <input type="hidden" name="spec_dimension_id" value="{{ $dim->id }}">
                <input type="text" name="label" class="form-control form-control-sm mr-2" placeholder="選項名稱" required>
                <div class="input-group input-group-sm mr-2" style="width:130px">
                    <div class="input-group-prepend"><span class="input-group-text">+$</span></div>
                    <input type="number" name="price_addon" class="form-control" placeholder="0" min="0" value="0">
                </div>
                <input type="number" name="sort_order" class="form-control form-control-sm mr-2" placeholder="排序" style="width:70px" value="0">
                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> 新增選項</button>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
