<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/!template-admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/!template-admin/dist/css/adminlte.min.css">
  <link rel="manifest" href="/manifest.json">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

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
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
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

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="fas fa-th-large"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-3 dropdown-menu-right">
          <div class="dropdown-divider"></div>
            <a href="" class="dropdown-item">
              <i class="fas fa-user"></i> Tentang
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
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
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

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/dashboard/admin" class="nav-link active">
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
          <li class="nav-item menu-close">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Data Website
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-solid fa-trophy nav-icon"></i>
                  <p>Prestasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date ("Y") }} <a href="/dashboard/admin">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
</html>
