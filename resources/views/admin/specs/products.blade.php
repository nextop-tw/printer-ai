@extends('admin.layouts.app')

@section('title', '產品類型')
@section('page-title', '產品類型管理')

@section('breadcrumb')
    <li class="breadcrumb-item">規格設定</li>
    <li class="breadcrumb-item active">產品類型</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">新增產品類型</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.specs.products.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">產品名稱</label>
                <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" placeholder="如：名片、DM" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">勾選規格維度</label>
                <div class="col-sm-8">
                    <div class="row">
                        @foreach($dimensions as $dim)
                        <div class="col-auto mr-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                       id="dim_{{ $dim->id }}" name="dimension_ids[]" value="{{ $dim->id }}">
                                <label class="custom-control-label" for="dim_{{ $dim->id }}">{{ $dim->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">新增產品</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">產品列表</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr><th>產品名稱</th><th>使用的規格維度</th><th>狀態</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>
                        @foreach($product->specDimensions as $dim)
                            <span class="badge badge-info mr-1">{{ $dim->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($product->is_active)
                            <span class="badge badge-success">啟用</span>
                        @else
                            <span class="badge badge-secondary">停用</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">尚無產品類型</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
