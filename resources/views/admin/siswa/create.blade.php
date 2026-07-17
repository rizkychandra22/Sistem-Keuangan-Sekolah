@extends('layouts.adminApp')

@section('title', 'Tambah Data Siswa SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="alert alert-info">
            Akun user siswa akan dibuat otomatis dengan password default <strong>sekolah</strong>.
        </div>
        
        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Nama Siswa:</strong>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nama Siswa">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username Login">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email Akun Siswa">
                        @error('email')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>NISN:</strong>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-control" placeholder="NISN Siswa">
                        @error('nisn')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Tanggal Lahir:</strong>
                        <input type="date" name="tgl_lhr" value="{{ old('tgl_lhr') }}" class="form-control">
                        @error('tgl_lhr')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Alamat:</strong>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat Siswa">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nama Orang Tua:</strong>
                        <input type="text" name="orang_tua" value="{{ old('orang_tua') }}" class="form-control" placeholder="Nama Orang Tua">
                        @error('orang_tua')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Kontak Orang Tua:</strong>
                        <input type="text" name="kontak_orang_tua" value="{{ old('kontak_orang_tua') }}" class="form-control" placeholder="Kontak Orang Tua">
                        @error('kontak_orang_tua')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Status Akademik:</strong>
                        <select name="status_akademik" class="form-control">
                            <option value="aktif" {{ old('status_akademik', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ old('status_akademik') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="keluar" {{ old('status_akademik') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                            <option value="pindah" {{ old('status_akademik') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                        @error('status_akademik')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Status Aktif:</strong>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
