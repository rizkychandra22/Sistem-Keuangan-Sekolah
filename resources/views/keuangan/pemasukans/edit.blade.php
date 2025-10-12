@extends('layouts.keuanganApp')

@section('title', 'Edit Data Pemasukan')

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
        
        <form action="{{ route('pemasukan.update', $pemasukan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Sumber Pemasukan -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Sumber Pemasukan:</strong>
                        <select name="sumber" id="sumberDana" class="form-control">
                            <option value="{{ $pemasukan->sumber }}" data-saldo="{{ $saldoTersedia[$pemasukan->sumber] ?? 0 }}">{{ $pemasukan->sumber }}</option>
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

                <!-- Saldo yang Tersedia -->
                <div class="col-xs-12 col-sm-12 col-md-12" id="saldoContainer" style="display: none;">
                    <div class="form-group">
                        <strong>Saldo Yang Tersedia:</strong>
                        <input type="text" id="saldoTersedia" class="form-control" readonly>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <strong>Keterangan:</strong>
                    <textarea type="text" name="keterangan" class="form-control" placeholder="Deskripsi pemasukan">{{ old('keterangan', $pemasukan->keterangan) }}</textarea>
                    @error('keterangan')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal:</strong>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $pemasukan->tanggal) }}" class="form-control">
                        @error('tanggal')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Jumlah:</strong>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $pemasukan->jumlah) }}" class="form-control" placeholder="Jumlah nominal yang dimasukkan">
                        @error('jumlah')
                            <small style="color:red">{{$message}}</small>
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

    {{-- Select sumber pengeluaran --}}
    <script>
        document.getElementById('sumberDana').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var saldo = selectedOption.getAttribute('data-saldo') || 0;
            var saldoContainer = document.getElementById('saldoContainer');

            if (this.value === "") {
                saldoContainer.style.display = 'none';
            } else {
                saldoContainer.style.display = 'block';
                document.getElementById('saldoTersedia').value = 'Rp' + parseFloat(saldo).toLocaleString('id-ID', {minimumFractionDigits: 2});
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
