@extends('layouts.operatorApp')

@section('title', 'Edit Data Guru SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('guru.update',$guru->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="nama" value="{{ $guru->nama }}" class="form-control" placeholder="Nama Guru">
                        @error('nama')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Jabatan:</strong>
                        <input type="text" name="jabatan" value="{{ $guru->jabatan }}" class="form-control" placeholder="Jabatan Guru">
                        @error('jabatan')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Motivasi:</strong>
                        <input type="text" name="motivasi" value="{{ $guru->motivasi }}" class="form-control" placeholder="Motivasi Untuk Siswa & Siswi">
                        @error('motivasi')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Gambar:</strong>
                        <input type="file" name="gambar" class="form-control" placeholder="Gambar">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('images/guru/'.$guru->gambar) }}" width="50%">
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
