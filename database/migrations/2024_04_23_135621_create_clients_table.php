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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('money_spent', 10, 2);
            $table->unsignedBigInteger('fidelity_card_id')->nullable();
            $table->string('fidelity_card_commercial_ID')->nullable();
            $table->unsignedBigInteger('company_id'); 

            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('carte_fidelites', function (Blueprint $table) {
            $table->dropForeign(['holder_name']);
        });

        Schema::dropIfExists('clients');
    }
};