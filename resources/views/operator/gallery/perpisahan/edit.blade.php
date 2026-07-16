@extends('layouts.operatorApp')

@section('title', 'Edit Data Album Perpisahan SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('gallery-perpisahan.update', $galleryPerpisahan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Kegiatan:</strong>
                        <input type="text" name="title" value="{{ $galleryPerpisahan->title }}" class="form-control" placeholder="Tema kegiatan perpisahan">
                        @error('title')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kegiatan:</strong>
                        <input type="text" name="subtitle" value="{{ $galleryPerpisahan->subtitle }}" class="form-control" placeholder="Deskripsi kegiatan perpisahan">
                        @error('subtitle')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar kegiatan perpisahan">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/gallery/perpisahan/'.$galleryPerpisahan->gambar) }}" width="50%">
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
@endsection
