@extends('layouts.siswaApp')

@section('title', 'Edit Profile Siswa')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('profile.update.siswa', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nama Lengkap:</strong>
                        <input type="text" name="name" value="{{ old('name', $user->siswa->nama ?? $user->name) }}" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <strong>NISN:</strong>
                        <input type="text" name="nisn" value="{{ old('nisn', $user->siswa->nisn ?? '') }}" class="form-control" placeholder="NISN">
                    </div>
                    <div class="form-group">
                        <strong>Tanggal Lahir:</strong>
                        <input type="date" name="tgl_lhr" value="{{ old('tgl_lhr', $user->siswa && $user->siswa->tgl_lhr ? $user->siswa->tgl_lhr->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <strong>Alamat:</strong>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat Rumah">{{ old('alamat', $user->siswa->alamat ?? '') }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nama Orang Tua / Wali:</strong>
                        <input type="text" name="orang_tua" value="{{ old('orang_tua', $user->siswa->orang_tua ?? '') }}" class="form-control" placeholder="Nama Orang Tua">
                    </div>
                    <div class="form-group">
                        <strong>Kontak Orang Tua / Wali:</strong>
                        <input type="text" name="kontak_orang_tua" value="{{ old('kontak_orang_tua', $user->siswa->kontak_orang_tua ?? '') }}" class="form-control" placeholder="No HP/Telp Orang Tua">
                    </div>
                    <div class="form-group">
                        <strong>Username (Login):</strong>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Username Login">
                    </div>
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email Login">
                    </div>
                    <div class="form-group">
                        <strong>Password Login Baru:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengubah password">
                    </div>
                    <div class="form-group">
                        <strong>Konfirmasi Password Baru:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Foto Profile:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Foto profile siswa">
                        <div class="d-flex mt-3">
                            <img src="{{ asset('images/user/siswa/'.$user->gambar) }}" alt="{{ $user->name }}" style="max-height: 150px; border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                    <a href="{{ route('profile.siswa') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                </div>
            </div>            
        </form>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
