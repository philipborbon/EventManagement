<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activityid')->unsigned();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('age')->unsigned();
            $table->enum('sex', ['F', 'M'])->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('activityid')->references('id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participants');
    }
}
