<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasePartiesInvolvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_parties_involves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('court_case_id')->unsigned()->nullable();
            $table->text('position')->nullable();
            $table->text('party_name')->nullable();
            $table->text('party_advocate')->nullable();
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
        Schema::dropIfExists('case_parties_involves');
    }
}
