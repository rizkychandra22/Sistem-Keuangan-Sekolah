@extends('layouts.adminApp')

@section('title', 'Edit Data Akun User SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        @if ($isRoleLocked)
            <div class="alert alert-warning">
                Role akun ini dikunci dan tidak dapat diubah karena termasuk akun sistem utama.
            </div>
        @endif

        <form action="{{ route('dataUser.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Nama Akun User">
                        @error('name')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Username Login">
                        @error('username')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email Akun User">
                        @error('email')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Role:</strong>
                        <select name="role" class="form-control" {{ $isRoleLocked ? 'disabled' : '' }}>
                            @foreach ($roleOptions as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @if ($isRoleLocked)
                            <input type="hidden" name="role" value="{{ $user->role }}">
                        @endif
                        @error('role')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Password Baru:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                        @error('password')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Konfirmasi Password Baru:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
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
