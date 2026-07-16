<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Program Kerja SDN Caringin Ngumbang</title>
    <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">
    <!-- font icons -->
    <link rel="stylesheet" href="/!template-blog/assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="/!template-blog/assets/css/leadmark.css">
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Foto Kepala Sekolah --}}
    <style>
        .custom {
            max-width: 100%; 
            margin: auto;
        }
        .custom img {
            display: block;
            margin: 0 auto;
            width: 20%;
            height: auto;
        }
        .custom .title {
            text-align: center;
            margin-top: 0; 
        }
    </style>

    {{-- Button pencarian --}}
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
            <a class="navbar-brand" href="/informasi-sekolah">
                <img src="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#program-kerja">Program Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#berita-sekolah">Berita Sekolah</a>
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
            
            @include('components.alert-messages')

            <h1 class="subtitle">Informasi Berita dan Program Kerja Sekolah</h1>
        </div>  
        <div class="shape">
            <svg viewBox="0 0 1500 200">
                <path d="m 0,240 h 1500.4828 v -71.92164 c 0,0 -286.2763,-81.79324 -743.19024,-81.79324 C 300.37862,86.28512 0,168.07836 0,168.07836 Z"/>
            </svg>
        </div>  
        <div class="mouse-icon"><div class="wheel"></div></div>
    </header>
    <!-- End Of Page Header -->

    <!-- Sambutan dan Program Kerja Section -->
    <section id="program-kerja" class="section pt-0">
        <div class="container">
            @foreach ($sambutans as $sambutan)
            <div class="custom mb-4 mb-md-0">
                <div class="body">
                    <h4 class="title">"Sambutan Kepala Sekolah,,</h4><br>
                    <div class="media align-items-center">
                        <img class="img-fluid rounded-circle mb-4" src="{{ asset('images/sambutan/'.$sambutan->gambar) }}">
                    </div>
                    <h6 class="title">{{ $sambutan->nama }}</h6>
                    <p class="mb-2"><b>{{ $sambutan->deskripsi }}</b></p><hr>
                </div>
            </div>
            @endforeach
        </div>
        <h6 class="section-title text-center">"Program Kerja,,</h6>
        <h6 class="section-subtitle text-center mb-5 pb-3">Tahun Ajaran 2024/2025</h6>
        <div class="container">
            <div class="row">
                @foreach ( $programkerjas as $programkerja)
                    <div class="col-md-4" style="margin-top: -20px;">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <small class="text-primary font-weight-bold">{{ $loop->iteration }}</small>
                                <h5 class="card-title mt-3">"{{ $programkerja->judul }},,<h5>
                                <p class="mb-0">{{ $programkerja->deskripsi }}</p>
                            </div>
                        </div>
                    </div>              
                @endforeach
            </div>
        </div>
    </section>
    <!-- End OF Sambutan dan Program Kerja Section -->

    <!-- Berita Sekolah Section -->
    <section class="section" id="berita-sekolah">
        <div class="container">
            <h6 class="section-title mb-0 text-center">"Berita Sekolah,,</h6>
            <h6 class="section-subtitle mb-5 text-center">Informasi tentang pendidikan dan kegiatan sekolah</h6>
            <div class="row">
                @foreach ($berita_sekolahs as $beritaSekolah)
                    <div class="col-md-4">
                        <div class="card border-0 mb-4">
                            <img src="{{ asset('images/berita/'.$beritaSekolah->gambar) }}" alt="" class="card-img-top w-100">
                            <div class="card-body">                         
                                <h6 class="card-title">{{ $beritaSekolah->judul }}</h6>
                                <p>{{ $beritaSekolah->deskripsi }}</</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End of Berita Sekolah Section -->

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
                        <a href="{{ $contactSekolah->link }}"><img src="{{ $contactSekolah->icon }}" width="25" height="25"> {{ $contactSekolah->name }}</a><br>
                    @endforeach
                </div>
                <div class="col-md-7">
                    <form method="POST" action="{{ route('message.info') }}">
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
