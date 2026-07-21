@extends('layouts.adminApp')

@section('title', 'Edit Data Kelas SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tingkat Kelas:</strong>
                        <input type="number" name="tingkat" value="{{ old('tingkat', $kelas->tingkat) }}" class="form-control" placeholder="Tingkat Kelas">
                        @error('tingkat')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama Kelas:</strong>
                        <input type="text" name="nama" value="{{ old('nama', $kelas->nama) }}" class="form-control" placeholder="Nama Kelas">
                        @error('nama')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kelas:</strong>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi kelas">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
