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
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('paralel', 5);
            $table->string('nama');
            $table->string('kode')->unique();
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->nullOnDelete();
            $table->unsignedSmallInteger('kapasitas')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['tahun_ajaran_id', 'kelas_id', 'paralel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
