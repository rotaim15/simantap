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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 30);
            $table->string('kode_disposisi')->unique();
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuks')->onDelete('cascade');
            $table->foreignId('surat_keluar_id')
                ->nullable()
                ->constrained('surat_keluars')
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_disposisi');
            $table->date('batas_waktu')->nullable();
            $table->text('instruksi');
            $table->text('catatan')->nullable();
            $table->enum('prioritas', ['rendah', 'normal', 'tinggi', 'segera'])->default('normal');
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });

        Schema::create('disposisi_penerima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disposisi_id')->constrained('disposisi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['belum_dibaca', 'dibaca', 'diproses', 'selesai'])->default('belum_dibaca');
            $table->text('tanggapan')->nullable();
            $table->timestamp('dibaca_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();

            $table->unique(['disposisi_id', 'user_id']);
        });

        Schema::create('disposisi_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disposisi_id')->constrained('disposisi')->onDelete('cascade');
            $table->string('tindakan');
            $table->boolean('is_checked')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi_tindakan');
        Schema::dropIfExists('disposisi_penerima');
        Schema::dropIfExists('disposisi');
    }
};
