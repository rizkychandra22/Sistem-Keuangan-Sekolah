@extends('layouts.operatorApp')

@section('title', 'Edit Data Prestasi SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('prestasi.update',$prestasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Prestasi:</strong>
                        <input type="text" name="judul" value="{{ $prestasi->judul }}" class="form-control" placeholder="Nama prestasi yang didapatkan">
                        @error('judul')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi prestasi:</strong>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi prestasi yang didapatkan">{{ $prestasi->deskripsi }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar prestasi yang didapatkan">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/prestasi/'.$prestasi->gambar) }}" width="50%">
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
