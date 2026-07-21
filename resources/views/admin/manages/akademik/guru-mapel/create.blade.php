@extends('layouts.adminApp')

@section('title', 'Tambah Data Guru Mata Pelajaran Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('guru-mapel.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Guru:</strong>
                        <select name="guru_id" class="form-control">
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}{{ $guru->nip ? ' - ' . $guru->nip : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Rombel:</strong>
                        <select name="rombel_id" class="form-control">
                            <option value="">-- Pilih Rombel --</option>
                            @foreach ($rombels as $rombel)
                                <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                                    {{ $rombel->nama }} - {{ $rombel->tahunAjaran?->tahun }}{{ $rombel->tahunAjaran?->semester ? ' (' . ucfirst($rombel->tahunAjaran->semester) . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('rombel_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Mata Pelajaran:</strong>
                        <select name="mapel_id" class="form-control">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}{{ $mapel->kode ? ' - ' . $mapel->kode : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('mapel_id')
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
