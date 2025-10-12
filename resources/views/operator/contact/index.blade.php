@extends('layouts.operatorApp')

@section('title', 'Contact dan Sosial Media Sekolah')

@section('content')
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

    <div class="table-responsive">
        <table class="table table-bordered ">
            <thead style="background-color: #66aaff">
                <tr>
                    <th><img src="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png" alt="Ikon Sekolah" width="25" height="25"></th>
                    <th width="45%">Nama Contact</th>
                    <th width="45%">Link Contact</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contact_sekolahs as $contactSekolah)
                    <tr>
                        <td>
                            <a href="{{ $contactSekolah->link }}" target="_blank">
                                <img src="{{ $contactSekolah->icon }}" alt="Ikon" width="25" height="25">
                            </a>
                        </td>
                        <td>{{ $contactSekolah->name }}</td>
                        <td><a href="{{ $contactSekolah->link }}" target="_blank">{{ $contactSekolah->link }}</a></td>
                        <td>
                            <a class="btn btn-secoundary btn-outline-warning btn-sm" href="{{ route('contact-sekolah.edit', $contactSekolah->id) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
<!-- Link to Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>