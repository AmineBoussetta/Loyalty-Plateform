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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->unsignedBigInteger('carte_fidelite_id');
            $table->dateTime('transaction_date');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->timestamps();

            $table->foreign('carte_fidelite_id')->references('id')->on('carte_fidelites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
