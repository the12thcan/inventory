<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('phone');
            $table->boolean('current_member')->nullable();
            $table->integer('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('Member_Position');
        });

        Schema::enableForeignKeyConstraints();

//        Schema::table('User', function(Blueprint $table){
//            $table->foreign('position_id')->references('id')->on('Member_Position');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
