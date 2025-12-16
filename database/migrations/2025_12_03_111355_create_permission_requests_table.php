<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // jenis izin
            $table->enum('type', ['izin', 'sakit']);

            // rentang tanggal
            $table->date('start_date');
            $table->date('end_date')->nullable(); // jika izin cuma 1 hari, end_date = start_date

            // alasan siswa
            $table->text('reason')->nullable();

            // bukti lampiran: foto / surat dokter / surat orang tua
            $table->string('attachment')->nullable();

            // status approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // catatan dari guru pembimbing / admin
            $table->text('note')->nullable();

            $table->date('approval_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_requests');
    }
};
