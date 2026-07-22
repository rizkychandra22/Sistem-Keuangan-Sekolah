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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_rombel_id')->constrained('siswa_rombels')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alfa']);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_rombel_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
