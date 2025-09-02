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
            $table->string('fabric_code')->nullable();
            $table->string('composition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fabrics', function (Blueprint $table) {
            //
            $table->dropColumn(['fabric_code', 'composition']);
            
        });
    }
};