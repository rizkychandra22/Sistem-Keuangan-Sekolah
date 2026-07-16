@extends('layouts.operatorApp')

@section('title', 'Edit Data Contact dan Sosial Media Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('contact-sekolah.update', $contactSekolah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Icon Logo Sosial Media:</strong>
                        <input type="text" name="icon" value="{{ $contactSekolah->icon }}" class="form-control" placeholder="Paste url icon sosial media dari fontawesome">
                        @error('icon')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>DNama Sosial Media:</strong>
                        <input type="text" name="name" value="{{ $contactSekolah->name }}" class="form-control" placeholder="Isi dengan nama sosial media">
                        @error('name')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>URL Sosial Media:</strong>
                        <input type="text" name="link" value="{{ $contactSekolah->link }}" class="form-control" placeholder="Paste url sosial media contoh: https://instagram.com/namauser, mailto:example@gmail.com atau https://wa.me/68278xxxxxx.">
                        @error('link')
                            <small style="color:red">{{$message}}</small>
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