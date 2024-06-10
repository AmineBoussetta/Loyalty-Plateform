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
            $table->unsignedBigInteger('carte_fidelite_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->dateTime('transaction_date');
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_spent', 10, 2);
            $table->string('payment_method')->default('cash');
            $table->string('status')->default('amended');
            $table->integer('points')->nullable();
            $table->unsignedBigInteger('company_id'); 
            $table->string('Caissier_ID');
            $table->timestamps();

            $table->foreign('carte_fidelite_id')->references('id')->on('carte_fidelites');
            $table->foreign('client_id')->references('id')->on('clients');
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
