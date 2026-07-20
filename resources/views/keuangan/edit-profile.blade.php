@extends('layouts.keuanganApp')

@section('title', 'Edit Profile User')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('profile.update.keuangan', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                
                @include('components.shared.profile-form-row-left')
                @include('components.shared.profile-form-row-right')

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
                    <a href="{{ route('profile.keuangan') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                </div>
            </div>            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
