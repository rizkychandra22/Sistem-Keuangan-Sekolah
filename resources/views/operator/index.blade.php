@extends('layouts.operatorApp')

@section('title', 'Dashboard Operator')

@section('content')
    <style>
        .dashboard-card {
            border-radius: 22px;
            overflow: hidden;
            color: white;
        }

        .card-link {
            text-decoration: none;
        }

        .card-item {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 22px;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.18);
        }

        .dashboard-card hr {
            border-color: rgba(255, 255, 255, 0.55);
        }

        .card-program {
            background: linear-gradient(135deg, #c66a12, #f29f05);
        }

        .card-berita {
            background: linear-gradient(135deg, #1f3a5f, #355c7d);
        }

        .card-prestasi {
            background: linear-gradient(135deg, #b88a08, #f2c94c);
        }

        .card-lomba {
            background: linear-gradient(135deg, #b83232, #e05a47);
        }

        .card-event {
            background: linear-gradient(135deg, #1d6fa5, #3fa7d6);
        }

        .card-tour {
            background: linear-gradient(135deg, #1f8a70, #52b788);
        }

        .card-perpisahan {
            background: linear-gradient(135deg, #6f3faa, #9d6ad8);
        }

        .icon-hover {
            transition: color 0.2s, transform 0.2s;
            color: white; /* Warna ikon awal putih */
        }

        .icon-hover:hover {
            cursor: pointer;
            color: white; /* Warna ikon saat di-hover menjadi kuning */
        }

        .icon-hover:hover:before {
            content: "\f06e"; /* Kode unicode untuk ikon mata (eye) */
            font-family: "Font Awesome 5 Free"; /* Pastikan font-family sesuai */
            font-weight: 900; /* Pastikan font-weight sesuai */
            color: white; /* Warna ikon mata saat di-hover menjadi kuning */
        }

        .icon-hover {
            position: relative;
            z-index: 1;
        }
    </style>
    <div class="container">
        <div class="row">
            {{-- Start Card Program Kerja --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-program">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('program-kerja.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-tasks icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Program Kerja</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalProgram }} Program</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Card Program Kerja --}}

            {{-- Start Card Berita Sekolah --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-berita">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('berita-sekolah.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-newspaper icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Berita Sekolah</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalBerita }} Berita</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                    
            {{-- End Card Berita Sekolah --}}
            
            {{-- Start Card Total Prestasi --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-prestasi">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                               <a href="{{ route('prestasi.index') }}">
                                <div class="icon-big text-center">
                                    <i class="fas fa-solid fa-trophy icon-hover" style="font-size: 3rem; color: white;"></i>
                                </div>
                               </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Data Prestasi</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalPrestasi }} Postingan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                       
            {{-- End Card Total Prestasi --}}

            {{-- Start Card Total Lomba --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-lomba">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('gallery-lomba.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-medal icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Data Album Lomba</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalLomba }} Postingan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            {{-- End Card Total Lomba --}}

            {{-- Start Card Total Event --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-event">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('gallery-event.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-calendar-alt icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Data Album Event</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalEvent }} Postingan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                      
            {{-- End Card Total event --}}

            {{-- Start Card Total Study Tour  --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-tour">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('gallery-pariwisata.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-bus icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Data Album Tour</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalTour }} Postingan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
            {{-- End Card Total Study Tour  --}}

            {{-- Start Card Total Perpisahan  --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats dashboard-card card-perpisahan">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('gallery-perpisahan.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fa-sharp fas fa-graduation-cap icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Album Perpisahan</p>
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalPerpisahan }} Kenangan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            {{-- End Card Total Perpisahan  --}}
        </div>
    </div>
@endsection
