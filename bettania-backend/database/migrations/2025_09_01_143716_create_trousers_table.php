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
        Schema::create('trousers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waist_band_id')->nullable();
            $table->unsignedBigInteger('pleat_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('waist_band_id')->references('id')->on('waist_bands');
            $table->foreign('pleat_id')->references('id')->on('pleats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trousers');
    }
};