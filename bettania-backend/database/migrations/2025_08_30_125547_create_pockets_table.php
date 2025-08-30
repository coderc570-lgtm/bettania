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
        Schema::create('pockets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('custom_made_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('filepath')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pockets');
    }
};