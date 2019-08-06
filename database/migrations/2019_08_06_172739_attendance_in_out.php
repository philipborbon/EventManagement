<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttendanceInOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('ishalfday');
            $table->dropColumn('overtime');

            $table->time('amin')->nullable();
            $table->time('amout')->nullable();
            $table->time('pmin')->nullable();
            $table->time('pmout')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->boolean('ishalfday');
            $table->double('overtime')->default(0);

            $table->dropColumn('amin');
            $table->dropColumn('amout');
            $table->dropColumn('pmin');
            $table->dropColumn('pmout');
        });
    }
}
