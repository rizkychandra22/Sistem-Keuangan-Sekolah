@extends('layouts.operatorApp')

@section('title', 'Profile User')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('components.alert-messages')
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="img">
                                    <div class="pull-right text-right">
                                        <a class="btn btn-warning btn-sm" href="{{ route('profile.edit.operator', $user->id) }}"> Edit Data</a>
                                    </div>
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('images/user/'.$user->gambar) }}" alt="{{ $user->name }}" style="max-width: 200px;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Nama User</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Role User</th>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sweat Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
