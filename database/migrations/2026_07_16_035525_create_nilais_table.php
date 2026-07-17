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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->index(['siswa_rombel_id', 'mapel_id']);
            $table->foreignId('siswa_rombel_id')->constrained('siswa_rombels')->onDelete('cascade');
            $table->foreignId('guru_mapel_id')->constrained('guru_mapels')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->decimal('nilai', 5, 2);
            $table->enum('jenis_nilai', ['tugas', 'uts', 'uas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
