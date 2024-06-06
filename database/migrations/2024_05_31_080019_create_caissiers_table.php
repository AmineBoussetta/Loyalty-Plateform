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
        Schema::create('caissiers', function (Blueprint $table) {
            $table->id();
            $table->string('Caissier_ID')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('company_id');


            $table->foreign('company_id')->references('company_id')->on('gerants')->onDelete('cascade');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_caissiers');
    }
};
