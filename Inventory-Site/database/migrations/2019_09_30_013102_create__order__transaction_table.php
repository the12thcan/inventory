<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Order_Transaction', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('item_quantity_change');
            $table->string('comment')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
//            $table->foreign('member_id')->references('id')->on('users');
//            $table->foreign('item_id')->references('id')->on('Item');
        });

//        Schema::enableForeignKeyConstraints();

//        Schema::table('User', function(Blueprint $table){
//            $table->foreign('member_id')->references('id')->on('User');
//            $table->foreign('item_id')->references('id')->on('Item');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_order__transaction');
    }
}
