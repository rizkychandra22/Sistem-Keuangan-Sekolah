@extends('layouts.guruApp')

@section('title', 'Edit Profile Guru')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('profile.update.guru', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nama Guru:</strong>
                        <input type="text" name="name" value="{{ old('name', $user->guru->nama ?? $user->name) }}" class="form-control" placeholder="Nama Guru">
                    </div>
                    <div class="form-group">
                        <strong>NIP:</strong>
                        <input type="text" name="nip" value="{{ old('nip', $user->guru->nip ?? '') }}" class="form-control" placeholder="NIP">
                    </div>
                    <div class="form-group">
                        <strong>Jabatan:</strong>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->guru->jabatan ?? '') }}" class="form-control" placeholder="Jabatan">
                    </div>
                    <div class="form-group">
                        <strong>Kontak:</strong>
                        <input type="text" name="kontak" value="{{ old('kontak', $user->guru->kontak ?? '') }}" class="form-control" placeholder="Kontak (No HP/Telp)">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Motivasi:</strong>
                        <textarea name="motivasi" class="form-control" rows="4" placeholder="Kata-kata Motivasi">{{ old('motivasi', $user->guru->motivasi ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Username (Login):</strong>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Username Login">
                    </div>
                    <div class="form-group">
                        <strong>Password Login Baru:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>
                    <div class="form-group">
                        <strong>Konfirmasi Password Baru:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Foto Profile:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Foto profile guru">
                        <div class="d-flex mt-3">
                            <img src="{{ asset('images/user/'.$user->gambar) }}" alt="{{ $user->name }}" style="max-height: 150px; border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                    <a href="{{ route('profile.guru') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                </div>
            </div>            
        </form>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
