@extends('admin.layouts.app')

@section('title', '基本價設定')
@section('page-title', '基本價 & 數量折扣設定')

@section('breadcrumb')
    <li class="breadcrumb-item">規格設定</li>
    <li class="breadcrumb-item active">定價設定</li>
@endsection

@section('content')
<div class="row">
    {{-- 基本價設定 --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">基本價設定</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.specs.prices.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">選擇產品</label>
                        <div class="col-sm-6">
                            <select name="product_type_id" class="form-control" id="productSelect" required>
                                <option value="">請選擇產品</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">規格組合 ID</label>
                        <div class="col-sm-6">
                            <input type="text" name="spec_option_ids_raw" class="form-control"
                                   placeholder="輸入選項 ID，用逗號分隔，如：1,3,5" required>
                            <small class="text-muted">請對照上方規格維度頁查詢各選項 ID</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">基本價（元）</label>
                        <div class="col-sm-3">
                            <input type="number" name="base_price" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">新增基本價</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">已設定的基本價</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr><th>產品</th><th>規格選項 IDs</th><th>基本價</th></tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @foreach($product->basePrices as $price)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td><code>{{ implode(', ', $price->spec_option_ids) }}</code></td>
                                <td>${{ number_format($price->base_price) }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 數量折扣 --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">數量折扣規則</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr><th>最低數量</th><th>折扣率</th></tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $d)
                        <tr>
                            <td>{{ number_format($d->min_quantity) }} 件以上</td>
                            <td>{{ $d->discount_rate * 100 }}%</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-2">尚無折扣規則</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form method="POST" action="{{ route('admin.specs.discounts.store') }}" class="form-inline">
                    @csrf
                    <input type="number" name="min_quantity" class="form-control form-control-sm mr-1"
                           placeholder="數量" min="1" style="width:80px" required>
                    <input type="number" name="discount_rate" class="form-control form-control-sm mr-1"
                           placeholder="如 0.9" min="0.01" max="1" step="0.01" style="width:80px" required>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                </form>
                <small class="text-muted d-block mt-1">折扣率：0.9 = 九折</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 基本價表單：將逗號分隔的 ID 轉換為陣列
document.querySelector('form').addEventListener('submit', function(e) {
    const raw = document.querySelector('[name="spec_option_ids_raw"]');
    if (!raw) return;
    const ids = raw.value.split(',').map(v => v.trim()).filter(Boolean);
    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'spec_option_ids[]';
        input.value = id;
        this.appendChild(input);
    });
    raw.removeAttribute('name');
});
</script>
@endpush
