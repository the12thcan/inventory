<?php

use Illuminate\Database\Seeder;

class ItemTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Item')->insert([
            'name' => 'Yeeterinos',
            'capacity' => 420,
            'quantity'=> 0,
            'low_threshold' => 42,
            'is_food' => 'true',
            'refrigerated' => 'false',
            'created_at' => '2019-10-15 18:01:17',
            'updated_at' => '2019-10-15 18:01:17',
            'removed' => false
        ]);

        DB::table('Item')->insert([
            'name' => 'Yeeteronis',
            'capacity' => 4200,
            'quantity'=> 0,
            'low_threshold' => 420,
            'is_food' => 'true',
            'refrigerated' => 'true',
            'created_at' => '2019-10-16 18:01:17',
            'updated_at' => '2019-10-16 18:01:17',
            'removed' => false
        ]);
    }
}
