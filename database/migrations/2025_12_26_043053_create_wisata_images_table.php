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
        Schema::create('wisata_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tempat_wisata_id');
            $table->string('path');
            $table->text('caption')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->uuid('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('tempat_wisata_id')->references('id')->on('tempat_wisatas')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata_images');
    }
};
