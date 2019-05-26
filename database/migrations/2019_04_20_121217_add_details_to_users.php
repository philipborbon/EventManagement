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
            $table->enum('usertype', ['admin', 'employee', 'investor']);
            $table->integer('age')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->enum('sex', ['F', 'M'])->nullable();
            $table->enum('maritalstatus', ['single', 'married', 'divorced', 'separated', 'widowed'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement('ALTER TABLE users CHANGE firstname name VARCHAR(255)');
            $table->dropColumn('lastname');
            $table->dropColumn('usertype');
            $table->dropColumn('age');
            $table->dropColumn('address');
            $table->dropColumn('sex');
            $table->dropColumn('maritalstatus');
        });
    }
}
