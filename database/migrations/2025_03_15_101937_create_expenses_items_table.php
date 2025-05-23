<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->integer('invoice_id')->unsigned();         
            $table->integer('tax_id')->unsigned()->nullable();
            $table->double('tax')->nullable()->default('0');
            $table->text('category_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('iteam_qty')->unsigned();
            $table->text('item_amount');
            $table->text('item_rate');
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
        Schema::dropIfExists('expenses_items');
    }
}
