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
        Schema::create('carte_fidelites', function (Blueprint $table) {
            $table->id();
            $table->string('commercial_ID');
            $table->integer('points_sum');
            $table->string('tier');
            $table->string('holder_name')->nullable();
            $table->string('fidelity_program');
            $table->unsignedBigInteger('holder_id');
            $table->unsignedBigInteger('program_id');

            $table->foreign('holder_id')->references('id')->on('clients')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('program_id')->references('id')->on('programs'); 
            //handle a notif where it says  
            // to select and existing program before deleting one with associalted cards
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_fidelites');
    }
};
