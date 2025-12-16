@extends('student.layouts.main',['title' => 'Student absen pulang'])
@section('content')

<div class="card">
    <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
        <!-- Judul -->
        <h5 class="card-title m-0 text-nowrap">
            Absen Pulang 📸
        </h5>

        <!-- Tanggal & Jam (badge seperti Sneat) -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge bg-label-info rounded-pill px-3 py-2">
                <i class="bx bx-calendar me-1"></i>
                <span id="current-date-day" class="fw-bold"></span>
            </span>

            <span class="badge bg-label-primary rounded-pill px-3 py-2">
                <i class="bx bx-time-five me-1"></i>
                <span id="current-time-clock" class="fw-bold"></span>
            </span>
        </div>
    </div>

    <div class="card-body">

        <label for="photo-absen" class="form-label d-block text-center cursor-pointer">
            <span class="badge bg-primary fs-6 mb-2">Ambil Foto untuk Absen Pulang</span>
        </label>

        <form action="{{ route('absen.pulang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">

                <input class="form-control d-none" type="file" id="photo-absen" name="photo" accept="image/*" capture="environment" required>

                @php
                use Illuminate\Support\Facades\Auth;
                use Illuminate\Support\Facades\DB; // Add this line

                $userId = Auth::user()->id;
                $student_id = DB::table('students')->where('user_id',$userId)->value('id'); // Get student ID

                @endphp
                <input type="hidden" name="student_id" value="{{ $student_id }}" id="">
                <input type="hidden" name="latitude" id="lat" value="">
                <input type="hidden" name="longitude" id="long" value="">

                <label for="photo-absen" class="border rounded-2 p-4 text-center mb-3 bg-light position-relative w-100 d-block cursor-pointer" style="cursor: pointer;">
                    <i class="bx bx-camera fs-1 text-secondary mb-2"></i>
                    <p class="text-secondary m-0">Ketuk di sini atau klik 'Pilih File' untuk mengambil gambar.</p>

                    <img id="image-preview" src="#" alt="Pratinjau Foto" class="img-fluid rounded-2 mt-3" style="display: none; max-height: 200px; object-fit: cover;">
                </label>

                <div id="photo-help" class="form-text mt-2 text-danger">
                    *Pastikan wajah anda terlihat jelas.
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100">
                <i class="bx bx-check-circle me-1"></i> Konfirmasi Absen pulang
            </button>
        </form>

        <hr class="my-4">

        <div class="alert alert-info" role="alert">
            <h6 class="alert-heading fw-bold mb-1">Catatan Penting:</h6>
            <p class="mb-0">
                Foto yang diunggah akan digunakan sebagai bukti kepulangan. Pastikan perangkat Anda mengizinkan akses kamera dan lokasi. Absen pulang hanya valid pada jam 15:00 WIB hingga 20:00 WIB.
            </p>
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
            inputPhoto.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
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
    const MAX_ALLOWED_ACCURACY = 50; // Toleransi akurasi maksimum yang diterima dalam meter (misal: 50 meter)

    function getGeolocation() {
        const latInput = document.getElementById('lat');
        const longInput = document.getElementById('long');
        const submitButton = document.querySelector('button[type="submit"]');
        const infoAlert = document.getElementById('geolocation-status'); // Elemen status feedback

        // 1. Persiapan UI dan Nonaktifkan Tombol
        if (submitButton) {
            submitButton.disabled = true;
        }
        if (infoAlert) {
            infoAlert.className = 'alert alert-warning';
            infoAlert.innerHTML = 'Memeriksa izin dan mencoba mendapatkan lokasi... (Mohon Tunggu)';
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 20000, // Maksimal 20 detik
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(
            // --- FUNGSI SUKSES ---
            function (pos) {
                const accuracy = pos.coords.accuracy;

                // 2. VALIDASI AKURASI
                if (accuracy > MAX_ALLOWED_ACCURACY) {

                    // Jika akurasi terlalu rendah (di atas 50m)
                    const errorMsg = `Akurasi terlalu rendah! Terdeteksi ${accuracy.toFixed(2)} meter. Harap coba di tempat terbuka dan pastikan GPS aktif.`;
                    alert(`Gagal Absen: ${errorMsg}`);

                    if (infoAlert) {
                        infoAlert.className = 'alert alert-danger';
                        infoAlert.innerHTML = `**Gagal Absen!** ${errorMsg}`;
                    }
                    if (submitButton) {
                        submitButton.textContent = 'Gagal (Akurasi Rendah)';
                        submitButton.disabled = true; // Jaga tombol tetap nonaktif
                    }

                } else {

                    // 3. Jika Akurasi Diterima (<= 50m)
                    latInput.value = pos.coords.latitude;
                    longInput.value = pos.coords.longitude;

                    alert(`Lokasi berhasil didapatkan!\nAkurasi: ${accuracy.toFixed(2)} meter. (Akurasi Bagus)`);

                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Konfirmasi Absen Masuk';
                    }
                    if (infoAlert) {
                        infoAlert.className = 'alert alert-success';
                        infoAlert.innerHTML = `Lokasi berhasil didapatkan. Akurasi GPS: **${accuracy.toFixed(2)} meter**`;
                    }
                }
            },

            // --- FUNGSI ERROR (Timeout, Izin Ditolak, dll.) ---
            function (err) {
                let errorMessage = "Lokasi tidak dapat diambil.";

                switch (err.code) {
                    case err.PERMISSION_DENIED:
                        errorMessage = "Izin lokasi DITOLAK. Harap berikan izin lokasi di browser/HP Anda.";
                        break;
                    case err.POSITION_UNAVAILABLE:
                        errorMessage = "Posisi LOKASI TIDAK TERSEDIA. Perangkat tidak dapat menentukan lokasi.";
                        break;
                    case err.TIMEOUT:
                        errorMessage = "Waktu habis (TIMEOUT). Tidak dapat mendapatkan lokasi dalam batas waktu 20 detik. Coba lagi di tempat terbuka atau dengan sinyal lebih baik.";
                        break;
                    default:
                        errorMessage = `Terjadi kesalahan tidak terduga: ${err.message}`;
                        break;
                }

                alert(`ERROR: ${errorMessage}`);

                if (infoAlert) {
                    infoAlert.className = 'alert alert-danger';
                    infoAlert.innerHTML = `**Gagal Absen!** ${errorMessage}`;
                }
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Gagal Mendapatkan Lokasi';
                }
            },

            options
        );
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Panggil fungsi lain Anda (updateDateTime, image preview, dll.)
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Panggil fungsi geolokasi
        getGeolocation();
    });
</script>
