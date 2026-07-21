@extends('layouts.adminApp')

@section('title', 'Tambah Data Akun User SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="alert alert-info">
            Password default untuk akun user baru adalah <strong>sekolah</strong>.
        </div>

        <form action="{{ route('dataUser.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nama Akun User">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username Login">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email Akun User">
                        @error('email')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Role:</strong>
                        <select name="role" class="form-control">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roleOptions as $role)
                                <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
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

    {{-- Sweate Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
