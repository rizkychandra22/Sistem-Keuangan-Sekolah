@extends('layouts.guruApp')

@section('title', 'Profile Guru')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('components.alert-messages')
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="img">
                                    <div class="pull-right text-right">
                                        <a class="btn btn-warning btn-sm" href="{{ route('profile.edit.guru', $user->id) }}"> Edit Data</a>
                                    </div>
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('images/user/'.$user->gambar) }}" alt="{{ $user->name }}" style="max-width: 200px;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Nama Guru</th>
                            <td>{{ $user->guru->nama ?? $user->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">NIP</th>
                            <td>{{ $user->guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Jabatan</th>
                            <td>{{ $user->guru->jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Kontak</th>
                            <td>{{ $user->guru->kontak ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Motivasi</th>
                            <td>{{ $user->guru->motivasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Username (Login)</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection