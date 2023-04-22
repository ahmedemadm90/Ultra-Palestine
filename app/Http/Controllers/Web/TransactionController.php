<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::get();
        return view('transactions.index', compact('transactions'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'from_account' => 'required|exists:users,id',
            'to_account' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);
        $from = User::find($request->from_account);
        $to = User::find($request->to_account);
    }
}
