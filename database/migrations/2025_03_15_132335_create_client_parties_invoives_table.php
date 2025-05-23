<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPartiesInvoivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_parties_invoives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('advocate_id')->unsigned()->nullable();
            $table->text('party_firstname')->nullable();
            $table->text('party_middlename')->nullable();
            $table->text('party_lastname')->nullable();
            $table->text('party_mobile')->nullable();
            $table->text('party_address')->nullable();
            $table->text('party_advocate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_parties_invoives');
    }
}
