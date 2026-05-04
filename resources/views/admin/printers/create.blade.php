@extends('admin.layouts.app')

@section('title', '新增印刷廠')
@section('page-title', '新增印刷廠')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.printers.index') }}">印刷廠管理</a></li>
    <li class="breadcrumb-item active">新增</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.printers.store') }}">
            @csrf
            @include('admin.printers._form', ['printer' => null])
        </form>
    </div>
</div>
@endsection
