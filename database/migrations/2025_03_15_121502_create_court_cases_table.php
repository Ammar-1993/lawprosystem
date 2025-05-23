<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advocate_id')->unsigned();
            $table->integer('advo_client_id')->unsigned();
            $table->enum('client_position',array('Respondent','Petitioner'));
            $table->text('party_name');
            $table->text('party_lawyer');
            $table->text('case_number')->nullable();
            $table->integer('case_types')->unsigned();
            $table->integer('case_sub_type')->unsigned()->nullable();
            $table->integer('case_status')->unsigned();
            $table->text('act')->nullable();
            $table->enum('priority',array('High','Medium','Low'))->default('Low');
            $table->text('court_no');
            $table->integer('court_type')->unsigned();
            $table->integer('court')->unsigned();
            $table->integer('judge_type')->unsigned();
            $table->text('judge_name')->nullable();
            $table->text('filing_number');
            $table->dateTime('filing_date');
            $table->text('registration_number');
            $table->dateTime('registration_date');
            $table->text('remark')->nullable();
            $table->text('description')->nullable();
            $table->text('cnr_number')->nullable();
            $table->date('first_hearing_date')->nullable();
            $table->dateTime('next_date')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->text('police_station')->nullable();
            $table->text('fir_number')->nullable();
            $table->date('fir_date')->nullable();
            $table->enum('is_nb',array('Yes','No'))->default('No');
            $table->date('decision_date')->nullable();
            $table->text('nature_disposal')->nullable();
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
        Schema::dropIfExists('court_cases');
    }
}
