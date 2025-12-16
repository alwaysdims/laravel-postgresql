<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // Tanggal presensi (1 record per hari)
            $table->date('date');

            // ABSEN MASUK
            $table->timestamp('check_in_time')->nullable();
            $table->string('check_in_photo')->nullable();
            $table->string('check_in_latitude')->nullable();
            $table->string('check_in_longitude')->nullable();

            // ABSEN PULANG
            $table->timestamp('check_out_time')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->string('check_out_latitude')->nullable();
            $table->string('check_out_longitude')->nullable();

            // status: hadir/izin/sakit/alpha
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');

            $table->timestamps();

            // Untuk memastikan 1 siswa hanya punya 1 presensi per hari
            $table->unique(['student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
