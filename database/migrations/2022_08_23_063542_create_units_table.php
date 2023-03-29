<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('unit_phone');
            $table->string('street');
            $table->unsignedBigInteger('city');
            $table->unsignedBigInteger('state');
            $table->unsignedBigInteger('country');
            $table->string('unit_code');
            $table->unsignedMediumInteger('zipcode')->length(5);
            $table->boolean('status');
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
        Schema::dropIfExists('units');
    }
}
