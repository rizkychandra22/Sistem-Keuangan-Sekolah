@extends('layouts.siswaApp')

@section('title', 'Profile Student')

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
                                        <a class="btn btn-warning btn-sm" href="{{ route('profile.edit.siswa', $user->id) }}"> Edit Data</a>
                                    </div>
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('images/user/siswa/'.$user->gambar) }}" alt="{{ $user->name }}" style="max-width: 200px;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Nama Siswa</th>
                            <td>{{ $user->siswa->nama ?? $user->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">NISN</th>
                            <td>{{ $user->siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Kelas</th>
                            <td>{{ $user->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Tanggal Lahir</th>
                            <td>{{ $user->siswa && $user->siswa->tgl_lhr ? $user->siswa->tgl_lhr->format('d-m-Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Alamat</th>
                            <td>{{ $user->siswa->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Nama Orang Tua</th>
                            <td>{{ $user->siswa->orang_tua ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Kontak Orang Tua</th>
                            <td>{{ $user->siswa->kontak_orang_tua ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Username (Login)</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
