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
        Schema::create('tempat_fasilitas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tempat_wisata_id');
            $table->uuid('fasilitas_id');
            $table->uuid('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('tempat_wisata_id')->references('id')->on('tempat_wisatas')->cascadeOnDelete();
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_fasilitas');
    }
};
