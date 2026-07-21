@extends('layouts.adminApp')

@section('title', 'Tambah Tahun Ajaran Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('tahun-ajaran.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tahun Ajaran:</strong>
                        <input type="text" name="tahun" value="{{ old('tahun') }}" class="form-control" placeholder="Contoh: 2025/2026">
                        @error('tahun')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Semester:</strong>
                        <select name="semester" class="form-control">
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil" {{ old('semester') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester') === 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status Aktif:</strong>
                        <select name="is_active" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('is_active')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status Kunci:</strong>
                        <select name="is_locked" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="0" {{ old('is_locked') == '0' ? 'selected' : '' }}>Terbuka</option>
                            <option value="1" {{ old('is_locked') == '1' ? 'selected' : '' }}>Terkunci</option>
                        </select>
                        @error('is_locked')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @include('components.admin-form-actions', ['cancelRoute' => route('tahun-ajaran.index')])
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
