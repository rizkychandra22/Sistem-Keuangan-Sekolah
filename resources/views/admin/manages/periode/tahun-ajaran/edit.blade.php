@extends('layouts.adminApp')

@section('title', 'Edit Tahun Ajaran SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('tahunAjaran.update', $tahunAjaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Tahun Ajaran:</strong>
                        <input type="text" name="tahun" value="{{ old('tahun', $tahunAjaran->tahun) }}" class="form-control" placeholder="Contoh: 2025/2026">
                        @error('tahun')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Semester:</strong>
                        <select name="semester" class="form-control">
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil" {{ old('semester', $tahunAjaran->semester) === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester', $tahunAjaran->semester) === 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Status Aktif:</strong>
                        <select name="is_active" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="0" {{ old('is_active', (string) (int) $tahunAjaran->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="1" {{ old('is_active', (string) (int) $tahunAjaran->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('is_active')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Status Kunci:</strong>
                        <select name="is_locked" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="0" {{ old('is_locked', (string) (int) $tahunAjaran->is_locked) == '0' ? 'selected' : '' }}>Terbuka</option>
                            <option value="1" {{ old('is_locked', (string) (int) $tahunAjaran->is_locked) == '1' ? 'selected' : '' }}>Terkunci</option>
                        </select>
                        @error('is_locked')
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
