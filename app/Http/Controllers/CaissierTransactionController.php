<?php

namespace App\Http\Controllers;

use App\Client;
use App\Program;
use App\Transaction;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddTransactionRequest;

class CaissierTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('searchDate');
        $cardFilter = $request->input('cardFilter');


        $query = Transaction::with(['carteFidelite.client'])
            ->where(function ($q) use ($search, $searchDate, $cardFilter) {
                if ($search) {
                    $q->where('transaction_id', 'LIKE', "%{$search}%")
                        ->orWhere('amount', 'LIKE', "%{$search}%")
                        ->orWhereHas('client', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite.client', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite.program', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite', function ($query) use ($search) {
                            $query->where('tier', 'LIKE', "%{$search}%");
                        });
                }

                if ($searchDate) {
                    $q->whereDate('transaction_date', $searchDate);
                }


                if ($cardFilter == 'withCard') {
                    $q->whereNotNull('carte_fidelite_id');
                } elseif ($cardFilter == 'withoutCard') {
                    $q->whereNull('carte_fidelite_id');
                }
                
            })
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc');

        $transactions = $query->paginate(50);

        return view('caissierTransaction.list', [
            'title' => 'Active Transactions List',
            'transactions' => $transactions,
        ]);
    }



    public function create()
    {
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? 'TRANS-' . (intval(substr($latestTransaction->transaction_id, 6)) + 1) : 'TRANS-1';
        $clientsWithCard = Client::has('carteFidelite')->get();
        $clientsWithoutCard = Client::whereDoesntHave('carteFidelite')->get();
        $currentDateTime = now()->format('Y-m-d\TH:i');

        return view('caissierTransaction.create', [
            'title' => 'New Transaction',
            'transactionId' => $transactionId,
            'clientsWithCard' => $clientsWithCard,
            'clientsWithoutCard' => $clientsWithoutCard,
            'currentDateTime' => $currentDateTime,
        ]);
    }

    public function store(AddTransactionRequest $request)
    {
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
       
        
        $client = Client::findOrFail($request->client_id);

        if ($request->payment_method == 'fidelity_points' && !$client->carteFidelite) {
            return redirect()->back()->withErrors(['payment_method' => "This client does not have a fidelity card."]);
        }

        if ($client->carteFidelite) {
            $card = CarteFidelite::findOrFail($request->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);
            $transaction->carte_fidelite_id = $request->carte_fidelite_id;

            if ($program->status === 'inactive') {
                $client->money_spent += $request->amount;
                $client->save();
                $transaction->points = 0;
                $transaction->save();
                return redirect()->route('caissierTransaction.index')->with('message', 'Transaction added successfully! Change to be given back: ' . $change . '. The program related to this fidelity card is inactive.');
            }

            if ($request->payment_method == 'fidelity_points') {
                if ($card->money < $request->amount) {
                    return redirect()->back()->withErrors(['payment_method' => "Insufficient money on fidelity card."]);
                }

                $pointsToDeduct = $request->amount / $program->conversion_factor;
                $card->points_sum -= $pointsToDeduct;
                $card->money = $card->points_sum * $program->conversion_factor;
                $transaction->points = -$pointsToDeduct;

            }else{
                $transaction->points = $this->calculatePoints($request->amount, $card, $program);
            }

            $this->updateFidelityCard($card, $transaction->points, $request->amount);
            $transaction->payment_method = $request->payment_method;
        }


        $transaction->save();
        if ($request->payment_method != 'fidelity_points'){
            $client->money_spent += $request->amount;
            $client->save();
        }

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
        if ($points > 0) {
            $card->points_sum += $points;
        }
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

    public function destroy(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);

        // Reverse the effects of the transaction on client's money spent
        if ($transaction->payment_method != 'fidelity_points') {
            $client->money_spent -= $transaction->amount;
        }
        // Check if the transaction has an associated fidelity card
        if ($transaction->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($transaction->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);

            // Reverse the points and money on the fidelity card
            if ($transaction->payment_method == 'fidelity_points') {
                $card->money += $transaction->amount;
                $card->points_sum = $card->money / $program->conversion_factor;
            } else {
                $card->points_sum -= $transaction->points;
                $card->money = $card->points_sum * $program->conversion_factor;
            }

            $card->save();
        }

        $client->save();

        $transaction->delete();

        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction deleted successfully!');
    }

    public function cancel(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);

        // Reverse the effects of the transaction on client's money spent
        if ($transaction->payment_method != 'fidelity_points') {
            $client->money_spent -= $transaction->amount;
        }

        // Check if the transaction has an associated fidelity card
        if ($transaction->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($transaction->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);

            // Reverse the points and money on the fidelity card
            if ($transaction->payment_method == 'fidelity_points') {
                $card->money += $transaction->amount;
                $card->points_sum = $card->money / $program->conversion_factor;
            } else {
                $card->points_sum -= $transaction->points;
                $card->money = $card->points_sum * $program->conversion_factor;
            }

            // Save the updated card details
            $card->save();
        }

        // Save the updated client details
        $client->save();
    
        // Change the transaction status to 'cancelled'
        $transaction->status = 'cancelled';
        $transaction->save();
    
        return redirect()->route('caissierTransaction.index')->with('message', 'Transaction canceled successfully!');
    }

    public function cancelledTransactions(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('searchDate');
        $cardFilter = $request->input('cardFilter');

        $query = Transaction::with(['carteFidelite.client'])
            ->where(function ($q) use ($search, $searchDate, $cardFilter) {
                if ($search) {
                    $q->where('transaction_id', 'LIKE', "%{$search}%")
                        ->orWhere('amount', 'LIKE', "%{$search}%")
                        ->orWhereHas('client', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite.client', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite.program', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('carteFidelite', function ($query) use ($search) {
                            $query->where('tier', 'LIKE', "%{$search}%");
                        });
                }

                if ($searchDate) {
                    $q->whereDate('transaction_date', $searchDate);
                }

                if ($cardFilter == 'withCard') {
                    $q->whereNotNull('carte_fidelite_id');
                } elseif ($cardFilter == 'withoutCard') {
                    $q->whereNull('carte_fidelite_id');
                }
            })
            ->where('status', 'cancelled')
            ->orderBy('created_at', 'desc');

        $cancelledTransactions = $query->paginate(50);

        return view('caissierTransaction.cancelled', [
            'title' => 'Cancelled Transaction List',
            'cancelledTransactions' => $cancelledTransactions,
        ]);
    
    }

    public function reactivate(Transaction $transaction)
    {
        $client = Client::findOrFail($transaction->client_id);

        // Update client's money spent if the payment method is not fidelity points
        if ($transaction->payment_method != 'fidelity_points') {
            $client->money_spent += $transaction->amount;
        }

        // Reactivate the transaction
        $transaction->status = 'paid';
        $transaction->save();
        $client->save();

        // Check if the transaction has an associated fidelity card
        if ($transaction->carte_fidelite_id) {
            $card = CarteFidelite::findOrFail($transaction->carte_fidelite_id);
            $program = Program::findOrFail($card->program_id);

            if ($transaction->payment_method == 'fidelity_points') {
                // Deduct the amount from the fidelity card and update points
                $card->money -= $transaction->amount;
                $card->points_sum = $card->money / $program->conversion_factor;
            } else {
                // Add points based on the transaction amount
                $transaction->points = $this->calculatePoints($transaction->amount, $card, $program);
                $this->updateFidelityCard($card, $transaction->points, $transaction->amount);
            }

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
