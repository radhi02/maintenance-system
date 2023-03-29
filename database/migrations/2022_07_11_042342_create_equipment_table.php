<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('equipment_code');
            $table->string('serial_no');
            $table->string('equipment_make');
            $table->string('equipment_capacity');
            $table->string('location');
            $table->string('purchase_date');
            $table->string('purchase_cost');
            $table->string('warranty_date');
            $table->string('invoiceFile');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->enum('equipment_status', ['Active', 'In-Active'])->default('In-Active');
            $table->enum('warranty_status', ['Warranty', 'AMC Contract', 'Out of Warranty/AMC Contract'])->default('In-Active');
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
        Schema::dropIfExists('equipment');
    }
}
