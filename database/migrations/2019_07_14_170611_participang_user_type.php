<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipangUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE `users` CHANGE `usertype` `usertype` ENUM('admin', 'employee', 'investor', 'participant') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
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
            DB::statement("ALTER TABLE `users` CHANGE `usertype` `usertype` ENUM('admin', 'employee', 'investor') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        });
    }
}
