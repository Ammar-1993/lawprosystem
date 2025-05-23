<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_mades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->bigInteger('amount')->default('0');
            $table->date('receiving_date')->nullable();
            $table->enum('payment_type',array('Cash','Cheque','Net Banking','Other'))->default('Cash');
            $table->text('reference_number')->nullable();
            $table->dateTime('cheque_date')->nullable();
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
        Schema::dropIfExists('payment_mades');
    }
}
