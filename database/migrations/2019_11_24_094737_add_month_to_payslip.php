<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthToPayslip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_payouts', function (Blueprint $table) {
            $table->date('month')->nullable();
            $table->integer('totaldays')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_payouts', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->dropColumn('totaldays');
        });
    }
}
