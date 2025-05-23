<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunmToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
             $table->integer('advocate_id')->unsigned()->nullable()->after('id');
             $table->string('first_name')->after('password');
             $table->string('last_name')->after('first_name');
             $table->string('mobile')->after('last_name');
             $table->string('registration_no')->after('mobile');
             $table->string('associated_name')->after('registration_no');
             $table->text('address')->nullable()->after('associated_name');
             $table->integer('city_id')->unsigned()->nullable()->after('address');
             $table->string('zipcode')->nullable()->after('city_id');
             $table->integer('state_id')->unsigned()->nullable()->after('zipcode');
             $table->integer('country_id')->unsigned()->nullable()->after('state_id');
             $table->string('profile_img')->nullable()->after('country_id');
             $table->tinyInteger('is_activated')->default('0')->after('profile_img');
             $table->tinyInteger('is_account_setup')->default('0')->after('is_activated');
             $table->enum('is_user_type',array('SUPERADMIN','ADVOCATE','STAFF'))->default('ADVOCATE')->after('is_account_setup');
             $table->enum('invitation_status',array('accepted','sent'))->default('sent')->after('is_user_type');
             $table->dateTime('accepted_at')->nullable()->after('invitation_status');
             $table->string('current_package')->nullable()->after('accepted_at');
             $table->integer('payment_id')->unsigned()->nullable()->default('0')->after('current_package');
             $table->date('started_at')->nullable()->after('payment_id');
             $table->timestamp('expires_at')->nullable()->after('started_at');
             $table->timestamp('last_login_at')->nullable()->after('expires_at');
             $table->string('last_login_ip')->nullable()->after('last_login_at');
             $table->enum('is_active',array('Yes','No'))->default('Yes')->after('last_login_ip');
             $table->enum('is_expired',array('Yes','No'))->default('No')->after('is_active');
             $table->string('otp')->nullable()->after('is_expired');
             $table->timestamp('otp_date')->nullable()->after('otp');
             $table->enum('is_otp_verify',array('0','1'))->default('0')->after('otp_date');
             $table->enum('plateform',array('App','Web'))->default('Web')->after('is_otp_verify');
             $table->enum('user_type',array('Admin'))->after('plateform');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->integer('advocate_id')->unsigned()->nullable()->after('id');
             $table->string('first_name')->after('password');
             $table->string('last_name')->after('first_name');
             $table->string('mobile')->after('last_name');
             $table->string('registration_no')->after('mobile');
             $table->string('associated_name')->after('registration_no');
             $table->text('address')->nullable()->after('associated_name');
             $table->integer('city_id')->unsigned()->nullable()->after('address');
             $table->string('zipcode')->nullable()->after('city_id');
             $table->integer('state_id')->unsigned()->nullable()->after('zipcode');
             $table->integer('country_id')->unsigned()->nullable()->after('state_id');
             $table->string('profile_img')->nullable()->after('country_id');
             $table->tinyInteger('is_activated')->default('0')->after('profile_img');
             $table->tinyInteger('is_account_setup')->default('0')->after('is_activated');
             $table->enum('is_user_type',array('SUPERADMIN','ADVOCATE','STAFF'))->default('ADVOCATE')->after('is_account_setup');
             $table->enum('invitation_status',array('accepted','sent'))->default('sent')->after('is_user_type');
             $table->dateTime('accepted_at')->nullable()->after('invitation_status');
             $table->string('current_package')->nullable()->after('accepted_at');
             $table->integer('payment_id')->unsigned()->nullable()->default('0')->after('current_package');
             $table->date('started_at')->nullable()->after('payment_id');
             $table->timestamp('expires_at')->nullable()->after('started_at');
             $table->timestamp('last_login_at')->nullable()->after('expires_at');
             $table->string('last_login_ip')->nullable()->after('last_login_at');
             $table->enum('is_active',array('Yes','No'))->default('Yes')->after('last_login_ip');
             $table->enum('is_expired',array('Yes','No'))->default('No')->after('is_active');
             $table->string('otp')->nullable()->after('is_expired');
             $table->timestamp('otp_date')->nullable()->after('otp');
             $table->enum('is_otp_verify',array('0','1'))->default('0')->after('otp_date');
             $table->enum('plateform',array('App','Web'))->default('Web')->after('is_otp_verify');
             $table->enum('user_type',array('Admin'))->after('plateform');
        });
    }
}
