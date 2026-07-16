@extends('layouts.operatorApp')

@section('title', 'Edit Profile User')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('profile.update.operator', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama User:</strong>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Nama User">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password User:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @error('password')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <strong>Konfirmasi Password:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                        @error('password_confirmation')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Foto profile user operator">
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

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
