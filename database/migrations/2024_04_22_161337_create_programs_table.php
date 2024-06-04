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
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('points', 8, 2)->nullable();
            $table->decimal('minimum_amount', 8, 2)->nullable();
            $table->decimal('amount_premium', 8, 2)->nullable();
            $table->integer('points_premium')->nullable();
            $table->decimal('minimum_amount_premium', 8, 2)->nullable();
            $table->decimal('conversion_factor', 8, 2)->nullable();
            $table->unsignedBigInteger('company_id'); 


            $table->string('status');
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
