<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'firstname');
            $table->string('lastname');
            $table->enum('usertype', ['employee', 'investor', 'participants']);
            $table->integer('age')->unsigned();
            $table->text('address');
            $table->enum('sex', ['F', 'M']);
            $table->enum('maritalstatus', ['single', 'married', 'divorced', 'separated', 'widowed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            $table->renameColumn('firstname', 'name');
            $table->dropColumn('lastname');
            $table->dropColumn('usertype');
            $table->dropColumn('age');
            $table->dropColumn('address');
            $table->dropColumn('sex');
            $table->dropColumn('maritalstatus');
    }
}
