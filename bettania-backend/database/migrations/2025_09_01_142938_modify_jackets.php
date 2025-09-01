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
        Schema::table('jackets', function (Blueprint $table) {
            //
            $table->dropColumn(['title', 'description', 'filepath']);
            $table->unsignedBigInteger('closure_id')->nullable();
            $table->unsignedBigInteger('button_id')->nullable();
            $table->unsignedBigInteger('pocket_id')->nullable();
            $table->unsignedBigInteger('fabric_id')->nullable();
            $table->unsignedBigInteger('lapel_id')->nullable();            
            
            $table->foreign('closure_id')->references('id')->on('closures');
            $table->foreign('button_id')->references('id')->on('buttons');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->foreign('fabric_id')->references('id')->on('fabrics');
            $table->foreign('lapel_id')->references('id')->on('lapels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jackets', function (Blueprint $table) {
            //
            $table->dropForeign(['closure_id']);
            $table->dropForeign(['button_id']);
            $table->dropForeign(['pocket_id']);
            $table->dropForeign(['fabric_id']);
            $table->dropForeign(['lapel_id']);

            $table->dropColumn(['closure_id', 'button_id', 'pocket_id', 'fabric_id', 'lapel_id']);  
            
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('filepath')->nullable();
        });
    }
};