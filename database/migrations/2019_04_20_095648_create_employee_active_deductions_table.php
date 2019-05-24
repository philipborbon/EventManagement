<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeActiveDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_active_deductions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('type')->unsigned();
            $table->boolean('isActive');
            $table->timestamps();
            
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_active_deductions');
    }
}
