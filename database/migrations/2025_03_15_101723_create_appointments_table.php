<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('advocate_id')->unsigned()->nullable();
            $table->enum('type',array('new','exists'))->default('new');
            $table->date('date');
            $table->time('time');
            $table->string('mobile');
            $table->string('name')->nullable();
            $table->text('note')->nullable();
            $table->enum('is_active',array('OPEN','CANCEL BY CLIENT','CANCEL BY ADVOCA'))->default('OPEN');
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
        Schema::dropIfExists('appointments');
    }
}
