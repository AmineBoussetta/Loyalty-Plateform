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
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
