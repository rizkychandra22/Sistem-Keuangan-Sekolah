@extends('layouts.adminApp')

@section('title', 'Dashboard Admin')

@section('content')
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
                                        <i class="fas fa-user-tie icon-hover dashboard-icon-lg"></i>
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
