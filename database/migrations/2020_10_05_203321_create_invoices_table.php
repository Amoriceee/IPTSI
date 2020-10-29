<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->boolean('authorised');
            $table->boolean('loaded');
            $table->date('invoice_date');
            $table->date('delivery_date');
            $table->timestamps();
        });
        Schema::table('invoices', function($table) {
          $table->foreign('client_id')->references('id')->on('clients');
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
      Schema::dropIfExists('invoices');
    }
}
