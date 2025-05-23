<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->text('case_status_name')->nullable();
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
        Schema::dropIfExists('case_statuses');
    }
}
