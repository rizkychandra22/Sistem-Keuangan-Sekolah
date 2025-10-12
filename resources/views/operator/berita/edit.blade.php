@extends('layouts.operatorApp')

@section('title', 'Edit Data Berita Sekolah SDN Caringin Ngumbang')

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
        <form action="{{ route('berita-sekolah.update',$beritaSekolah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Judul Berita:</strong>
                        <input type="text" name="judul" value="{{ $beritaSekolah->judul }}" class="form-control" placeholder="Judul berita yang ada ingin diupload">
                        @error('judul')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Berita:</strong>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi berita yang ada ingin diupload">{{ $beritaSekolah->deskripsi }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar berita yang ada ingin diupload">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/berita/'.$beritaSekolah->gambar) }}" width="50%">
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
