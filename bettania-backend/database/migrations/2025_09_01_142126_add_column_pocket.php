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
        Schema::table('pockets', function (Blueprint $table) {
            //
            $table->unsignedInteger('pocket_type_id')->nullable();
            $table->foreign('pocket_type_id')->references('id')->on('pocket_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pockets', function (Blueprint $table) {
            //
            $table->dropForeign(['pocket_type_id']);
            $table->dropColumn('pocket_type_id');
        });
    }
};