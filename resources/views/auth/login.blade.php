<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login Sekolah</title>
    <link rel="icon" href="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Tambahkan Font Awesome untuk ikon mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="/!template-stisla/dist/assets/css/style.css">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/css/components.css">

    {{-- Download APK --}}
    <link rel="manifest" href="/manifest.json">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <a href="">
                                    <img src="https://i2.wp.com/www.freepnglogos.com/uploads/tut-wuri-handayani-png-logo/vector-wuri-handayani-warna-0.png" alt="logo" width="100" class="shadow-light rounded-circle" style="margin-left: 100px;">
                                </a>
                            </div>
                            <div class="card-body" style="margin-top: -35px"><hr>
                                @error('loginError')
                                    <div id="loginAlert" class="alert alert-danger alert-block" style="text-align:center">
                                        <strong>Login Error</strong>
                                        <p style="text-align:left">{{$message}}</p>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            setTimeout(function() {
                                                var alertLoginError = document.getElementById('loginAlert');
                                                if (alertLoginError) {
                                                    alertLoginError.style.transition = 'opacity 0.5s ease-out';
                                                    alertLoginError.style.opacity = '0';
                                                    setTimeout(function() {
                                                        alertLoginError.remove();
                                                    }, 500);
                                                }
                                            }, 3000);
                                        });
                                    </script>
                                @enderror

                                @if(session('success'))
                                    <div id="registrasiAlert" class="alert alert-success alert-block" style="text-align:center">
                                        <strong>Registrasi Berhasil</strong>
                                        <p style="text-align:left">{{ session('success') }}</p>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            setTimeout(function() {
                                                var alertRegistrasi = document.getElementById('registrasiAlert');
                                                if (alertRegistrasi) {
                                                    alertRegistrasi.style.transition = 'opacity 0.5s ease-out';
                                                    alertRegistrasi.style.opacity = '0';
                                                    setTimeout(function() {
                                                        alertRegistrasi.remove();
                                                    }, 500);
                                                }
                                            }, 3000);
                                        });
                                    </script>
                                @endif

                                @if($errors->has('loginAkses'))
                                    <div id="alert" class="alert alert-danger alert-block" style="text-align:center">
                                        <strong>Akses Halaman Dilarang</strong>
                                        <p style="text-align:left">{{ $errors->first('loginAkses') }}</p>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            setTimeout(function() {
                                                var successAlert = document.getElementById('alert');
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

                                <form method="POST" action="" class="needs-validation" style="margin-top: 20px">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}">
                                        @error('username')
                                            <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                            <small style="color:red">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Login
                                        </button>
                                    </div>
                                </form>
                                <button onclick="window.location.href='/'" class="btn btn-success btn-lg btn-block">Go To Website</button><hr>
                                {{-- <p>Daftar jika siswa belum memiliki akun <a href="/register"> Daftar</a></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="/!template-stisla/dist/assets/modules/jquery.min.js"></script>
    <script src="/!template-stisla/dist/assets/modules/popper.js"></script>
    <script src="/!template-stisla/dist/assets/modules/tooltip.js"></script>
    <script src="/!template-stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="/!template-stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/!template-stisla/dist/assets/modules/moment.min.js"></script>
    <script src="/!template-stisla/dist/assets/js/stisla.js"></script>
    
    <!-- Template JS File -->
    <script src="/!template-stisla/dist/assets/js/scripts.js"></script>
    <script src="/!template-stisla/dist/assets/js/custom.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
          const togglePassword = document.getElementById('togglePassword');
          const passwordField = document.getElementById('password');
          const eyeIcon = document.getElementById('eyeIcon');
      
          togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
      
            // Toggle the eye slash icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
          });
        });
      </script>      
</body>
</html>