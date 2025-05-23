<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('company_name')->nullable();
            $table->text('address')->nullable();
            $table->integer('country')->unsigned();
            $table->integer('state')->unsigned();
            $table->integer('city')->unsigned();
            $table->integer('pincode')->unsigned();
            $table->integer('date_formet')->unsigned();
            $table->text('logo_img')->nullable();
            $table->text('favicon_img')->nullable();
            $table->text('timezone')->nullable();
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
        Schema::dropIfExists('general_setting');
    }
}
