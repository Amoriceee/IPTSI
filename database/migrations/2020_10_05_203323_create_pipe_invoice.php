<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePipeInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipe_invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('invoice_id')->unsigned();
            $table->unsignedBigInteger('pipe_id')->unsigned();
            $table->integer('quantity');
            $table->integer('rate');
            $table->boolean('loaded');
            $table->timestamps();

        });
        Schema::table('pipe_invoices', function($table) {
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('pipe_id')->references('id')->on('pipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pipe_invoices');
    }
}
