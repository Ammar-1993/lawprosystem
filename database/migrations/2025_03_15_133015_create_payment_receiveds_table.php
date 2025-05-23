<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receiveds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('receipt_number')->unsigned()->nullable();
            $table->bigInteger('amount');
            $table->dateTime('receiving_date');
            $table->enum('payment_type',array('Cash','Cheque','Net Banking','Other'))->default('Cash');
            $table->dateTime('cheque_date')->nullable();
            $table->text('reference_number')->nullable();
            $table->text('note')->nullable();
            $table->integer('payment_received_by')->unsigned();
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
        Schema::dropIfExists('payment_receiveds');
    }
}
