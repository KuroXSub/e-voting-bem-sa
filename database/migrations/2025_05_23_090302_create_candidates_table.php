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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chairman_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vice_chairman_id')->constrained('users')->cascadeOnDelete();
            $table->string('number');
            $table->text('vision');
            $table->text('mission');
            $table->string('photo_url')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
