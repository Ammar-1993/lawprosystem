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
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->text('invoice_no');
            $table->text('sub_total_amount');
            $table->text('tax_amount')->nullable();
            $table->text('total_amount');
            $table->enum('inv_status',array('Due','Partially Paid','Paid'))->default('Due');
            $table->date('due_date');
            $table->date('inv_date');
            $table->text('remarks')->nullable();
            $table->string('tax_type')->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->text('json_content')->nullable();
            $table->integer('invoice_created_by')->unsigned();
            $table->enum('is_active',array('Yes','No'))->default('Yes');
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
        Schema::dropIfExists('invoices');
    }
}
