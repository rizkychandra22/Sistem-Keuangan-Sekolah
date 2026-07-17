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

  <style>
    .nav-item.active > a.nav-link {
      color: #0088ff; 
    }

    .nav-item.active .nav-treeview {
      display: block;
    }
  </style>

  <style>
    .user-panel .image img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .user-panel .user-name {
        display: flex;
        flex-direction: column;
        white-space: wrap; 
    }
  </style>  
</head>
<body class="hold-transition sidebar-mini">

  @php
    $isDataUser = Route::is('dataUser.*');
    $isGuruMenu = Route::is('guru.*');
    $isMasterDataOpen = $isDataUser || $isGuruMenu;
  @endphp

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="breadcrumb-item mt-2">
          <a href="/dashboard/admin"><i class="fas fa-home"></i></a>
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
              <a href="" class="dropdown-item">
                <i class="fas fa-info-circle"></i> Informasi
              </a>
            <div class="dropdown-divider"></div>
              <a href="" class="dropdown-item">
                <i class="fas fa-phone"></i> Kontak
              </a>
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
          <a href="/dashboard/admin/profile" class="d-block d-flex align-items-center">
              <div class="image mr-1">
                  <img src="{{ asset('images/user/' . Auth::user()->gambar) }}" class="rounded-circle" alt="User Image" style="width: 50px; height: 50px;">
              </div>
              <div class="user-name" style="flex: 1; white-space: wrap;">
                  {{ Auth::user()->name }}
              </div>
          </a>
        </div> 

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ route('dashboard.admin') }}" class="nav-link {{ request()->routeIs('dashboard.admin', 'profile.*') ? 'active' : '' }}">
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
            <li class="nav-item has-treeview {{ $isMasterDataOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isMasterDataOpen ? 'active' : '' }}">
                <i class="nav-icon fas fa-globe"></i>
                <p>
                  Master Data
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="{{ $isMasterDataOpen ? 'display: block;' : '' }}">
                <li class="nav-item">
                  <a href="{{ route('dataUser.index') }}" class="nav-link {{ Route::is('dataUser.*') ? 'active' : '' }}">
                    <i class="fas fa-solid fa-users nav-icon"></i>
                    <p>Akun User</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('guru.index') }}" class="nav-link {{ Route::is('guru.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Guru</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                    <p>Pendaftaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-newspaper nav-icon"></i>
                    <p>Info Pendaftaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-newspaper nav-icon"></i>
                    <p>Siswa Diterima</p>
              </a>
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
      <strong>Copyright &copy; {{ date ("Y") }} <a href="/dashboard/admin">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
    </footer>
  </div>

  <script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
  <script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
@stack('js')
</html>
