<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('abbreviation'); // Add abbreviation field
        $table->string('default_currency'); // Add default_currency field
        $table->string('country'); // Add country field
        $table->string('tax_id'); // Add tax_id field
        $table->string('managers'); // Add managers field
        $table->string('phone'); // Add phone field
        $table->string('email')->unique();
        $table->string('website')->nullable(); // Add website field
        $table->text('description')->nullable(); // Add description field
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
