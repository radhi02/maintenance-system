<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_master', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueid');
            $table->unsignedBigInteger('equipment_id');
            $table->string('Problem');
            $table->dateTime('ticket_date')->nullable();
            $table->string('criticality');
            $table->string('ticket_status');
            $table->integer('created_by')->nullable();
            $table->enum('frequancy', ['Daily','Weekly','Monthly','Quarterly','Half Yearly','Yearly']);
            $table->enum('tasktype', ['minor', 'major']);
            $table->enum('maintenance_type', ['Preventive', 'Reactive']);
            $table->date('start_date')->nullable();
            $table->date('plan_date')->nullable();
            $table->integer('assigned_to_userid')->nullable();
            $table->string('loss_hrs');
            $table->string('service_cost_external_vendor');
            $table->integer('actual_done_by')->nullable();
            $table->dateTime('actual_start_date')->nullable();
            $table->dateTime('actual_end_date')->nullable();
            $table->enum('plan_status', ['Active', 'In-Active'])->default('In-Active')->nullable();
            $table->text('remark_by_enginner')->nullable();
            $table->text('remark_by_manager')->nullable();
            $table->text('worknote')->nullable();
            // $table->enum('enginner_status', ['Pending', 'Completed'])->default('Pending');
            $table->text('done_task_list')->nullable();
            $table->text('task_json')->nullable();
            $table->integer('enduser_id')->nullable();
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
        Schema::dropIfExists('plan_master');
    }
}
