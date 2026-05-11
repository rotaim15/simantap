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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 60);
            $table->string('email')->nullable()->unique();
            $table->string('no_tlp', 15)->nullable();
            $table->text('jabatan')->nullable();
            $table->text('instansi')->nullable();
            $table->enum('tipe', ['internal', 'external'])->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
