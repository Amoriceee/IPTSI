<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePipeProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipe_productions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('pipe_id')->unsigned();;
            $table->integer('quantity');
            $table->date('production_date');
            $table->unsignedBigInteger('user_id')->unsigned();;
            $table->timestamps();
        });
        Schema::table('pipe_productions', function($table) {
          $table->foreign('pipe_id')->references('id')->on('pipes');
          $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('pipe_productions');
    }
}
