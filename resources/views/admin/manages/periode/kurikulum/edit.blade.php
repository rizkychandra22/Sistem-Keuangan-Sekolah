@extends('layouts.adminApp')

@section('title', 'Edit Data Kurikulum Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('kurikulum.update', $kurikulum->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Nama Kurikulum:</strong>
                        <input type="text" name="nama" value="{{ old('nama', $kurikulum->nama) }}" class="form-control" placeholder="Nama Kurikulum">
                        @error('nama')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tahun Kurikulum:</strong>
                        <input type="text" name="tahun" value="{{ old('tahun', $kurikulum->tahun) }}" class="form-control" placeholder="Contoh: 2013 / 2024">
                        @error('tahun')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Kurikulum:</strong>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi kurikulum">{{ old('deskripsi', $kurikulum->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @include('components.admin-form-actions', ['cancelRoute' => route('kurikulum.index')])
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
