<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SD Negeri Caringin Ngumbang</title>
    <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">
    <!-- font icons -->
    <link rel="stylesheet" href="/!template-blog/assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="/!template-blog/assets/css/leadmark.css">
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .search-form {
            display: none;
            position: absolute;
            top: 50px;
            right: 10px;
            width: 200px;
            background: #ffffffaa; /* Latar belakang form */
            padding: 10px;
            border-radius: 5px;
        }
        .search-form.active {
            display: block;
        }
        .search-form input {
            color: #f44d00; /* Ubah warna teks menjadi putih */
        }
        .search-form input::placeholder {
            color: #f44d00; /* Ubah warna placeholder menjadi putih */
        }
        .search-form button {
            background: none;
            border: none;
            color: #f44d00; /* Ubah warna ikon menjadi putih */
            padding: 0;
            margin-left: 10px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    <!-- page Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto"> 
                    <li class="nav-item">
                        <a class="nav-link" href="#visimisi">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sejarah">Sejarah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#galerry">Galerry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prestasi">Prestasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#guru">Guru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/informasi-sekolah">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item position-relative">
                        <a href="#" class="ml-6 nav-link btn btn-primary btn-sm rounded" id="search-button">
                            <i class="fas fa-search"></i> Pencarian
                        </a>
                        <form action="{{ route('search') }}" class="search-form" id="search-form">
                            <div class="input-group">
                                <input class="form-control" type="search" name="search" placeholder="Cari..." aria-label="Search">
                                <div class="input-group-append">
                                    <button type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->

    <!-- Page Header -->
    <header class="header">
        <div class="overlay">
            {{-- Error ketika form tidak lengkap --}}
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Form Tidak Lengkap!',
                            text: "Pastikan semua field terisi dengan benar.",
                            icon: 'error',
                            confirmButtonColor: '#d33', // Tombol merah
                            confirmButtonText: 'Tutup'
                        });
                    });
                </script>
            @endif
            {{-- Alert success kirim pesan --}}
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: "{{ session('success') }}",
                            icon: 'success',
                            confirmButtonColor: '#28a745', // Tombol hijau
                            confirmButtonText: 'Oke'
                        });
                    });
                </script>
            @endif
            <h1 class="subtitle">Selamat Datang di</h1>
            <h1 class="title">SD Negeri Caringin Ngumbang</h1>
        </div>  
        <div class="shape">
            <svg viewBox="0 0 1500 200">
                <path d="m 0,240 h 1500.4828 v -71.92164 c 0,0 -286.2763,-81.79324 -743.19024,-81.79324 C 300.37862,86.28512 0,168.07836 0,168.07836 Z"/>
            </svg>
        </div>  
        <div class="mouse-icon"><div class="wheel"></div></div>
    </header>
    <!-- End Of Page Header -->

    <!-- VisiMisi Section -->
    <section id="visimisi" class="section pt-3">
        <div class="container">
            <h6 class="section-title text-center">"Visi & Misi,,</h6>
            <h6 class="section-subtitle text-center mb-5 pb-3">SD Negeri Caringin Ngumbang</h6>
            <div class="card mb-4 mb-md-0">
                <div class="card-body">
                    <h5 class="card-title mt-8">"Visi,,<h5>
                    <hr><p class="mb-2"><b>"TERCIPTANYA PESERTA DIDIK YANG BERIMAN, BERTAQWA, CERDAS DAN UNGGUL SERTA MEMILIKI KARAKTER PROFIL PELAJAR PANCASILA."</b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <h5 class="card-title mt-8">"Misi,,<h5>
                            <hr><small class="text-primary font-weight-bold">01</small>
                                <p class="mb-0">Membangun lingkungan kegiatan sekolah yang membentuk peserta didik memiliki akhlak mudia melalui rutinitas keagamaan.</p><br>
                            <hr><small class="text-primary font-weight-bold">02</small>
                                <p class="mb-0">Mengoptimalkan kegiatan pembelajaran dengan pendekatan interaktif dan menyenangkan.</p><br>
                            <hr><small class="text-primary font-weight-bold">03</small>
                                <p class="mb-0">Mengembangkan hasil karya yang dimiliki siswa untuk membina kreativitas siswa.</p><br>
                            <hr><small class="text-primary font-weight-bold">04</small>
                                <p class="mb-0">Menggiatkan program ekstrakulikuler untuk menggali bakat/minat yang dimiliki siswa.</p><br>
                            <hr><small class="text-primary font-weight-bold">05</small>
                                <p class="mb-0">Meningkatkan prestasi siswa dalam perlombaan akademik maupun non akademik.</p><br>
                            <hr><small class="text-primary font-weight-bold">06</small>
                                <p class="mb-0">Menanamkan dan menciptakan kegiatan 7S, yaitu <b>Senyum, Salam, Sapa, Sopan, Santun, Semangat, dan Sepenuh hati</b> pada seluruh warga sekolah.</p><br>
                            <hr><small class="text-primary font-weight-bold">07</small>
                                <p class="mb-0">Menumbuhkan sikap menjiwai, mencintai, dan melestarikan nilai nilai <b>Pancasila</b></p><br>
                            <hr><small class="text-primary font-weight-bold">08</small>
                                <p class="mb-0">Meningkatkan sikap disiplin bagi seluruh warga sekolah</p><br>
                        </div>
                    </div>
                </div>                     
            </div>
        </div>
    </section>
    <!-- End OF VisiMisi Section -->

    <!-- Sejarah Section -->
    <section class="section" id="sejarah">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 pr-md-5 mb-4 mb-md-0">
                    <h6 class="section-title mb-0">"Sejarah,,</h6>
                    <h6 class="section-subtitle mb-4">SD Negeri Caringin Ngumbang</h6>
                    <p>SD Negeri Caringin Ngumbang berdiri sejak tahun 1 Juli 1978, merupakan salah satu SD Negeri yang berada Di Kelurahan Benteng, Kecamatan Warudoyong , menempati tanah seluas 1.708 m², yang teletak di jalan Caringin Ngumbang No 30.</p>
                    <p>Kondisi masyarakat lingkungan sekolah sebagai masyarakat yang relatif memiliki wawasan yang memadai. Sebagian besar masyarakat bermata pencaharian  wirausaha, tani dan sebagian pedagang, dan Aparatur Sipil Negera (ASN).</p>
                    <img src="!template-blog/assets/imgs/sejarah2.jpg" alt="" class="w-100 mt-3 shadow-sm">
                </div>
                <div class="col-md-6 pl-md-5">
                    <div class="row">
                        <div class="col-6">
                            <img src="!template-blog/assets/imgs/sejarah3.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                        <div class="col-6">
                            <img src="!template-blog/assets/imgs/sejarah1.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                        <div class="col-12 mt-4">
                            <p>Dengan demikian kondisi sosial Orang Tua siswa rata-rata menengah kebawah, namun tingkat kepedulian cukup. Kondisi Ekonomi yang demikian itu menimbulkan dampak bagi perkembangan pendidikan di SD Negeri caringin Ngumbang. Penyediaan sarana prasarana mendukung untuk kegiatan pembelajaran.<br></p>
                            <p>Sekolah meyakini bahwa lingkungan belajar yang aman, nyaman, dan kondusif dapat mendukung berkembangnya pengetahuan, mengasah keterampilan, serta membentuk sikap belajar yang baik dari siswa. Lingkungan Sekolah dirancang sesuai dengan tujuan pendidikan yang dapat dimanfaatkan siswa sebagai sumber belajar. Pendampingan aktif dari guru-guru dilakukan saat siswa berinteraksi untuk memastikan proses sosialisasi siswa berjalan sesuai yang diharapkan.</p>
                            <p>SD Negeri Caringin Ngumbang meyakini bahwa literasi merupakan kebutuhan dasar dalam belajar dan berkomunikasi. Keterampilan ini akan berkembang maksimal apabila siswa berada dalam lingkungan belajar yang literat (literate environment). Untuk mewujudkan hal ini, sekolah memperkaya lingkungannya dengan berbagai perangkat literasi yang dapat ditemukan siswa di dalam maupun di luar kelas. Lingkungan sekolah memiliki beragam permainan tradisional, sarana olah raga dan tanaman mulai dari tanaman buah, hias, dan apotek hidup yang dapat dimanfaatkan sebagai sumber belajar siswa.</p>
                        </div>
                    </div>
                </div>
            </div>              
        </div>
    </section>
    <!-- End OF Sejarah Section -->

    <!-- Galerry Section -->
    <section id="galerry" class="section portfolio-section">
        <div class="container">
            <h6 class="section-title text-center">"Gallery,,</h6>
            <h6 class="section-subtitle mb-5 text-center">Album kegiatan dan aktivitas sekolah</h6>
            <div class="filters">
                <a href="#" data-filter=".event" name="event" class="active">
                    Event
                </a>
                <a href="#" data-filter=".contest" name="contest">
                    Lomba
                </a>
                <a href="#" data-filter=".tour">
                    Tour
                </a>
                <a href="#" data-filter=".seeyou" name="seeyou">
                    Perpisahan
                </a>
            </div>
            <div class="portfolio-container"> 
                @foreach ($gallery_events as $gallery_event)
                    <div class="col-md-6 col-lg-4 event">
                        <div class="portfolio-item">
                            <img src="{{ asset('images/gallery/event/'.$gallery_event->gambar) }}" class="img-fluid" alt="">
                            <div class="content-holder">
                                <a class="img-popup" href="{{ asset('images/gallery/event/'.$gallery_event->gambar) }}"></a>
                                <div class="text-holder">
                                    <h6 class="title">{{ $gallery_event->title }}</h6>
                                    <p class="subtitle">{{ $gallery_event->subtitle }}</p>
                                </div>
                            </div>   
                        </div>             
                    </div>
                @endforeach
                @foreach ($gallery_lombas as $gallery_lomba)
                    <div class="col-md-6 col-lg-4 contest">
                        <div class="portfolio-item">
                            <img src="{{ asset('images/gallery/lomba/'.$gallery_lomba->gambar) }}" class="img-fluid" alt="Download free bootstrap 4 admin dashboard, free boootstrap 4 templates">
                            <div class="content-holder">
                                <a class="img-popup" href="{{ asset('images/gallery/lomba/'.$gallery_lomba->gambar) }}"></a>
                                <div class="text-holder">
                                    <h6 class="title">{{ $gallery_lomba->title }}</h6>
                                    <p class="subtitle">{{ $gallery_lomba->subtitle }}</p>
                                </div>
                            </div> 
                        </div>                         
                    </div>
                @endforeach
                @foreach ($gallery_pariwisatas as $gallery_pariwisata)
                    <div class="col-md-6 col-lg-4 tour">
                        <div class="portfolio-item">
                            <img src="{{ asset('images/gallery/studytour/'.$gallery_pariwisata->gambar) }}" class="img-fluid" alt="Download free bootstrap 4 admin dashboard, free boootstrap 4 templates">                         
                            <div class="content-holder">
                                <a class="img-popup" href="{{ asset('images/gallery/studytour/'.$gallery_pariwisata->gambar) }}"></a>
                                <div class="text-holder">
                                    <h6 class="title">{{ $gallery_pariwisata->title }}</h6>
                                    <p class="subtitle">{{ $gallery_pariwisata->subtitle }}</p>
                                </div>
                            </div>    
                        </div>              
                    </div> 
                @endforeach
                @foreach ($gallery_perpisahans as $gallery_perpisahan)
                    <div class="col-md-6 col-lg-4 seeyou">
                        <div class="portfolio-item">
                            <img src="{{ asset('images/gallery/perpisahan/'.$gallery_perpisahan->gambar) }}" class="img-fluid" alt="Download free bootstrap 4 admin dashboard, free boootstrap 4 templates">
                            <div class="content-holder">
                                <a class="img-popup" href="{{ asset('images/gallery/perpisahan/'.$gallery_perpisahan->gambar) }}"></a>
                                <div class="text-holder">
                                    <h6 class="title">{{ $gallery_perpisahan->title }}</h6>
                                    <p class="subtitle">{{ $gallery_perpisahan->subtitle }}</p>
                                </div>
                            </div>
                        </div>                                                     
                    </div>
                @endforeach
            </div>   
        </div>            
    </section>
    <!-- End of Galerry section -->

    <!-- Prestasi Section -->
    <section class="section" id="prestasi">
        <div class="container">
            <h6 class="section-title mb-0 text-center">"Prestasi,,</h6>
            <h6 class="section-subtitle mb-5 text-center">Siswa & Siswi berprestasi SD Negeri Caringin Ngumbang</h6>
            <div class="row">
                @foreach ($prestasis as $prestasi)
                    <div class="col-md-4">
                        <div class="card border-0 mb-4">
                            <img src="{{ asset('images/prestasi/'.$prestasi->gambar) }}" alt="" class="card-img-top w-100">
                            <div class="card-body">                    
                                <h6 class="card-title">{{ $prestasi->judul }}</h6>
                                <p>{{ $prestasi->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End of Prestasi Section -->

    <!-- Guru Section -->
    <section class="section" id="guru">
        <div class="container">
            <h6 class="section-title text-center mb-0">"Guru,,</h6>
            <h6 class="section-subtitle mb-5 text-center">Daftar Guru SD Negeri Caringin Ngumbang</h6>
            <div class="row">
                @foreach ($gurus as $guru)
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="media align-items-center mb-3">
                                    <img class="mr-3 guru-img" src="{{ asset('images/guru/'.$guru->gambar) }}" alt="">
                                    <div class="media-body">
                                        <h6 class="mt-1 mb-0">{{ $guru->nama }}</h6>
                                        <small class="text-muted mb-0">{{ $guru->jabatan }}</small>     
                                    </div>
                                </div>
                                <p class="mb-0">{{ $guru->motivasi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End of Guru Section -->

    <!-- Contact Section -->
    <section id="contact" class="section has-img-bg pb-0">
        <div class="container">
            <h4 class="mb-3">"Maps Lokasi Sekolah,,</h4>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6904457340574!2d106.9093876736718!3d-6.927555893072223!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68376d394b0adf%3A0xd8519f1432d1aee7!2sSDN%20Caringin%20Ngumbang!5e0!3m2!1sid!2sid!4v1716061067216!5m2!1sid!2sid" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="row align-items-center">
                <div class="col-md-5 my-3">
                    <h6 class="mb-0">Alamat Sekolah</h6>
                    <p class="mb-4">Jln. Caringin Ngumbang, Benteng, Kec. Warudoyong, Kota Sukabumi, Jawa Barat 43132</p>
                    <h6 class="mb-0">Contact & Sosial Media</h6>
                    @foreach ($contact_sekolahs as $contactSekolah)
                        <a href="{{ $contactSekolah->link }}" target="_blank"><img src="{{ $contactSekolah->icon }}" width="25" height="25"> {{ $contactSekolah->name }}</a><br>
                    @endforeach
                </div>
                <div class="col-md-7">
                    <form method="POST" action="{{ route('message.home') }}">
                        @csrf
                        <h4 class="mb-4">Kirim Pesan </h4>
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                @error('name')
                                    <small style="color:red">{{$message}}</small>
                                @enderror
                                <input type="text" class="form-control text-white rounded-0 bg-transparent" name="name" placeholder="Name">
                            </div>
                            <div class="form-group col-sm-4">
                                @error('email')
                                    <small style="color:red">{{$message}}</small>
                                @enderror
                                <input type="email" class="form-control text-white rounded-0 bg-transparent" name="email" placeholder="Email">
                            </div>
                            <div class="form-group col-sm-4">
                                @error('subject')
                                    <small style="color:red">{{$message}}</small>
                                @enderror
                                <input type="text" class="form-control text-white rounded-0 bg-transparent" name="subject" placeholder="Subject">
                            </div>
                            <div class="form-group col-12">
                                @error('message')
                                    <small style="color:red">{{$message}}</small>
                                @enderror
                                <textarea name="message" id="" cols="30" rows="4" class="form-control text-white rounded-0 bg-transparent" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group col-12 mb-0">
                                <button type="submit" class="btn btn-primary rounded btn-block w-md mt-3">Send</button>
                            </div>                          
                        </div>                          
                    </form>
                </div>
            </div>
            <!-- Page Footer -->
            <footer class="mt-5 py-4 border-top border-secondary">
                <p class="mb-0 small">&copy; <script>document.write(new Date().getFullYear())</script>, <a href="https://www.instagram.com/sdn_carngum/" target="_blank">SD Negeri Caringin Ngumbang </a>Created By <a href="https://portofolio-rizky-chandra.laravel.cloud/" target="_blank">Rizky Chandra Khusuma.</a>  All rights reserved </p>     
            </footer>
            <!-- End of Page Footer -->  
        </div>
    </section>
    <!-- End of Contact Section -->

    {{-- Script untuk button pencarian --}}
    <script>
        document.getElementById('search-button').addEventListener('click', function(event) {
            event.preventDefault();
            var searchForm = document.getElementById('search-form');
            if (searchForm.classList.contains('active')) {
                searchForm.classList.remove('active');
            } else {
                searchForm.classList.add('active');
            }
        });
    </script>

    {{-- Sweate Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
	<!-- core  -->
    <script src="/!template-blog/assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="/!template-blog/assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap 3 affix -->
	<script src="/!template-blog/assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- Isotope -->
    <script src="/!template-blog/assets/vendors/isotope/isotope.pkgd.js"></script>

    <!-- LeadMark js -->
    <script src="/!template-blog/assets/js/leadmark.js"></script>
</body>
</html>
