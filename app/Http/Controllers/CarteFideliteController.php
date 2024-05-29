<?php

namespace App\Http\Controllers;

use App\Client;
use App\Program;
use App\Transaction;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddCardRequest;
use App\Http\Requests\EditCardRequest;

class CarteFideliteController extends Controller
{
        public function index(Request $request)
    {
        $search = $request->input('search');
        $programFilter = $request->input('program');
        $tierFilter = $request->input('tier');

        $query = CarteFidelite::with('client', 'program');

        if ($search) {
            $query->where('commercial_ID', 'LIKE', "%{$search}%")
                ->orWhereHas('client', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        if ($programFilter) {
            $query->where('program_id', $programFilter);
        }
    
        if ($tierFilter) {
            $query->where('tier', $tierFilter);
        }

        $cartes = $query->paginate(50);
        $clients = Client::all();
        $programs = Program::all();

        return view('carte_fidelite.list', [
            'title' => 'Cards List',
            'cartes' => $cartes,
            'clients' => $clients,
            'programs' => $programs,
        ]);
    }

    
    public function create()
    {
        
        // Generate the commercial ID
    $currentYear = date('Y');
    $latestCard = CarteFidelite::where('commercial_ID', 'like', "CARD-$currentYear%")
        ->orderBy('commercial_ID', 'desc')
        ->first();
        
    $newCardNumber = $latestCard ? ((int)substr($latestCard->commercial_ID, -5) + 1) : 1;
    $commercial_ID = "CARD-$currentYear-" . str_pad($newCardNumber, 5, '0', STR_PAD_LEFT);

    // Fetch clients who don't have a fidelity card associated with them
    $clientsWithoutCard = Client::whereDoesntHave('carteFidelite')->get();

    // Fetch active programs
    $programs = Program::where('status', 'active')->get();

    return view('gerantCF.create', [
        'title' => 'New Card',
        'commercial_ID' => $commercial_ID,
        'clientsWithoutCard' => $clientsWithoutCard,
        'programs' => $programs,
    ]);
    }

    public function store(AddCardRequest $request)
    {
        $currentYear = date('Y');
        $latestCard = CarteFidelite::where('commercial_ID', 'like', "CARD-$currentYear%")
            ->orderBy('commercial_ID', 'desc')
            ->first();

        $newCardNumber = $latestCard ? ((int)substr($latestCard->commercial_ID, -5) + 1) : 1;
        $newCardID = "CARD-$currentYear-" . str_pad($newCardNumber, 5, '0', STR_PAD_LEFT);

        $client = Client::where('name', $request->holder_name)->first();
        $program = Program::where('name', $request->fidelity_program)->first();

        $card = CarteFidelite::create([
            'commercial_ID' => $newCardID,
            'points_sum' => $request->points_sum,
            'tier' => $request->tier,
            'holder_name' => $request->holder_name,
            'holder_id' => $client->id,
            'program_id' => $program->id,
            'fidelity_program' => $request->fidelity_program,
        ]); 

            $client->fidelity_card_commercial_ID = $newCardID;
            $client->fidelity_card_id = $card->id;

            $client->save();        

        return redirect()->route('carte_fidelite.index')->with('message', 'New card has been added');
    }

        public function edit(CarteFidelite $carte)
        {
            $clients = Client::all();
            $programs = Program::where('status', 'active')->get();
            return view('carte_fidelite.edit', [
                'title' => 'Edit Card',
                'carte' => $carte,
                'clients' => $clients, 
                'programs' => $programs,
            ]);
            
        }
        

        public function update(EditCardRequest $request, CarteFidelite $carte)
        {
            $client = Client::where('name', $request->holder_name)->first();
            $program = Program::where('name', $request->fidelity_program)->first();

            $carte->points_sum = $request->points_sum;
            $carte->tier = $request->tier;
            $carte->holder_name = $request->holder_name;
            $carte->fidelity_program = $request->fidelity_program;
            $carte->holder_id = $client->id;
            $carte->program_id = $program->id;
            $carte->money = $carte->points_sum * $program->conversion_factor;
            $carte->save();

            return redirect()->route('carte_fidelite.index')->with('message', 'Card updated successfully!');
        }

        public function destroy(CarteFidelite $carte)
        {
            // Check if the fidelity card has associated transactions
            $hasTransactions = Transaction::where('carte_fidelite_id', $carte->id)->exists();
            if ($hasTransactions) {
                return redirect()->route('carte_fidelite.index')->with('warning', 'This fidelity card has active transaction(s). Please remove the transaction(s) before deleting the fidelity card.');
            }

            // If no associated transactions, proceed with deletion
            $carte->delete();
            return redirect()->route('carte_fidelite.index')->with('message', 'Card deleted successfully!');
        }
}
