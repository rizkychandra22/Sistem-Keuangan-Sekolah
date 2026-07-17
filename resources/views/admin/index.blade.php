@extends('layouts.adminApp')

@section('title', 'Dashboard Admin')

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

        .card-guru {
            background: linear-gradient(135deg, #315c8d, #4f86c6);
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
                <div class="card-item card-stats dashboard-card card-guru">
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
                                    <hr>
                                    <h4 class="card-title ket total">{{ $totalGuru }} Guru</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Card Total Guru --}}
        </div>
    </div>
@endsection
