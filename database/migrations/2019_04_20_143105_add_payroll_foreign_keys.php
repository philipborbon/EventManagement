<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayrollForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payout_deductions', function (Blueprint $table) {
            $table->foreign('payoutid')->references('id')->on('monthly_payouts');
            $table->foreign('type')->references('id')->on('deduction_types');
        });
        

        Schema::table('employee_active_deductions', function (Blueprint $table) {
            $table->foreign('type')->references('id')->on('deduction_types');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payout_deductions', function (Blueprint $table) {
            $table->dropForeign(['payoutid']);
            $table->dropForeign(['type']);
        });
        

        Schema::table('employee_active_deductions', function (Blueprint $table) {
            $table->dropForeign(['type']);
        });        
    }
}
