<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    public $table = 'Order_Transaction'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = false; // timestamps

    public function Transaction()
    {
        // Define the table relationships
        $this->belongsTo('App\User');
        $this->belongsTo('App\Item');

//        $this->$table->foreign('user_id')->references('id')->on('users');
//        $this->$table->foreign('item_id')->references('id')->on('Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User', "member_id");
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    /**
     * Allows us to get the current quantity for an item in the database.
     *
     * @param $itemId The id of the item we are trying to get the current quantity for.
     */
    public function quantity($itemId)
    {
        $quantity = DB::table('Order_Transaction')
            ->sum('item_quantity_change')
            ->where('item_id', $itemId);

        return $quantity;
    }
}
