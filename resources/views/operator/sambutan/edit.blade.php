@extends('layouts.operatorApp')

@section('title', 'Edit Data Sambutan Kepala Sekolah SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div id="error-alert" class="alert alert-danger">
                <strong>Whoops Error!</strong>
                <p>Terjadi kesalahan karena ada form input yang masih kosong</p>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        var errorAlert = document.getElementById('error-alert');
                        if (errorAlert) {
                            errorAlert.style.transition = 'opacity 0.5s ease-out';
                            errorAlert.style.opacity = '0';
                            setTimeout(function() {
                                errorAlert.remove();
                            }, 500);
                        }
                    }, 3000);
                });
            </script>
        @endif
        <form action="{{ route('sambutan.update', $sambutan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Kepala Sekolah:</strong>
                        <input type="text" name="nama" value="{{ $sambutan->nama }}" class="form-control" placeholder="Nama prestasi yang didapatkan">
                        @error('nama')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Sambutan:</strong>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi prestasi yang didapatkan">{{ $sambutan->deskripsi }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Foto profile kepala sekolah">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/sambutan/'.$sambutan->gambar) }}" width="50%">
                        </div>
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
@endsection
