<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use EventManagement\EventParticipant;

class UserAccountEventParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_participants', function (Blueprint $table) {
            EventParticipant::truncate();

            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('age');
            $table->dropColumn('sex');
            $table->dropColumn('address');

            $table->integer('userid')->unsigned();
            $table->boolean('accepted')->default(false);
            $table->boolean('denied')->default(false);

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
        Schema::table('event_participants', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('age')->unsigned();
            $table->enum('sex', ['F', 'M'])->nullable();
            $table->text('address')->nullable();

            $table->dropForeign(['userid']);
            $table->dropColumn('userid');
            $table->dropColumn('accepted');
            $table->dropColumn('denied');
        });
    }
}
