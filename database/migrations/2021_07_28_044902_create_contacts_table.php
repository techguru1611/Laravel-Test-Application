<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_numbers');
            $table->string('email')->unique();
            $table->bigInteger('organization_id')->unsigned();
            $table->date('dob');
            $table->tinyInteger('is_email_verified')->default(0)->comment('0-not verified, 1- verified');
            $table->timestamps();
        });

        Schema::table('contacts', function($table) {
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
