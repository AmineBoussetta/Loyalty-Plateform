<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\EditTransactionRequest;
use App\Http\Requests\AddTransactionRequest;

class CaissierTransactionController extends Controller
{
    public function index()
    {
        return view('caissierTransaction.list', [
            'title' => 'Transaction List',
            'transactions' => Transaction::paginate(10)
            
        ]);
    }
    
        public function create()
    {
        // Generate a unique transaction ID
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';
        $cards = CarteFidelite::select('id', 'holder_name')->get();

        return view('caissierTransaction.create', [
            'title' => 'New Transaction',
            'transactions' => Transaction::paginate(10),
            'transactionId' => (string) $transactionId,
            'cards' => $cards,
        ]);
    }

    public function store(AddTransactionRequest $request)
    {
        // Generate a unique transaction ID
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';

        Transaction::create([
            'transaction_id' => (string) $transactionId,
            'carte_fidelite_id' => $request->carte_fidelite_id,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction added successfully!');
    }

    public function edit(Transaction $transaction)
    {
        return view('caissierTransaction.edit', [
            'title' => 'Edit Transaction',
            'transaction' => $transaction
        ]);
    }

    public function update(EditTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update([
            'carte_fidelite_id' => $request->carte_fidelite_id,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction updated successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction deleted successfully!');
    }
}
