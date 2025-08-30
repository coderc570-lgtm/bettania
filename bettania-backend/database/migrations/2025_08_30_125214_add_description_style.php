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
        Schema::table('styles', function (Blueprint $table) {
            //
            $table->text('description')->nullable();
            $table->unsignedBigInteger('custom_made_id')->nullable();
            $table->foreign('custom_made_id')->references('id')->on('custom_mades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('styles', function (Blueprint $table) {
            //
            $table->dropForeign(['custom_made_id']);
            $table->dropColumn(['description', 'custom_made_id']);
        });
    }
};