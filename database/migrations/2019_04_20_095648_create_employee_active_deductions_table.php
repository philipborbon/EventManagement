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
            $table->integer('typeid')->unsigned();
            $table->double('amount')->default(0);
            $table->timestamps();
            
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('typeid')->references('id')->on('deduction_types')->onDelete('cascade');
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
