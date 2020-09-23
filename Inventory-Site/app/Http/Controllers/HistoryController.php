<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Transaction;
use App\User;

class HistoryController extends Controller
{
    public function index()
    {
        $activeItems = Item::all();
        $activeTransactions = Transaction::all();
        $activeUsers = User::all();
        return view('pages.history')->with('activeItems', $activeItems)->with('activeTransactions', $activeTransactions)->with('activeUsers', $activeUsers);
    }
}
