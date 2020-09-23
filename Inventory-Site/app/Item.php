<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    protected $table = 'Item'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps

    /**
     * Class constructor
     */
    public function Item()
    {
        // Set the database relationship
        $this->hasMany('App\Transaction');
    }

    /**
     * Gets the current quantity of the item for this model.
     * @return The current quantity of the item.
     */
    public function quantity()
    {
        $quantity = DB::table('Order_Transaction')
            ->where('item_id', $this->id)
            ->sum('item_quantity_change');
        return $quantity;
    }

    /**
     * Gets the current quantity of the item specified.
     * @param $id The ID of the item we need the quantity for.
     * @return The current quantity of the item.
     */
    public function getQuantity($id)
    {
        $quantity = DB::table('Order_Transaction')
            ->where('item_id', $this->id)
            ->sum('item_quantity_change');
        return $quantity;
    }

    /**
     * Scope function to only get items that are food from the database
     * @param $query The query we need to modify scope
     * @return mixed The query where we have added the condition that we are only getting food items
     */
    public function scopeFoodItem($query)
    {
        return $query->where('is_food', true);
    }

    /**
     * Scope function to only get items that haven't been deleted from the database.
     * @param $query The query we need to modify scope
     * @return mixed The query where we have added the condition that we are only getting items that haven't been deleted
     */
    public function scopeNotRemoved($query)
    {
        return $query->where('removed', false);
    }

    /**
     * Scope function to only get items that need to be refrigerated.
     * @param $query The query we need to modify scope
     * @return mixed The query where we have added the condition that we are only getting items that need to be refrigerated.
     */
    public function scopeRefrigerated($query)
    {
        return $query->where('refrigerated', false);
    }

    /**
     * Scope function to get all items that currently have quantities lower than their threshold. This means
     * that these items should be restocked.
     * @param $query The query we need to modify scope
     * @return mixed The query where we have added the condition that we are getting all items that need restocking.
     */
    public function scopeLowQuantity($query)
    {
        return $query->where('quantity', '<', 'low_threshold');
    }
}
