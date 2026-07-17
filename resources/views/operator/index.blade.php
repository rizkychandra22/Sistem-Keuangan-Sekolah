@extends('layouts.operatorApp')

@section('title', 'Dashboard Operator')

@section('content')
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
                                        <i class="fas fa-tasks icon-hover dashboard-icon-lg"></i>
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
                                        <i class="fas fa-newspaper icon-hover dashboard-icon-lg"></i>
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
                                    <i class="fas fa-solid fa-trophy icon-hover dashboard-icon-lg"></i>
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
                                        <i class="fas fa-medal icon-hover dashboard-icon-lg"></i>
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
                                        <i class="fas fa-calendar-alt icon-hover dashboard-icon-lg"></i>
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
                                        <i class="fas fa-bus icon-hover dashboard-icon-lg"></i>
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
                                        <i class="fa-sharp fas fa-graduation-cap icon-hover dashboard-icon-lg"></i>
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
