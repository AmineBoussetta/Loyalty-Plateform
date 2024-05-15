<?php

namespace App\Http\Controllers;

use App\Program;
use App\Transaction;
use App\CarteFidelite;
use App\FidelityPoints;
use Illuminate\Http\Request;
use App\Http\Requests\AddTransactionRequest;
use App\Http\Requests\EditTransactionRequest;

class CaissierTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Transaction::with(['carteFidelite.client'])->where('status', 'active');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('transaction_date', 'LIKE', "%{$search}%")
                  ->orWhere('amount', 'LIKE', "%{$search}%");
            });
        }

        $transactions = $query->paginate(10);
        $cartes = CarteFidelite::all();

        return view('caissierTransaction.list', [
            'title' => 'Transaction List',
            'transactions' => $transactions,
            'cartes' => $cartes,
        ]);
    }
    
        public function create()
    {
        // Generate a unique transaction ID
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';
        $cards = CarteFidelite::all();

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


        // Fetch the fidelity card based on the selected card ID
        $card = CarteFidelite::where('id', $request->carte_fidelite_id)->first();

        if (!$card) {
        // Handle the case where no card is found for the given ID
            return redirect()->back()->withErrors(['carte_fidelite_id' => 'No card found for this ID.']);
        }

        // Fetch the fidelity program based on the card's program_id
        $program = Program::find($card->program_id);

        if (!$program || $program->status === "inactive") {
            // Handle the case where no program is found for the given card ID
            return redirect()->back()->withErrors(['carte_fidelite_id' => 'No active program found for this card.']);
        }

        // Calculate points based on the transaction amount and the program's rules
        //     $points = 0;
        // if ($request->amou   nt >= $program->minimum_amount) {
        //     // Calculate the number of times the transaction amount exceeds the increment
        //     $increments = floor(($request->amount - $program->minimum_amount) / $program->amount);
        //     // Award points based on the number of increments
        //     $points = $increments * $program->points;
        // }
        $points = $request->amount * $program->conversion_factor;


            // Create the transaction
        $transaction = new Transaction;
        $transaction->transaction_id = $transactionId;
        $transaction->carte_fidelite_id = $request->carte_fidelite_id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->amount = $request->amount;
        $transaction->payment_method = $request->payment_method;
        $transaction->status  = $transaction->status ?? 'active';
        $transaction->points = $points;
        $transaction->save();

        // Save the points to the database
        $card->points_sum += $points; // Assuming total_points is an integer type
        $card->save();


        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction added successfully!');
    }

    public function edit(Transaction $transaction)
    {
        $cards = CarteFidelite::all();
        return view('caissierTransaction.edit', [
            'title' => 'Edit Transaction',
            'transaction' => $transaction,
            'cards' => $cards,
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

    public function cancel(Request $request, Transaction $transaction)
    {
        // Set the transaction status to "canceled"
        $transaction->status = 'canceled';
        $transaction->save();

        // Fetch the fidelity card associated with the transaction
        $card = CarteFidelite::where('id', $transaction->carte_fidelite_id)->first();

        // Revert the points to their original state
        $card->points_sum -= $transaction->points; // Subtract the points awarded during the transaction
        $card->save();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction canceled successfully!');
    }

    public function cancelledTransactions()
    {
            $cancelledTransactions = Transaction::where('status', 'canceled')->paginate(10);

            return view('caissierTransaction.cancelled', [
                'title' => 'Cancelled Transactions',
                'cancelledTransactions' => $cancelledTransactions,
            ]);
    }

    public function reactivate(Transaction $transaction)
    {
        $transaction->status = 'active';
        $transaction->save();

        // Restore the points to the associated fidelity card
        $card = CarteFidelite::find($transaction->carte_fidelite_id);
        $card->points_sum += $transaction->points;
        $card->save();

        return redirect()->route('caissierTransaction.cancelledTransactions')->with('message', 'Transaction reactivated successfully!');
    }

    public function permanentDelete(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('caissierTransaction.cancelledTransactions')->with('message', 'Transaction deleted permanently!');
    }
}
