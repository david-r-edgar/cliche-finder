<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicheOfTheDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliche_of_the_day', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('cliche_id')->nullable()->unsigned();
            $table->foreign('cliche_id')->references('id')->on('cliches');
            $table->date('date')->nullable();
            $table->text('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliche_of_the_day');
    }
}
