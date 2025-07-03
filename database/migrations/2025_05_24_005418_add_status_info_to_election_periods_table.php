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
        Schema::table('election_periods', function (Blueprint $table) {
            $table->enum('status', [
                'Non-aktif',
                'Belum dimulai', 
                'Sedang Berlangsung',
                'Telah Selesai'
            ])->default('Non-aktif')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('election_periods', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
