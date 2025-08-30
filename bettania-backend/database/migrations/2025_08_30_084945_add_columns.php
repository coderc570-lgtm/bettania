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
        Schema::table('internal_linings', function (Blueprint $table) {
            //
            $table->text('upper_filepath')->nullable();
            $table->text('lower_filepath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internal_linings', function (Blueprint $table) {
            //
            $table->dropColumn([
                'upper_filepath',
                'lower_filepath',
            ]);
        });
    }
};