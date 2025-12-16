@extends('teacher.layouts.main',['title' => 'Dashboard Guru'])
@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Pagi, {{ Auth::user()->username }}! 👋</h5>
                        <p class="mb-4">
                            Selamat mengajar hari ini 👨‍🏫👩‍🏫<br>
                            Berikut ringkasan kehadiran siswa pada kelas Anda.
                            Pantau siswa yang tidak hadir untuk memastikan pembelajaran berjalan maksimal.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('sneat') }}/assets/img/illustrations/man-with-laptop-light.png" height="140"
                            alt="Guru di Dashboard" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="tf-icons bx bx-check-circle" style="font-size: 2.25rem; color: #71dd37;"></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:void(0);">Lihat Kelas</a>
                        </div>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total HADIR</span>
                <h3 class="card-title mb-2">245 Siswa</h3>
                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +2.5% dari Kemarin</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="tf-icons bx bx-error-alt" style="font-size: 2.25rem; color: #ff3e1d;"></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                            <a class="dropdown-item" href="javascript:void(0);">Hubungi Wali Kelas</a>
                        </div>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total ALFA</span>
                <h3 class="card-title text-nowrap mb-1">3 Siswa</h3>
                <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> +1 Siswa dari Rata-rata</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="tf-icons bx bx-book-bookmark" style="font-size: 2.25rem; color: #ffab00;"></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                            <a class="dropdown-item" href="javascript:void(0);">Lihat Surat Izin</a>
                        </div>
                    </div>
                </div>
                <span class="d-block mb-1">Total IZIN</span>
                <h3 class="card-title text-nowrap mb-2">5 Siswa</h3>
                <small class="text-success fw-semibold"><i class="bx bx-down-arrow-alt"></i> -1 Siswa dari Kemarin</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="tf-icons bx bx-first-aid" style="font-size: 2.25rem; color: #696cff;"></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">Lihat Keterangan Sakit</a>
                        </div>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total SAKIT</span>
                <h3 class="card-title mb-2">7 Siswa</h3>
                <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> +2 Siswa dari Kemarin</small>
            </div>
        </div>
    </div>
</div>

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
