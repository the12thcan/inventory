<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Transaction;

class DashboardController extends Controller
{

    /*public function getItemName($itemNumber)
    {
        $item = Item::all()->where('id', $itemNumber);
        return $item->first()->name;
    }

    public function combineTransactions($transactions) {
        $transactionsArray = array();
        for ($i = 0; $i < count($transactions); ++$i) {
            $transactionsArray[] = $transactions[$i];
        }
        $itemIdSeen = array();
        $itemId = 0;
        $doBreak = False;
        for ($i = 0; $i < count($transactionsArray); ++$i) {
            for ($d = 0; $d < count($itemIdSeen); ++$d) {
                if ($itemIdSeen[$d] == $transactionsArray[$i]->item_id) {
                    array_splice($transactionsArray, $i, $i);
                    $doBreak = True;
                    break;
                }
            }
            if ($doBreak) {
                $doBreak = False;
                break;
            }
            $itemId = $transactionsArray[$i]->item_id;
            for ($d = 0; $d < count($transactionsArray); ++$d) {
                if ($d != $i && $transactionsArray[$d]->item_id == $itemId) {
                    $transactionsArray[$i]->item_quantity_change += $transactionsArray[$d]->item_quantity_change;
                }
            }
            $itemIdSeen[] = $itemId;
        }
        return $transactionsArray;
    }*/

    public function index()
    {
        #$orderTransactions = Transaction
        #return Transaction::all();
        $activeItems = Item::all();//->where('removed','0');
        $activeTransactions = Transaction::all();
        return view('pages.dashboard')->with('activeItems', $activeItems)->with('activeTransactions', $activeTransactions);
    }
}
