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
            $table->bigInteger('commercial_ID');
            $table->integer('points_sum');
            $table->string('tier');
            $table->string('name');
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
