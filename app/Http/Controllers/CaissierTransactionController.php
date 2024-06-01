<?php

namespace App\Http\Controllers;

use App\Program;
use App\Transaction;
use App\CarteFidelite;
use App\Client;
use App\Caissier;
use Illuminate\Http\Request;
use App\Http\Requests\AddTransactionRequest;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\EditTransactionRequest;

class CaissierTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Transaction::with(['carteFidelite.client'])
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('transaction_id', 'LIKE', "%{$search}%")
                      ->orWhere('transaction_date', 'LIKE', "%{$search}%")
                      ->orWhere('amount', 'LIKE', "%{$search}%");
                }
            })
            ->where('status', '!=', 'canceled')
            ->paginate(50);

        return view('caissierTransaction.list', [
            'title' => 'Transaction List',
            'transactions' => $query,
        ]);
    }

    public function create()
    {
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';
        $clientsWithCard = Client::has('carteFidelite')->get();
        $clientsWithoutCard = Client::whereDoesntHave('carteFidelite')->get();

        return view('caissierTransaction.create', [
            'title' => 'New Transaction',
            'transactionId' => $transactionId,
            'clientsWithCard' => $clientsWithCard,
            'clientsWithoutCard' => $clientsWithoutCard,
        ]);
    }

    public function store(AddTransactionRequest $request)
    {
        $user = Auth::user()->id;
        $caissier =Caissier::where('user_id',$user)->first();
        $caissierId = $caissier->Caissier_ID;  
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';
        $change = $request->amount_spent - $request->amount;

        $transaction = new Transaction;
        $transaction->transaction_id = $transactionId;
        $transaction->client_id = $request->client_id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->amount = $request->amount;
        $transaction->amount_spent = $request->amount_spent;
        $transaction->payment_method = $request->payment_method ?? 'cash';
        $transaction->status = 'paid';
        $transaction->caissier_id = $caissierId;
       
        
        $client = Client::findOrFail($request->client_id);

        if ($client->carteFidelite) {
            $card = CarteFidelite::findOrFail($request->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);
            $transaction->carte_fidelite_id = $request->carte_fidelite_id;

            if ($request->payment_method == 'fidelity_points') {

                if ($card->money < $request->amount) {
                    return redirect()->back()->withErrors(['payment_method' => "Insufficient money on fidelity card."]);
                }

                $card->money -= $request->amount;
                $card->points_sum = $card->money / $program->conversion_factor;
                $card->save();

            }else{
                $transaction->points = $this->calculatePoints($request->amount, $card, $program);
            }

            $this->updateFidelityCard($card, $transaction->points, $request->amount);
            $transaction->payment_method = $request->payment_method;
        }


        $transaction->save();
       
        $client->money_spent += $request->amount;
        $client->save();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction added successfully! Change to be given back: ' . $change);
    }

    private function calculatePoints($amount, $card, $program)
    {
        if ($card->tier === 'classic') {
            if ($program->minimum_amount && $amount < $program->minimum_amount) {
                return 0;
            }
            return floor($amount / $program->amount) * $program->points;
        }

        if ($card->tier === 'premium') {
            if ($program->minimum_amount_premium && $amount < $program->minimum_amount_premium) {
                return 0;
            }
            return floor($amount / $program->amount_premium) * $program->points_premium;
        }

        return 0;
    }

    private function updateFidelityCard($card, $points, $amount)
    {
        $card->points_sum += $points;
        $card->money = $card->points_sum * $card->program->conversion_factor;
        $card->save();
    }

    public function edit(Transaction $transaction)
    {
        $clientsWithCard = Client::has('carteFidelite')->get();
        $clientsWithoutCard = Client::doesntHave('carteFidelite')->get();

        return view('caissierTransaction.edit', [
            'title' => 'Edit Transaction',
            'transaction' => $transaction,
            'clientsWithCard' => $clientsWithCard,
            'clientsWithoutCard' => $clientsWithoutCard,
        ]);
    }

    public function update(EditTransactionRequest $request, Transaction $transaction)
    {

        // Update client money spent for the previous transaction
        $client = Client::findOrFail($transaction->client_id);
        $client->money_spent -= $transaction->amount;
        $client->save();

        $card = $transaction->carteFidelite;

        if ($card) {
            // Subtract the points from the fidelity card corresponding to the original transaction
            $program = Program::findOrFail($card->program_id);
            $card->points_sum -= $transaction->points;
            $card->money = $card->points_sum * $program->conversion_factor;
            $card->save();

        $transaction->update([
            'client_id' => $request->client_id,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'amount_spent' => $request->amount_spent,
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        if ($request->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($request->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);
            $transaction->carte_fidelite_id = $request->carte_fidelite_id;
            $transaction->points = $this->calculatePoints($request->amount, $card, $program);
            $this->updateFidelityCard($card, $transaction->points, $request->amount);
        } else {
            $transaction->points = 0;
        }
    

        $transaction->save();

        $client->money_spent += $request->amount;
        $client->save();

    } else {
        // If there is no fidelity card associated with the transaction, update the transaction without modifying the fidelity card
        $transaction->update([
            'client_id' => $request->client_id,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'amount_spent' => $request->amount_spent,
            'payment_method' => $request->payment_method ?? 'cash',
            'carte_fidelite_id' => $request->carte_fidelite_id,
        ]);

        // Update client money spent for the new transaction
        $client->money_spent += $request->amount;
        $client->save();
    }

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction updated successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);
        $client->money_spent -= $transaction->amount;
        $client->save();
        $transaction->delete();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction deleted successfully!');
    }

    public function cancel(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);
        $client->money_spent -= $transaction->amount;
        $client->save();

        if ($transaction->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($transaction->carte_fidelite_id);
            $card->points_sum -= $transaction->points;
            $card->money = $card->points_sum * $card->program->conversion_factor;
            $card->save();
        }

        $transaction->status = 'cancelled';
        $transaction->save();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction canceled successfully!');
    }

    public function cancelledTransactions()
    {
        $cancelledTransactions = Transaction::where('status', 'cancelled')->paginate(10);

        return view('caissierTransaction.cancelled', [
            'title' => 'Cancelled Transactions',
            'cancelledTransactions' => $cancelledTransactions,
        ]);
    }

    public function reactivate(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);
        $client->money_spent += $transaction->amount;
        $client->save();

        $transaction->status = 'paid';
        $transaction->save();

        if ($transaction->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($transaction->carte_fidelite_id);
            $card->points_sum += $transaction->points;
            $card->money = $card->points_sum * $card->program->conversion_factor;
            $card->save();
        }

        return redirect()->route('caissierTransaction.cancelledTransactions')->with('message', 'Transaction reactivated successfully!');
    }

    public function permanentDelete(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('caissierTransaction.cancelledTransactions')->with('message', 'Transaction deleted permanently!');
    }
}
