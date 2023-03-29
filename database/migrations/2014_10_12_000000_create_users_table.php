<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDelete;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('user_status', ['Active', 'Inactive'])->default('Active');
            $table->integer('Role')->nullable();
            $table->string('Image')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Country')->nullable();
            $table->string('State')->nullable();
            $table->string('city')->nullable();
            $table->text('Address')->nullable();
            $table->string('usertype')->nullable();
            $table->integer('unit_id');
            $table->integer('company_id');
            $table->integer('department_id');
            $table->string('emp_code');
            $table->rememberToken();
            $table->softDeletes();
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
