<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/!template-admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/!template-admin/dist/css/adminlte.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini">

  @php
    $isDataUser = Route::is('dataUser.*');
    $isGuruMenu = Route::is('guru.*');
    $isSiswaMenu = Route::is('siswa.*');

    $isKurikulumMenu = Route::is('kurikulum.*');
    $isMapelMenu = Route::is('mapel.*');
    $isKelasMenu = Route::is('kelas.*');
    $isTahunAjaranMenu = Route::is('tahun-ajaran.*');
    $isRombelMenu = Route::is('rombel.*');
    $isSiswaRombelMenu = Route::is('siswa-rombel.*');
    $isGuruMapelMenu = Route::is('guru-mapel.*');

    $isPenggunaOpen = $isDataUser || $isGuruMenu || $isSiswaMenu;
    $isPeriodeAkademikOpen = $isKurikulumMenu || $isTahunAjaranMenu;
    $isAkademikOpen = $isKurikulumMenu || $isMapelMenu || $isKelasMenu || $isTahunAjaranMenu || $isRombelMenu || $isSiswaRombelMenu || $isGuruMapelMenu;

    $menuLinks = [
        'dataUser' => Route::has('dataUser.index') ? route('dataUser.index') : '#',
        'guru' => Route::has('guru.index') ? route('guru.index') : '#',
        'siswa' => Route::has('siswa.index') ? route('siswa.index') : '#',
        'kurikulum' => Route::has('kurikulum.index') ? route('kurikulum.index') : '#',
        'mapel' => Route::has('mapel.index') ? route('mapel.index') : '#',
        'kelas' => Route::has('kelas.index') ? route('kelas.index') : '#',
        'tahunAjaran' => Route::has('tahun-ajaran.index') ? route('tahun-ajaran.index') : '#',
        'rombel' => Route::has('rombel.index') ? route('rombel.index') : '#',
        'siswaRombel' => Route::has('siswa-rombel.index') ? route('siswa-rombel.index') : '#',
        'guruMapel' => Route::has('guru-mapel.index') ? route('guru-mapel.index') : '#',
    ];
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
            <li class="nav-item has-treeview {{ $isPenggunaOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isPenggunaOpen ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Manajemen Pengguna
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isPenggunaOpen ? 'is-open' : '' }}">
                <li class="nav-item">
                  <a href="{{ $menuLinks['dataUser'] }}" class="nav-link {{ $isDataUser ? 'active' : '' }} {{ Route::has('dataUser.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-solid fa-users nav-icon"></i>
                    <p>Akun User</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['guru'] }}" class="nav-link {{ $isGuruMenu ? 'active' : '' }} {{ Route::has('guru.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Guru</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['siswa'] }}" class="nav-link {{ $isSiswaMenu ? 'active' : '' }} {{ Route::has('siswa.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <p>Siswa</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ $isAkademikOpen ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isAkademikOpen ? 'active' : '' }}">
                <i class="nav-icon fas fa-school"></i>
                <p>
                  Manajemen Akademik
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview {{ $isAkademikOpen ? 'is-open' : '' }}">
                <li class="nav-item has-treeview {{ $isPeriodeAkademikOpen ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ $isPeriodeAkademikOpen ? 'active' : '' }}">
                    <i class="fas fa-calendar-week nav-icon"></i>
                    <p>
                      Periode Akademik
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview {{ $isPeriodeAkademikOpen ? 'is-open' : '' }}">
                    <li class="nav-item">
                      <a href="{{ $menuLinks['kurikulum'] }}" class="nav-link {{ $isKurikulumMenu ? 'active' : '' }} {{ Route::has('kurikulum.index') ? '' : 'is-disabled' }}">
                        <i class="fas fa-book-open nav-icon"></i>
                        <p>Kurikulum</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ $menuLinks['tahunAjaran'] }}" class="nav-link {{ $isTahunAjaranMenu ? 'active' : '' }} {{ Route::has('tahun-ajaran.index') ? '' : 'is-disabled' }}">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Tahun Ajaran</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['kelas'] }}" class="nav-link {{ $isKelasMenu ? 'active' : '' }} {{ Route::has('kelas.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-layer-group nav-icon"></i>
                    <p>Kelas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['mapel'] }}" class="nav-link {{ $isMapelMenu ? 'active' : '' }} {{ Route::has('mapel.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-book nav-icon"></i>
                    <p>Mapel</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['rombel'] }}" class="nav-link {{ $isRombelMenu ? 'active' : '' }} {{ Route::has('rombel.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-door-open nav-icon"></i>
                    <p>Rombel</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['siswaRombel'] }}" class="nav-link {{ $isSiswaRombelMenu ? 'active' : '' }} {{ Route::has('siswa-rombel.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-people-arrows nav-icon"></i>
                    <p>Siswa Rombel</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ $menuLinks['guruMapel'] }}" class="nav-link {{ $isGuruMapelMenu ? 'active' : '' }} {{ Route::has('guru-mapel.index') ? '' : 'is-disabled' }}">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Guru Mapel</p>
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
      <strong>Copyright &copy; {{ date ("Y") }} <a href="/dashboard/admin">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
    </footer>
  </div>

  <script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
  <script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
@stack('js')
</html>
