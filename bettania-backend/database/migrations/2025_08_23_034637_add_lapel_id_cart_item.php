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
        Schema::table('cart_items', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('lapel_id')->nullable();
            $table->foreign('lapel_id')->references('id')->on('lapels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            //
            $table->dropForeign(['lapel_id']);
            $table->dropColumn('lapel_id');
        });
    }
};