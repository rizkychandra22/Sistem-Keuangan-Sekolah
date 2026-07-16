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

{{-- Alert success kirim pesan --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#28a745', // Tombol hijau
                confirmButtonText: 'Oke'
            });
        });
    </script>
@endif