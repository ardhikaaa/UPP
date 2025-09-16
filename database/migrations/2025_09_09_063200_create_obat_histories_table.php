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
        Schema::create('obat_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->integer('jumlah'); // jumlah obat keluar/masuk
            $table->enum('tipe', ['masuk', 'keluar']); // stok masuk atau stok keluar
            $table->date('tanggal'); // tanggal perubahan
            $table->string('keterangan')->nullable(); // catatan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_histories');
    }
};
