@extends('admin.layouts.app')

@section('title', '印刷廠管理')
@section('page-title', '印刷廠管理')

@section('breadcrumb')
    <li class="breadcrumb-item active">印刷廠列表</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.printers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> 新增印刷廠
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>廠商名稱</th>
                    <th>聯絡人</th>
                    <th>工作天數</th>
                    <th>廠商狀態</th>
                    <th>管理員控制</th>
                    <th style="width:100px">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($printers as $printer)
                <tr>
                    <td>
                        <strong>{{ $printer->name }}</strong><br>
                        <small class="text-muted">{{ $printer->email }}</small>
                    </td>
                    <td>{{ $printer->contact_name ?? '—' }}</td>
                    <td>{{ $printer->working_days }} 天</td>
                    <td>
                        @if($printer->status === 'active')
                            <span class="badge badge-success">接單中</span>
                        @else
                            <span class="badge badge-secondary">廠商暫停</span>
                        @endif
                    </td>
                    <td>
                        @if($printer->admin_suspended)
                            <span class="badge badge-danger">管理員強制暫停</span>
                        @else
                            <span class="badge badge-success">正常</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.printers.edit', $printer) }}"
                           class="btn btn-sm btn-warning" title="編輯">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.printers.suspend', $printer) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $printer->admin_suspended ? 'btn-success' : 'btn-danger' }}"
                                    title="{{ $printer->admin_suspended ? '恢復接單' : '強制暫停' }}"
                                    onclick="return confirm('確定要{{ $printer->admin_suspended ? '恢復' : '暫停' }}此印刷廠嗎？')">
                                <i class="fas {{ $printer->admin_suspended ? 'fa-check' : 'fa-ban' }}"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">尚無印刷廠</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $printers->links() }}</div>
</div>
@endsection
