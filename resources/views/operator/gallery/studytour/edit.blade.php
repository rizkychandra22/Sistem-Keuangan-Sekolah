@extends('layouts.operatorApp')

@section('title', 'Edit Data Album Study Tour SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        {{-- Error ketika form tidak lengkap --}}
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Form Tidak Lengkap!',
                        text: "Pastikan semua field terisi dengan benar.",
                        icon: 'error',
                        confirmButtonColor: '#d33', // Tombol merah
                        confirmButtonText: 'Tutup'
                    });
                });
            </script>
        @endif
        <form action="{{ route('gallery-pariwisata.update', $gallery_pariwisatum->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Kegiatan:</strong>
                        <input type="text" name="title" value="{{ $gallery_pariwisatum->title }}" class="form-control" placeholder="Tema kegiatan study tour">
                        @error('title')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kegiatan:</strong>
                        <input type="text" name="subtitle" value="{{ $gallery_pariwisatum->subtitle }}" class="form-control" placeholder="Deskripsi kegiatan study tour">
                        @error('subtitle')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar kegiatan study tour">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/gallery/studytour/'.$gallery_pariwisatum->gambar) }}" width="50%">
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
