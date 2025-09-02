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
        Schema::create('waist_coats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('closure_id')->nullable();
            $table->unsignedBigInteger('v_shape_id')->nullable();
            $table->unsignedBigInteger('pocket_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('closure_id')->references('id')->on('closures');
            $table->foreign('v_shape_id')->references('id')->on('v_shapes');
            $table->foreign('pocket_id')->references('id')->on('pockets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waist_coats');
    }
};