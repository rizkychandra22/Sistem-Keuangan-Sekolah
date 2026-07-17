<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMR8wKMO0M2fLlPjqG7m1F5By4HR7FJztnD6B" crossorigin="anonymous">
  <link rel="stylesheet" href="/!template-admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/!template-admin/dist/css/adminlte.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini">

  @php
      $isInputOpen = Route::is('pemasukan.create', 'pemasukan.edit', 'pengeluaran.create', 'pengeluaran.edit');
      $isDanaOpen = Route::is('pemasukan.index', 'pengeluaran.index');
      $isDetailOpen = Route::is('detail.*');
      $isRekapOpen = Route::is('rekap.*');
  @endphp

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="breadcrumb-item mt-2">
            <a href="/dashboard/keuangan"><i class="fas fa-home"></i></a>
        </li>
        @if(isset($currentLink) && isset($currentTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $currentLink }}">{{ $currentTitle }}</a>
            </li>
        @endif
        @if(isset($createLink) && isset($createTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $createLink }}">{{ $createTitle }}</a>
            </li>
        @endif
        @if(isset($editLink) && isset($editTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $editLink }}">{{ $editTitle }}</a>
            </li>
        @endif
        @if(isset($detailLink) && isset($detailTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $detailLink }}">{{ $detailTitle }}</a>
            </li>
        @endif
        @if(isset($searchLink) && isset($searchTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $searchLink }}">{{ $searchTitle }}</a>
            </li>
        @endif
      </ul>
    
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <span class="fas fa-th-large"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg-3 dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="/logout" class="dropdown-item">
              <i class="fas fa-arrow-right"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <div class="user-panel mt-3 mb-3 pb-3  d-flex">
          <a href="/dashboard/keuangan/profile" class="d-block d-flex align-items-center">
              <div class="image mr-1">
                  <img src="{{ asset('images/user/' . Auth::user()->gambar) }}" class="rounded-circle sidebar-user-image" alt="User Image">
              </div>
              <div class="user-name sidebar-user-name">
                  {{ Auth::user()->name }}
              </div>
          </a>
        </div>    

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="/dashboard/keuangan" class="nav-link {{ request()->routeIs('dashboard.keuangan', 'profile.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard {{ Auth::user()->role; }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-link"></i>
                <p>Lihat Website</p>
              </a>
            </li>
            <li class="nav-item has-treeview {{ $isInputOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isInputOpen ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave nav-icon"></i>
                <p>
                  Input Dana
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isInputOpen ? 'is-open' : '' }}">
                <li class="nav-item">
                  <a href="/dashboard/keuangan/pemasukan/create" class="nav-link {{ request()->routeIs('pemasukan.create', 'pemasukan.edit') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down nav-icon"></i>
                    <p>Pemasukan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/keuangan/pengeluaran/create" class="nav-link {{ request()->routeIs('pengeluaran.create', 'pengeluaran.edit') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up nav-icon"></i>
                    <p>Pengeluaran</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ $isDanaOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isDanaOpen ? 'active' : '' }}">
                <i class="fas fa-coins nav-icon"></i>
                <p>
                  Dana Sekolah
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isDanaOpen ? 'is-open' : '' }}" id="DanaSekolah">
                <li class="nav-item">
                  <a href="/dashboard/keuangan/pemasukan" class="nav-link {{ request()->routeIs('pemasukan.index') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down nav-icon"></i>
                    <p>Pemasukan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/keuangan/pengeluaran" class="nav-link {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up nav-icon"></i>
                    <p>Pengeluaran</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ $isDetailOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isDetailOpen ? 'active' : '' }}">
                <i class="fas fa-pencil-alt nav-icon"></i>
                <p>
                  Detail Dana
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isDetailOpen ? 'is-open' : '' }}">
                <li class="nav-item">
                  <a href="/dashboard/keuangan/detail/pemasukan" class="nav-link {{ request()->routeIs('detail.pemasukan') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down nav-icon"></i>
                    <p>Transaksi Masuk</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/keuangan/detail/pengeluaran" class="nav-link {{ request()->routeIs('detail.pengeluaran') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up nav-icon"></i>
                    <p>Transaksi Keluar</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ $isRekapOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isRekapOpen ? 'active' : '' }}">
                <i class="fas fa-money-check nav-icon"></i>
                <p>
                  Laporan Keuangan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isRekapOpen ? 'is-open' : '' }}">
                <li class="nav-item">
                  <a href="/dashboard/keuangan/rekap/pemasukan" class="nav-link {{ request()->routeIs('rekap.pemasukan') ? 'active' : '' }}">
                    <i class="fas fa-arrow-down nav-icon"></i>
                    <p>Rekap Pemasukan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/keuangan/rekap/pengeluaran" class="nav-link {{ request()->routeIs('rekap.pengeluaran') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up nav-icon"></i>
                    <p>Rekap Pengeluaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/keuangan/rekap/transaksi" class="nav-link {{ request()->routeIs('rekap.transaksi') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                    <p>Rekap Transaksi</p>
                  </a>
                </li>
              </ul>
            </li>            
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
          </div>
        </div>
      </div>

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">@yield('title')</h5>
                </div>
                <div class="card-body">
                  @yield('content')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>

    <footer class="main-footer">
      <strong>Copyright &copy; {{ date ("Y") }} <a href="/dashboard/keuangan">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
    </footer>
  </div>

  @include('sweetalert::alert')

  <script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
  <script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
@stack('js')
</html>
