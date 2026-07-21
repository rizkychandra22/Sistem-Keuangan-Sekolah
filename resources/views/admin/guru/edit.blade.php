@extends('layouts.adminApp')

@section('title', 'Edit Data Guru Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('guru.update',$guru->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Akun User Guru:</strong>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">-- Pilih Akun Guru --</option>
                            @foreach ($availableUsers as $user)
                                <option
                                    value="{{ $user->id }}"
                                    data-nama="{{ $user->name }}"
                                    {{ old('user_id', $guru->user_id) == $user->id ? 'selected' : '' }}
                                    {{ $user->guru && $user->id !== $guru->user_id ? 'disabled' : '' }}
                                >
                                    {{ $user->username }} - {{ $user->name }}{{ $user->guru && $user->id !== $guru->user_id ? ' (sudah dipakai)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $guru->nama) }}" class="form-control" placeholder="Nama Guru" readonly>
                        @error('nama')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>NIP:</strong>
                        <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="form-control" placeholder="NIP Guru">
                        @error('nip')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Jabatan:</strong>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" class="form-control" placeholder="Jabatan Guru">
                        @error('jabatan')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Kontak:</strong>
                        <input type="text" name="kontak" value="{{ old('kontak', $guru->kontak) }}" class="form-control" placeholder="Nomor telepon atau whatsapp">
                        @error('kontak')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Motivasi:</strong>
                        <textarea name="motivasi" class="form-control" rows="3" placeholder="Motivasi Untuk Siswa & Siswi">{{ old('motivasi', $guru->motivasi) }}</textarea>
                        @error('motivasi')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar">
                        @error('gambar')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/guru/'.$guru->gambar) }}" width="50%">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Sweate Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const namaInput = document.getElementById('nama');

            function syncNamaGuru() {
                const selectedOption = userSelect.options[userSelect.selectedIndex];
                namaInput.value = selectedOption?.dataset?.nama ?? '';
            }

            userSelect.addEventListener('change', syncNamaGuru);
            syncNamaGuru();
        });
    </script>
@endsection
