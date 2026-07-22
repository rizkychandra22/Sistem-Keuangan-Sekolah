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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->date('tgl_lhr');
            $table->text('alamat')->nullable();
            $table->string('orang_tua');
            $table->string('kontak_orang_tua')->nullable();
            $table->enum('status_akademik', ['aktif', 'lulus', 'keluar', 'pindah'])->default('aktif');
            $table->boolean('is_active')->default(true);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
