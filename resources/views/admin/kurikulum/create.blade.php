@extends('layouts.adminApp')

@section('title', 'Tambah Data Kurikulum SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('kurikulum.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nama Kurikulum:</strong>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" placeholder="Nama Kurikulum" required>
                        @error('nama')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Tahun Kurikulum:</strong>
                        <input type="text" name="tahun" value="{{ old('tahun') }}" class="form-control" placeholder="Contoh: 2013 / 2024" required>
                        @error('tahun')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kurikulum:</strong>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi kurikulum">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
