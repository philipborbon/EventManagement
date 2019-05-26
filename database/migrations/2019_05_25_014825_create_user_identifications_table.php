<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_identifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('documenttypeid')->unsigned();
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('documenttypeid')->references('id')->on('document_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_identifications');
    }
}
