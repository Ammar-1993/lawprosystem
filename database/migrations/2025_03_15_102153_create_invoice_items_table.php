<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->double('tax')->nullable()->default('0');
            $table->text('item_description')->nullable();
            $table->integer('iteam_qty')->unsigned();
            $table->text('item_amount');
            $table->text('item_rate');
            $table->text('hsn')->nullable();  
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
        Schema::dropIfExists('invoice_items');
    }
}
