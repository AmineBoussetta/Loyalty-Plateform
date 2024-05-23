<?php

namespace App\Http\Controllers;

use App\Client;
use App\Program;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddCardRequest;
use App\Http\Requests\EditCardRequest;
use Illuminate\Support\Facades\Log;

class CarteFideliteController extends Controller
{
        public function index()
    {
        $cartes = CarteFidelite::with('client')->paginate(10);
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
        
        // Générer l'identifiant commercial
        $currentYear = date('Y');
        $latestCard = CarteFidelite::where('commercial_ID', 'like', "CARD-$currentYear%")
            ->orderBy('commercial_ID', 'desc')
            ->first();
            
        $newCardNumber = $latestCard ? ((int)substr($latestCard->commercial_ID, -5) + 1) : 1;
        $commercial_ID = "CARD-$currentYear-" . str_pad($newCardNumber, 5, '0', STR_PAD_LEFT);

        $clients = Client::all();
        $programs = Program::where('status', 'active')->get();


        return view('carte_fidelite.create', [
            'title' => 'New Card',
            'commercial_ID' => $commercial_ID, // Passage de l'identifiant commercial à la vue
            'clients' => $clients, // Passage de la liste des clients à la vue
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
            $carte->delete();

            return redirect()->route('carte_fidelite.index')->with('message', 'Card deleted successfully!');
        }
}
