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
  {{-- jQuery --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />

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
            <a href="/dashboard/operator"><i class="fas fa-home"></i></a>
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
        @if(isset($searchLink) && isset($searchTitle))
            <li class="breadcrumb-item mt-2">
                <a href="{{ $searchLink }}">{{ $searchTitle }}</a>
            </li>
        @endif
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <a class="nav-link" href="{{ url('/dashboard/operator/notifikasi') }}">
          <span class="fas fa-bell"></span>
          @if (isset($unreadCount) && $unreadCount > 0)
            <span class="badge badge-danger navbar-badge">{{ $unreadCount }}</span>
          @endif
        </a>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <span class="fas fa-th-large"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg-3 dropdown-menu-right">
            <div class="dropdown-divider"></div>
              <a href="/dashboard/operator/contact-sekolah" class="dropdown-item">
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
        <div class="user-panel mt-3 mb-3 pb-3 d-flex">
          <a href="/dashboard/operator/profile" class="d-block d-flex align-items-center">
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
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
            <li class="nav-item">
              <a href="/dashboard/operator" class="nav-link active">
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
            <li class="nav-item has-treeview" id="dataWebsiteMenu">
              <a href="#" class="nav-link active" data-toggle="collapse" data-target="#DataWebsite">
                <i class="nav-icon fas fa-globe"></i>
                <p>Data Website<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview collapse" id="DataWebsite">
                <li class="nav-item has-treeview" id="galleryMenu">
                  <a href="#" class="nav-link active" data-toggle="collapse" data-target="#GallerySubMenu">
                    <i class="fas fa-image nav-icon"></i>
                    <p>Gallery<i class="right fas fa-angle-left"></i></p>
                  </a>
                  <ul class="nav nav-treeview collapse" id="GallerySubMenu">
                    <li class="nav-item">
                      <a href="/dashboard/operator/gallery-event" class="nav-link" id="galleryEvent">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Event</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/dashboard/operator/gallery-lomba" class="nav-link" id="galleryLomba">
                        <i class="fas fa-medal nav-icon"></i>
                        <p>Lomba</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/dashboard/operator/gallery-pariwisata" class="nav-link" id="galleryPariwisata">
                        <i class="fas fa-bus nav-icon"></i>
                        <p>Study Tour</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/dashboard/operator/gallery-perpisahan" class="nav-link" id="galleryPerpisahan">
                        <i class="fa-sharp fas fa-graduation-cap nav-icon"></i>
                        <p>Perpisahan</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/operator/prestasi" class="nav-link" id="prestasiMenu">
                    <i class="fas fa-solid fa-trophy nav-icon"></i>
                    <p>Prestasi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/dashboard/operator/guru" class="nav-link" id="guruMenu">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Guru</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="/dashboard/operator/program-kerja" class="nav-link" id="programKerjaMenu">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Program Kerja</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/dashboard/operator/berita-sekolah" class="nav-link" id="beritaSekolahMenu">
                <i class="fas fa-newspaper nav-icon"></i>
                <p>Berita Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/dashboard/operator/sambutan" class="nav-link" id="sambutanMenu">
                <i class="fas fa-user nav-icon"></i>
                <p>Sambutan Kepsek</p>
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
      <strong>Copyright &copy; {{ date ("Y") }} <a href="/dashboard/operator">SD Negeri Caringin Ngumbang</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  {{-- Show active untuk navigasi --}}
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const currentPath = window.location.pathname;
  
      // Function to open and highlight the menu
      function openMenu(menuId, subMenuId) {
        document.getElementById(menuId).classList.add("menu-open");
        if (subMenuId) {
          document.getElementById(subMenuId).classList.add("show");
        }
      }
  
      // Check for Data Website and Gallery menus
      if (currentPath.startsWith("/dashboard/operator/gallery")) {
        openMenu("dataWebsiteMenu", "DataWebsite");
        openMenu("galleryMenu", "GallerySubMenu");
  
        if (currentPath === "/dashboard/operator/gallery-event") {
          document.getElementById("galleryEvent").classList.add("active");
        } else if (currentPath === "/dashboard/operator/gallery-lomba") {
          document.getElementById("galleryLomba").classList.add("active");
        } else if (currentPath === "/dashboard/operator/gallery-pariwisata") {
          document.getElementById("galleryPariwisata").classList.add("active");
        } else if (currentPath === "/dashboard/operator/gallery-perpisahan") {
          document.getElementById("galleryPerpisahan").classList.add("active");
        }
      } else if (currentPath.startsWith("/dashboard/operator/prestasi")) {
        openMenu("dataWebsiteMenu", "DataWebsite");
        document.getElementById("prestasiMenu").classList.add("active");
      } else if (currentPath.startsWith("/dashboard/operator/guru")) {
        openMenu("dataWebsiteMenu", "DataWebsite");
        document.getElementById("guruMenu").classList.add("active");
      }
  
      // Add 'active' class to the current nav link
      document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('active');
        }
      });
    });
  </script>
  
  <!-- jQuery -->
  <script src="/!template-admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/!template-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/!template-admin/dist/js/adminlte.min.js"></script>
</body>
@stack('js')
</html>
