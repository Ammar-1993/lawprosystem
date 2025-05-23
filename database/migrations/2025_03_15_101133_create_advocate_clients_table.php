<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvocateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advocate_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->enum('gender',array('Male','Female'));
            $table->string('email');
            $table->string('mobile');
            $table->string('alternate_no')->nullable();
            $table->text('address');
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->text('reference_name')->nullable();
            $table->text('reference_mobile')->nullable();
            $table->enum('is_active',array('Yes','No'))->default('Yes');
            $table->enum('client_type',array('single','multiple'));
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
        Schema::dropIfExists('advocate_clients');
    }
}
