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
        Schema::table('fabrics', function (Blueprint $table) {
            //
            $table->string('color')->nullable();
            $table->string('color_code')->nullable();
            $table->unsignedBigInteger('fabric_design_id')->nullable();
            $table->unsignedBigInteger('fabric_season_id')->nullable();
            $table->unsignedBigInteger('fabric_material_id')->nullable();

            $table->foreign('fabric_design_id')->references('id')->on('fabric_designs')->onDelete('cascade');
            $table->foreign('fabric_season_id')->references('id')->on('fabric_seasons')->onDelete('cascade');
            $table->foreign('fabric_material_id')->references('id')->on('fabric_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fabrics', function (Blueprint $table) {
            //
        });
    }
};