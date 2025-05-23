<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rel_type');
            $table->integer('rel_id')->unsigned();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('project_type_task_id')->unsigned()->nullable();
            $table->string('task_subject');
            $table->string('project_status');
            $table->string('priority');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->text('checklist_complete_remarks')->nullable();
            $table->text('checklist_complete_signature')->nullable();
            $table->enum('is_active',array('Yes','No'))->default('Yes');
            $table->text('critical_comment')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
