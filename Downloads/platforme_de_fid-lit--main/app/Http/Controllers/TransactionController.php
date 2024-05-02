<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Requests\AddTransactionRequest;
use App\Http\Requests\EditTransactionRequest;


class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.list', [
            'title' => 'Transactions List',
            'transactions' => Transaction::paginate(10)
        ]);
        
    }

    public function create()
    {
        return view('transactions.create', [
            'title' => 'New Transaction',
            'transactions' => Transaction::paginate(10)
            ]);
    }

    public function store(AddTransactionRequest $request)
    {

        Transaction::create([
           'client_id'=>$request->client_id,
           'nom du caissier'=>$request->nomcaissier,
           'type'=>$request->type,
           'amount'=>$request->amount,
           'date'=>$request->date,
           'description' => $request->description,
           'payment_method' => $request->payment_method,
           'status' => $request->status,
        
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit',[
            'title'=>'Edit Transaction',
            'transaction'=>$transaction ]);
    }

    public function update( EditTransactionRequest $request, Transaction $transaction)
    {
        $transaction->client_id = $request->client_id ;
        $transaction->nomcaissier = $request->nomcaissier;
        $transaction->type = $request->type;
        $transaction->amount = $request-> amount;
        $transaction->date = $request->date;
        $transaction->description = $request->description;
        $transaction->payment_method = $request->payment_method;
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
