<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Item', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('name');
            $table->integer('quantity');
            $table->integer('capacity');
            $table->integer('low_threshold');
            $table->boolean('is_food');
            $table->boolean('refrigerated');
            $table->boolean('removed');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
            $table->unique(['name', 'is_food', 'refrigerated', 'removed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
