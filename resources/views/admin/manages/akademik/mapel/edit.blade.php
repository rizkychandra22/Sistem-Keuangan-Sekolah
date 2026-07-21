@extends('layouts.adminApp')

@section('title', 'Edit Data Mata Pelajaran Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Nama Mata Pelajaran:</strong>
                        <input type="text" name="nama" value="{{ old('nama', $mapel->nama) }}" class="form-control" placeholder="Nama Mata Pelajaran">
                        @error('nama')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Kode Mata Pelajaran:</strong>
                        <input type="text" name="kode" value="{{ old('kode', $mapel->kode) }}" class="form-control" placeholder="Kode Mata Pelajaran">
                        @error('kode')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Kurikulum:</strong>
                        <select name="kurikulum_id" class="form-control">
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach ($kurikulums as $kurikulum)
                                <option value="{{ $kurikulum->id }}" {{ old('kurikulum_id', $mapel->kurikulum_id) == $kurikulum->id ? 'selected' : '' }}>
                                    {{ $kurikulum->nama }} - {{ $kurikulum->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('kurikulum_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @include('components.admin-form-actions', ['cancelRoute' => route('mapel.index')])
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
