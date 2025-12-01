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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            $table->dateTime('date');

            $table->enum('status', ['hadir','izin','sakit','alpha'])->default('alpha');
            
            // Path foto presensi
            $table->string('foto');

            // Tambahan koordinat lokasi
            $table->string('latitude')->nullable();  // contoh: -7.123456
            $table->string('longitude')->nullable(); // contoh: 110.987654

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
