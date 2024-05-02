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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('tier');
            $table->decimal('amount', 8, 2)->nullable();
            $table->integer('points')->nullable();
            $table->string('status');
            $table->decimal('minimum_amount', 8, 2)->nullable();
            $table->decimal('conversion_factor', 8, 2)->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
