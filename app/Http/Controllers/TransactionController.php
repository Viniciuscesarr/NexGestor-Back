<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:deposit,withdrawal',
        ]);

        $transaction = Transaction::create([
            'amount' => $request->input('amount'),
            'type' => $request->input('type'),
        ]);

        return response()->json(['message' => 'Transação registrada com sucesso', 'transaction' => $transaction]);
    }

    public function getBalance()
    {
        $totalBalance = Transaction::getTotalBalance();

        return response()->json(['total_balance' => $totalBalance]);
    }

    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }
}
