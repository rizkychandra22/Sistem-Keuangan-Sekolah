@extends('layouts.keuanganApp')

@section('title', 'Edit Data Pengeluaran')

@section('content')
    <div class="container">
        
        {{-- Error ketika form tidak lengkap --}}
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Form Tidak Lengkap!',
                        text: "Pastikan semua field terisi dengan benar.",
                        icon: 'error',
                        confirmButtonColor: '#d33', // Tombol merah
                        confirmButtonText: 'Tutup'
                    });
                });
            </script>
        @endif

        {{-- Error ketika saldo yang di input lebih besar dari saldo yang tersedia --}}
        @if (session('danger'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: 'Saldo Tidak Cukup!',
                        text: "{{ session('danger') }}",
                        icon: 'error',
                        confirmButtonColor: '#d33', // Tombol merah
                        confirmButtonText: 'Tutup'
                    });
                });
            </script>
        @endif
        
        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kebutuhan -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kebutuhan:</strong>
                        <select name="kebutuhan" class="form-control">
                            <option value="{{ $pengeluaran->kebutuhan }}">{{ $pengeluaran->kebutuhan }}</option>
                            <option value="">-- Pilih Kebutuhan Pengeluaran --</option>
                            @foreach($kebutuhanValues as $kebutuhan)
                                <option value="{{ $kebutuhan }}">
                                    {{ $kebutuhan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kebutuhan')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Keterangan:</strong>
                        <textarea type="text" name="keterangan" class="form-control" placeholder="Deskripsi pengeluaran">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
                        @error('keterangan')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal:</strong>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $pengeluaran->tanggal) }}" class="form-control">
                        @error('tanggal')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Sumber Dana -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Sumber Dana:</strong>
                        <select name="sumber" id="sumberDana" class="form-control">
                            <option value="{{ $pengeluaran->sumber }}" data-saldo="{{ $saldoTersedia[$pengeluaran->sumber] ?? 0 }}">{{ $pengeluaran->sumber }}</option>
                            <option value="">-- Pilih Sumber Pemasukan --</option>
                            @foreach($sumberValues as $sumber)
                                <option value="{{ $sumber }}" data-saldo="{{ $saldoTersedia[$sumber] ?? 0 }}">
                                    {{ $sumber }}
                                </option>
                            @endforeach
                        </select>
                        @error('sumber')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Saldo Yang Tersedia -->
                <div class="col-xs-12 col-sm-12 col-md-12" id="saldoContainer" style="display: none;">
                    <div class="form-group">
                        <strong>Saldo Yang Tersedia:</strong>
                        <input type="text" id="saldoTersedia" class="form-control" readonly>
                    </div>
                </div>

                <!-- Jumlah -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Jumlah:</strong>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $pengeluaran->jumlah) }}" class="form-control" placeholder="Jumlah nominal yang dikeluarkan">
                        @error('jumlah')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script for selecting sumber dana and displaying saldo --}}
    <script>
        document.getElementById('sumberDana').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var saldo = selectedOption.getAttribute('data-saldo') || 0;
            var saldoContainer = document.getElementById('saldoContainer');

            if (this.value === "") {
                saldoContainer.style.display = 'none';
            } else {
                saldoContainer.style.display = 'block';
                document.getElementById('saldoTersedia').value = 'Rp ' + parseFloat(saldo).toLocaleString('id-ID', {minimumFractionDigits: 2});
            }
        });

        // Display saldo if initial value is selected
        window.onload = function() {
            var sumberDana = document.getElementById('sumberDana');
            if (sumberDana.value !== "") {
                var event = new Event('change');
                sumberDana.dispatchEvent(event);
            }
        };
    </script>
@endsection
