<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '管理後台') | 印刷媒合平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .content-wrapper { background-color: #f4f6f9; }
        .card-header { font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Topbar --}}
    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">{{ auth('admin')->user()->name }}</span>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">登出</button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.orders.index') }}" class="brand-link">
            <span class="brand-text font-weight-bold">🖨️ 印刷媒合平台</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>訂單管理</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.printers.index') }}"
                           class="nav-link {{ request()->routeIs('admin.printers.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>印刷廠管理</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ request()->routeIs('admin.specs.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.specs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>規格設定 <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.specs.dimensions') }}"
                                   class="nav-link {{ request()->routeIs('admin.specs.dimensions') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>規格維度</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.specs.products') }}"
                                   class="nav-link {{ request()->routeIs('admin.specs.products') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>產品類型</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.specs.prices') }}"
                                   class="nav-link {{ request()->routeIs('admin.specs.prices') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>基本價設定</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    {{-- 主內容 --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1 class="m-0">@yield('page-title')</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">首頁</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="flash-msg">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" id="flash-msg">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <footer class="main-footer text-center">
        <strong>印刷媒合平台</strong> 管理後台
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    setTimeout(() => { document.getElementById('flash-msg')?.remove(); }, 3000);
</script>
@stack('scripts')
</body>
</html>
