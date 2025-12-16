@extends('teacher.layouts.main',['title' => 'Izin Siswa'])
@section('content')

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>

<script>
    // Script untuk menampilkan Hari, Tanggal, dan Waktu (WIB) yang selalu diperbarui
    function updateDateTime() {
        const now = new Date();

        // Opsi untuk format Tanggal dan Hari (misal: Rabu, 03 Desember 2025)
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'Asia/Jakarta'
        };
        const dateString = now.toLocaleDateString('id-ID', dateOptions);

        // Opsi untuk format Waktu (misal: 10:31:00 WIB)
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        };
        const timeString = now.toLocaleTimeString('id-ID', timeOptions) + ' WIB';

        // Update elemen di UI
        const dateElement = document.getElementById('current-date-day');
        const timeElement = document.getElementById('current-time-clock');

        if (dateElement) dateElement.textContent = dateString;
        if (timeElement) timeElement.textContent = timeString;
    }

    // Fungsi untuk menampilkan pratinjau gambar setelah dipilih
    document.addEventListener('DOMContentLoaded', () => {
        const inputPhoto = document.getElementById('photo-absen');
        const previewImage = document.getElementById('image-preview');

        if (inputPhoto) {
            inputPhoto.addEventListener('change', function (event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }
    });

    // Panggil fungsi sekali saat load, lalu ulangi setiap detik
    setInterval(updateDateTime, 1000);
    updateDateTime();

</script>
<script>
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            document.getElementById('lat').value = pos.coords.latitude;
            document.getElementById('long').value = pos.coords.longitude;
        },
        function (err) {
            console.log("Lokasi tidak diizinkan");
        }
    );

</script>
