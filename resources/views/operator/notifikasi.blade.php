@extends('layouts.operatorApp')

@section('title', 'Pesan Masuk')

@section('content')
    <div class="container">
        @if (session('danger'))
            <div id="danger-alert" class="alert alert-danger">
                {{ session('danger') }}
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        var dangerAlert = document.getElementById('danger-alert');
                        if (dangerAlert) {
                            dangerAlert.style.transition = 'opacity 0.5s ease-out';
                            dangerAlert.style.opacity = '0';
                            setTimeout(function() {
                                dangerAlert.remove();
                            }, 500);
                        }
                    }, 3000);
                });
            </script>
        @endif
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
        <div class="row">
            @foreach ($messages as $message)
                <div class="col-md-4 mb-2">
                    <div class="card {{ $message->is_read ? '' : 'border-danger' }}">
                        <div class="card-header">
                            <h5 class="card-title">{{ $message->subject }}</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">{{ $message->name }} <br> 
                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></h6>
                            <p class="card-text">{{ $message->message }}</p>
                        </div>
                        <div class="card-footer text-muted">
                            {{ $message->created_at->format('d M Y, H:i') }}
                            <div class="d-inline-block">
                                <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');" title="Delete">Delete</button>
                                </form>
                                @if (!$message->is_read)
                                    <form action="{{ route('messages.read', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary ml-1">Read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
