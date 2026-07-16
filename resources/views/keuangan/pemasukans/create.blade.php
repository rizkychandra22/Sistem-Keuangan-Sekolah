@extends('layouts.keuanganApp')

@section('title', 'Tambah Dana Pemasukan')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <form action="{{ route('pemasukan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Sumber Dana:</strong>
                        <select name="sumber" id="sumberDana" class="form-control">
                            <option value="">-- Pilih Sumber Pemasukan --</option>
                            @foreach($sumberValues as $sumber)
                                <option value="{{ $sumber }}" data-saldo="{{ $saldoTersedia[$sumber] ?? 0 }}">
                                    {{ $sumber }}
                                </option>
                            @endforeach
                        </select>
                        @error('sumber')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" id="saldoContainer" style="display: none;">
                    <div class="form-group">
                        <strong>Saldo Yang Tersedia:</strong>
                        <input type="text" id="saldoTersedia" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Keterangan:</strong>
                        <textarea type="text" name="keterangan" class="form-control" placeholder="Deskripsi pemasukan"></textarea>
                        @error('keterangan')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal:</strong>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal">
                        @error('tanggal')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Jumlah:</strong>
                        <input type="number" id="jumlahInput" name="jumlah" class="form-control" placeholder="Jumlah nominal yang dimasukkan">
                        @error('jumlah')
                            <small style="color:red">{{$message}}</small>
                        @enderror
                    </div>
                </div>
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
    </script>

    {{-- Set tanggal otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // Januari adalah 0
            var year = today.getFullYear();
            var todayDate = year + '-' + month + '-' + day;
            document.getElementById('tanggal').value = todayDate;
        });
    </script>
@endsection