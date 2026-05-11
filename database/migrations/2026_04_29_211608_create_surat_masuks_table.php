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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('no_agenda')->unique();
            $table->string('no_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->time('waktumulai')->nullable();
            $table->time('waktuselesai')->nullable();
            $table->string('asal_surat');
            $table->text('disposisikan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('perihal');
            $table->enum('sifat', ['biasa', 'penting', 'rahasia', 'sangat_rahasia'])->default('biasa');
            $table->enum('klasifikasi', ['umum', 'internal', 'eksternal'])->default('umum');
            $table->string('lampiran')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_surat')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
