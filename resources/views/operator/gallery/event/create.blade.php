@extends('layouts.operatorApp')

@section('title', 'Tambah Data Album Event SDN Caringin Ngumbang')

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
        <form action="{{ route('gallery-event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Kegiatan:</strong>
                        <input type="text" name="title" class="form-control" placeholder="Nama event yang diadakan">
                        @error('title')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kegiatan:</strong>
                        <input type="text" name="subtitle" class="form-control" placeholder="Deskripsi event yang diadakan">
                        @error('subtitle')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar event yang diadakan">
                        @error('gambar')
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

    {{-- Sweate Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
