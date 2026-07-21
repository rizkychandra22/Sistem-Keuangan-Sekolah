@extends('layouts.adminApp')

@section('title', 'Tambah Data Guru Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}
                                    {{ $user->guru ? 'disabled' : '' }}
                                >
                                    {{ $user->name }} &mdash; {{ $user->username }}{{ $user->guru ? ' (sudah terdaftar)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                        @if ($availableUsers->whereNull('guru')->count() === 0)
                            <small style="color:#856404">Semua akun user role teacher sudah terhubung ke data guru.</small>
                        @endif
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control" placeholder="Nama Guru" readonly>
                        @error('nama')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>NIP:</strong>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="form-control" placeholder="NIP Guru">
                        @error('nip')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Jabatan:</strong>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="form-control" placeholder="Jabatan Guru">
                        @error('jabatan')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Kontak:</strong>
                        <input type="text" name="kontak" value="{{ old('kontak') }}" class="form-control" placeholder="Nomor telepon atau whatsapp">
                        @error('kontak')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Motivasi:</strong>
                        <textarea name="motivasi" class="form-control" rows="3" placeholder="Motivasi Untuk Siswa & Siswi">{{ old('motivasi') }}</textarea>
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
                    </div>
                </div>
                @include('components.admin-form-actions', ['cancelRoute' => route('guru.index')])
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
