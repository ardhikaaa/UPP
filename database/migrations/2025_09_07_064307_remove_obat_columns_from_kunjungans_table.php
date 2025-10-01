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
        Schema::table('kunjungans', function (Blueprint $table) {
            // Drop foreign key and column obat_id if present
            if (Schema::hasColumn('kunjungans', 'obat_id')) {
                // Laravel's conventionally generated key name: kunjungans_obat_id_foreign
                try {
                    $table->dropForeign(['obat_id']);
                } catch (\Throwable $ignored) {
                    // ignore if foreign key not present
                }
                try {
                    $table->dropColumn('obat_id');
                } catch (\Throwable $ignored) {
                    // ignore if already dropped
                }
            }

            // Drop jumlah_obat if present
            if (Schema::hasColumn('kunjungans', 'jumlah_obat')) {
                try {
                    $table->dropColumn('jumlah_obat');
                } catch (\Throwable $ignored) {
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Add back columns only if missing
            if (!Schema::hasColumn('kunjungans', 'obat_id')) {
                $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            }
            if (!Schema::hasColumn('kunjungans', 'jumlah_obat')) {
                $table->integer('jumlah_obat');
            }
        });
    }
};
