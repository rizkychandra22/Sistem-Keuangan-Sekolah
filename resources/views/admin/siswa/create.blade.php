@extends('layouts.adminApp')

@section('title', 'Tambah Data Siswa SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="alert alert-info">
            Pilih akun user role student jika sudah ada. Jika belum ada, data akun user siswa akan dibuat otomatis dengan password default <strong>sekolah</strong>.
        </div>

        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Akun User Siswa:</strong>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">-- Pilih Akun Siswa Jika Sudah Ada --</option>
                            @foreach ($availableUsers as $user)
                                <option
                                    value="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-username="{{ $user->username }}"
                                    data-email="{{ $user->email }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}
                                    {{ $user->siswa ? 'disabled' : '' }}
                                >
                                    {{ $user->username }} - {{ $user->name }}{{ $user->siswa ? ' (sudah terdaftar)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                        @if ($availableUsers->whereNull('siswa')->count() === 0)
                            <small style="color:#856404">Semua akun user role student sudah terhubung ke data siswa.</small>
                        @endif
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Nama Siswa:</strong>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Nama Siswa">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" placeholder="Username Login">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email Akun Siswa">
                        @error('email')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>NISN:</strong>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-control" placeholder="NISN Siswa">
                        @error('nisn')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tanggal Lahir:</strong>
                        <input type="date" name="tgl_lhr" value="{{ old('tgl_lhr') }}" class="form-control">
                        @error('tgl_lhr')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Alamat:</strong>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat Siswa">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama Orang Tua:</strong>
                        <input type="text" name="orang_tua" value="{{ old('orang_tua') }}" class="form-control" placeholder="Nama Orang Tua">
                        @error('orang_tua')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Kontak Orang Tua:</strong>
                        <input type="text" name="kontak_orang_tua" value="{{ old('kontak_orang_tua') }}" class="form-control" placeholder="Kontak Orang Tua">
                        @error('kontak_orang_tua')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
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
                <div class="col-xs-6 col-sm-6 col-md-6">
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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar Siswa">
                        @error('gambar')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const nameInput = document.getElementById('name');
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const manualValues = {
                name: @json(old('name')),
                username: @json(old('username')),
                email: @json(old('email')),
            };

            function toggleUserFields() {
                const selectedOption = userSelect.options[userSelect.selectedIndex];
                const hasSelectedUser = userSelect.value !== '';

                if (hasSelectedUser) {
                    nameInput.value = selectedOption.dataset.name || '';
                    usernameInput.value = selectedOption.dataset.username || '';
                    emailInput.value = selectedOption.dataset.email || '';
                }

                nameInput.readOnly = hasSelectedUser;
                usernameInput.readOnly = hasSelectedUser;
                emailInput.readOnly = hasSelectedUser;

                if (!hasSelectedUser) {
                    nameInput.value = manualValues.name || '';
                    usernameInput.value = manualValues.username || '';
                    emailInput.value = manualValues.email || '';
                }
            }

            userSelect.addEventListener('change', toggleUserFields);
            toggleUserFields();
        });
    </script>
@endsection
