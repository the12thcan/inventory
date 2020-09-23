<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Item;
use Notification;
use App\Notifications\ThresholdEmail;
use Illuminate\Support\Facades\DB;
use App\Member_Position;

class TransactionsController extends Controller
{

    /**
     * Store a newly created resource in storage. Is used to input a new transaction into the
     * database.
     *
     * @param  \Illuminate\Http\Request  $request A json array of transactions to submit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $transactions = json_decode($request->getContent(), true);

            // Go through every item submitted and create it
            foreach($transactions as $elem)
            {
                $item = Item::find($elem['item_id']);
                $user = User::find($elem['user_id']);

                $transaction = new Transaction();
                $transaction->item()->associate($item);
                $transaction->user()->associate($user);
                $transaction->item_quantity_change = $elem['quantity_change'];
                $transaction->transaction_date = date("Y-m-d H:i:s"); // current time
                $transaction->comment = "";

                // The user commenting on a transaction is optional
                if(array_key_exists('comment', $elem))
                    $transaction->comment = $elem['comment'];

                $transaction->save();

                $this->updateItemQuantity($elem['item_id']);
            }

            return response([
                'status' => 'transaction(s) stored',
                'transactions_count' => count($transactions)], 200)
                ->header('Content-Type', 'text/plain');
        }
        catch (Exception $e)
        {
            dd($e->getMessage());
            // Attempt to catch a bad database store
            return response([
                'status' => 'item modification failed',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Updates the quantity of the specified item by summing up all of the quantity changes
     * for that item in the transactions table. And sends email if item goes below threshold.
     * @param $id The ID of the item that needs to have it's quantity updated.
     */
    public function updateItemQuantity($id)
    {
        $item = Item::find($id);
        $item->quantity = DB::table('Order_Transaction')
            ->where('item_id', $id)
            ->sum('item_quantity_change');

        $item->save();

        $itemName = $item->name;
        $itemQuantity = $item->quantity;
        $itemThreshold = $item->low_threshold;
        $itemCapacity = $item->capacity;

        //only happens when removing below threshold
        //pulls emails that are marked as low_notify and sends them an email update
        for($i = 1; $i<=Member_Position::count(); $i++)
        {
            $member = Member_Position::find($i);

            // make sure that a member position was actually found
            if ($member == null)
                continue;

            if($member->low_notify)
                Notification::route('mail', $member->email)->notify(new ThresholdEmail($itemName,
                    $itemQuantity, $itemThreshold));

        }
    }
}
