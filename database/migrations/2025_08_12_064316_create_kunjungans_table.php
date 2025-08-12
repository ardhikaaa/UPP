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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade'); // relasi utama
            $table->string('diagnosa');
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->date('tanggal');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->integer('jumlah_obat');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
