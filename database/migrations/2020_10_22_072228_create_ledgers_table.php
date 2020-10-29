<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->unsigned();
            $table->date('payment_date');
            $table->integer('amount');
            $table->string('payment_type');
            $table->string('cd');
            $table->unsignedBigInteger('recieved_by')->unsigned();
            $table->timestamps();
        });
        Schema::table('ledgers', function($table) {
          $table->foreign('client_id')->references('id')->on('clients');
          $table->foreign('recieved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
