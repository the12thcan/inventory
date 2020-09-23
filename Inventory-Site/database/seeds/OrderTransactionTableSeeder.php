<?php

use Illuminate\Database\Seeder;

class OrderTransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Order_Transaction')->insert([
            'member_id' => 1,
            'item_id'=> 1,
            'item_quantity_change' => 69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);

        DB::table('Order_Transaction')->insert([
            'member_id' => 1,
            'item_id'=> 2,
            'item_quantity_change' => -69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);

        DB::table('Order_Transaction')->insert([
            'member_id' => 1,
            'item_id'=> 2,
            'item_quantity_change' => 69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);

        DB::table('Order_Transaction')->insert([
            'member_id' => 1,
            'item_id'=> 1,
            'item_quantity_change' => 69,
            'comment' => 'Nice',
            'transaction_date' => '2019-10-16 18:01:17'
        ]);
    }
}
