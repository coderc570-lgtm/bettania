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
        Schema::table('closures', function (Blueprint $table) {
            //
            $table->unsignedInteger('closure_type_id')->nullable();
            $table->foreign('closure_type_id')->references('id')->on('closure_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closures', function (Blueprint $table) {
            //
            $table->dropForeign(['closure_type_id']);
            $table->dropColumn('closure_type_id');
        });
    }
};