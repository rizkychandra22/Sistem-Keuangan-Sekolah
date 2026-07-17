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
        Schema::create('siswa_rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->enum('status', ['aktif', 'lulus', 'mengulang', 'pindah', 'keluar'])->default('aktif');
            $table->enum('hasil_akhir', ['belum_dievaluasi', 'naik', 'tinggal_kelas', 'lulus', 'tidak_lulus'])->default('belum_dievaluasi');
            $table->boolean('is_active')->default(true);
            $table->foreignId('asal_siswa_rombel_id')->nullable()->constrained('siswa_rombels')->nullOnDelete();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'rombel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_rombels');
    }
};
