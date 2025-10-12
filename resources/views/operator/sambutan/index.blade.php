@extends('layouts.operatorApp')

@section('title', 'Sambutan Kepala Sekolah')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if (session('success'))
                <div id="success-alert" class="alert alert-success">
                    {{ session('success') }}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var successAlert = document.getElementById('success-alert');
                            if (successAlert) {
                                successAlert.style.transition = 'opacity 0.5s ease-out';
                                successAlert.style.opacity = '0';
                                setTimeout(function() {
                                    successAlert.remove();
                                }, 500);
                            }
                        }, 3000);
                    });
                </script>
            @endif
            
            <table class="table table-bordered">
                <tbody>
                    @foreach ($sambutans as $sambutan)
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="img">
                                    <div class="pull-right text-right">
                                        <a class="btn btn-warning btn-sm" href="{{ route('sambutan.edit', $sambutan->id) }}"> Edit Data</a>
                                    </div>
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('images/sambutan/'.$sambutan->gambar) }}" alt="" style="max-width: 200px;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Nama Kepala Sekolah</th>
                            <td>{{ $sambutan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Sambutan</th>
                            <td>{{ $sambutan->deskripsi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
