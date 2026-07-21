@extends('layouts.adminApp')

@section('title', 'Tambah Data Siswa Rombel Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <form action="{{ route('siswa-rombel.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Siswa:</strong>
                        <select name="siswa_id" class="form-control">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama }} - {{ $siswa->nisn }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Rombel:</strong>
                        <select name="rombel_id" class="form-control">
                            <option value="">-- Pilih Rombel --</option>
                            @foreach ($rombels as $rombel)
                                <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                                    {{ $rombel->nama }} - {{ $rombel->tahunAjaran?->tahun }} {{ $rombel->tahunAjaran?->semester ? '(' . ucfirst($rombel->tahunAjaran->semester) . ')' : '' }}{{ $rombel->waliKelas?->nama ? ' - Wali: ' . $rombel->waliKelas->nama : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('rombel_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status Akademik:</strong>
                        <select name="status" class="form-control">
                            <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ old('status') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="mengulang" {{ old('status') === 'mengulang' ? 'selected' : '' }}>Mengulang</option>
                            <option value="pindah" {{ old('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="keluar" {{ old('status') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        @error('status')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status Pembelajaran:</strong>
                        <select name="hasil_akhir" class="form-control">
                            <option value="proses_pembelajaran" {{ old('hasil_akhir', 'proses_pembelajaran') === 'proses_pembelajaran' ? 'selected' : '' }}>Proses Pembelajaran</option>
                            <option value="naik_kelas" {{ old('hasil_akhir') === 'naik_kelas' ? 'selected' : '' }}>Naik Kelas</option>
                            <option value="tinggal_kelas" {{ old('hasil_akhir') === 'tinggal_kelas' ? 'selected' : '' }}>Tinggal Kelas</option>
                            <option value="lulus" {{ old('hasil_akhir') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="tidak_lulus" {{ old('hasil_akhir') === 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                        </select>
                        @error('hasil_akhir')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status Siswa:</strong>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Asal Siswa Rombel:</strong>
                        <select name="asal_siswa_rombel_id" class="form-control">
                            <option value="">-- Pilih Asal Siswa Rombel --</option>
                            @foreach ($asalSiswaRombels as $asalSiswaRombel)
                                <option value="{{ $asalSiswaRombel->id }}" {{ old('asal_siswa_rombel_id') == $asalSiswaRombel->id ? 'selected' : '' }}>
                                    {{ $asalSiswaRombel->rombel?->nama ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('asal_siswa_rombel_id')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tanggal Masuk:</strong>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" class="form-control">
                        @error('tanggal_masuk')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tanggal Selesai:</strong>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-control">
                        @error('tanggal_selesai')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Catatan:</strong>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan siswa rombel">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @include('components.admin-form-actions', ['cancelRoute' => route('siswa-rombel.index')])
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
