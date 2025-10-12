@extends('layouts.operatorApp')

@section('title', 'Edit Data Program Kerja SDN Caringin Ngumbang')

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
        <form action="{{ route('program-kerja.update', $programKerja->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Program Kerja:</strong>
                        <input type="text" name="judul" value="{{ $programKerja->judul }}" class="form-control" placeholder="Nama program kerja">
                        @error('judul')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Program Kerja:</strong>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi program kerja">{{ $programKerja->deskripsi }}</textarea>
                        @error('deskripsi')
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
