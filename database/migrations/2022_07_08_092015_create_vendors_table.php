<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('vendor_code');
            $table->string('vendor_contactperson');
            $table->string('vendor_email');
            $table->string('vendor_phone');
            $table->string('vendor_street');
            $table->unsignedBigInteger('vendor_city');
            $table->unsignedBigInteger('vendor_state');
            $table->unsignedBigInteger('vendor_country');
            $table->unsignedMediumInteger('vendor_zipcode')->length(5);
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');;
            $table->boolean('vendor_status');
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
        Schema::dropIfExists('vendors');
    }
}
