@extends('layouts.adminApp')

@section('title', 'Edit Data Rombel Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('rombel.update', $rombel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Tahun Ajaran:</strong>
                        <select name="tahun_ajaran_id" class="form-control">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($dataTahunAjaran as $tahunAjaran)
                                <option value="{{ $tahunAjaran->id }}" {{ old('tahun_ajaran_id', $rombel->tahun_ajaran_id) == $tahunAjaran->id ? 'selected' : '' }}>
                                    {{ $tahunAjaran->tahun }} - {{ ucfirst($tahunAjaran->semester) }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Kelas:</strong>
                        <select name="kelas_id" id="kelas_id" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($dataKelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id', $rombel->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Wali Kelas:</strong>
                        <select name="guru_id" class="form-control">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($dataWalikelas as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id', $rombel->guru_id) == $guru->id ? 'selected' : '' }}>
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
                        <strong>Paralel:</strong>
                        <input type="text" name="paralel" id="paralel" value="{{ old('paralel', $rombel->paralel) }}" class="form-control" placeholder="Contoh: A / B / C / D">
                        @error('paralel')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Kapasitas:</strong>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas', $rombel->kapasitas) }}" class="form-control" placeholder="Kapasitas Siswa">
                        @error('kapasitas')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <strong>Status Aktif:</strong>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $rombel->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $rombel->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paralelInput = document.getElementById('paralel');

            paralelInput.addEventListener('input', function () {
                paralelInput.value = paralelInput.value.toUpperCase();
            });
        });
    </script>
@endsection
