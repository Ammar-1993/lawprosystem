<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('court_case_id')->unsigned();
            $table->integer('judge_type')->unsigned();
            $table->integer('case_status')->unsigned()->nullable();
            $table->text('court_no')->nullable();
            $table->text('judge_name')->nullable();
            $table->dateTime('bussiness_on_date')->nullable();
            $table->dateTime('hearing_date')->nullable();
            $table->text('remark')->nullable();
            $table->enum('is_transfer',array('Yes','No'))->default('No');
            $table->integer('transfer_judge_type')->unsigned()->nullable();
            $table->text('transfer_court_no')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('case_logs');
    }
}
