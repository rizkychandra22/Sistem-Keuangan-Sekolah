@extends('layouts.adminApp')

@section('title', 'Edit Profile User')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('profile.update.admin', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama User:</strong>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Nama User">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Username">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email">
                        @error('email')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password User:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengubah password">
                        @error('password')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <strong>Konfirmasi Password:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru">
                        @error('password_confirmation')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Foto Profile:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Foto profile user admin">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/user/'.$user->gambar) }}" alt="{{ $user->name }}" width="50%">
                        </div>
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
@endsection
