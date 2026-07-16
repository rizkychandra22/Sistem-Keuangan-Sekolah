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
    .sidebar .nav-link.is-disabled {
      opacity: 0.75;
    }

    .user-panel .image img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }

    .user-panel .user-name {
      display: flex;
      flex-direction: column;
      line-height: 1.2;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="breadcrumb-item mt-2">
        <a href="#"><i class="fas fa-home"></i></a>
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
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="fas fa-th-large"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="/logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 mb-3 pb-3  d-flex">
        <a href="/teacher/home/profile" class="d-block d-flex align-items-center">
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
            <a href="/dashboard/guru" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard Guru</p>
            </a>
          </li>

          <li class="nav-header">AKADEMIK</li>
          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-school"></i>
              <p>Wali Kelas</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>Mapel & Kelas Ajar</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Siswa</p>
            </a>
          </li>

          <li class="nav-header">PEMBELAJARAN</li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-clipboard-check"></i>
              <p>Input Absensi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-history"></i>
              <p>Riwayat Absensi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-edit"></i>
              <p>Input Nilai</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Rekap Nilai</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>Rapor Siswa</p>
            </a>
          </li>

          <li class="nav-header">SISTEM</li>
          <li class="nav-item">
            <a href="#" class="nav-link is-disabled">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Tahun Ajaran Aktif</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row"></div>
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

  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
<script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
</html>
