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
        // Add column only if it does not already exist (fresh installs already have it)
        if (!Schema::hasColumn('kunjungans', 'jumlah_obat')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->integer('jumlah_obat')->nullable()->after('guru_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop column only if it exists
        if (Schema::hasColumn('kunjungans', 'jumlah_obat')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->dropColumn(['jumlah_obat']);
            });
        }
    }
};
