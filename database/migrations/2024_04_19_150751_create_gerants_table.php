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
        Schema::create('gerants', function (Blueprint $table) {
            $table->id();
            $table->string('fullName',70);
            $table->string('email',70)->unique();
            $table->integer('telephone');
            $table->string('password',60);
            $table->string('nom_organisme',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerants');
    }
};
