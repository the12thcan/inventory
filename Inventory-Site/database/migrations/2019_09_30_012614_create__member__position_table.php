<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Member_Position', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('position');
            $table->integer('privilege');
            $table->string('description');
            $table->string('email')->unique()->index();
            $table->boolean('low_notify')->default(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_member__position');
    }
}
