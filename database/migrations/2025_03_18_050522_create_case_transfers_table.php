<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('court_case_id')->unsigned();
            $table->integer('from_judge_type')->unsigned();
            $table->integer('to_judge_type')->unsigned();
            $table->text('from_court_no')->nullable();
            $table->text('to_court_no');
            $table->text('judge_name')->nullable();
            $table->dateTime('transfer_date');
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
        Schema::dropIfExists('case_transfers');
    }
}
