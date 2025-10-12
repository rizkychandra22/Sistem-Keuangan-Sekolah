@extends('layouts.operatorApp')

@section('title', 'Dashboard Operator')

@section('content')
    <style>
        .card-link {
            text-decoration: none;
        }

        .card-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
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
            {{-- Start Card Total Guru --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats" style="background-color: #007bff; color: white;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('guru.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-user-tie icon-hover" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center tulisan">
                                <div class="numbers">
                                    <p class="card-category ket head">Data Guru</p>
                                    <hr style="border-color: white;">
                                    <h4 class="card-title ket total">{{ $totalGuru }} Guru</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Card Total Guru --}}

            {{-- Start Card Program Kerja --}}
            <div class="col-md-4 mb-3">
                <div class="card-item card-stats" style="background-color: #ff851b; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #2c3e50; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #ffcc00; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #e74c3c; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #3498db; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #2ecc71; color: white;">
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
                                    <hr style="border-color: white;">
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
                <div class="card-item card-stats" style="background-color: #8e44ad; color: white;">
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
                                    <hr style="border-color: white;">
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
