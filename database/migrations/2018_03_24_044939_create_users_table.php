<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users')){
            Schema::table('users', function (Blueprint $table) {
                $table->increments('user_id');
                $table->timestamps();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->integer('mobno')->unsigned();
                $table->string('password');
                $table->string('college');
            });
        } else {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('user_id');
                $table->timestamps();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->integer('mobno')->unsigned();
                $table->string('password');
                $table->string('college');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
