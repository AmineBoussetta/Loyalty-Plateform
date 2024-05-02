<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddCardRequest;
use App\Http\Requests\EditCardRequest;

class CarteFideliteController extends Controller
{
    public function index()
    {
        $cartes = CarteFidelite::with('client')->paginate(10);
        return view('carte_fidelite.list', [
            'title' => 'Cards List',
            'cartes' => $cartes
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

        $clients = Client::all(); // Récupération de la liste des clients

        return view('carte_fidelite.create', [
            'title' => 'New Card',
            'clients' => $clients, // Passage de la liste des clients à la vue
            'commercial_ID' => $commercial_ID, // Passage de l'identifiant commercial à la vue
        ]);
    }

    public function store(AddCardRequest $request)
    {
        // Obtenir l'année actuelle
        $currentYear = date('Y');

        // Trouver le numéro de carte le plus récent pour cette année
        $latestCard = CarteFidelite::where('commercial_ID', 'like', "CARD-$currentYear%")
            ->orderBy('commercial_ID', 'desc')
            ->first();

        // Générer le nouvel identifiant commercial
        $newCardNumber = $latestCard ? ((int)substr($latestCard->commercial_ID, -5) + 1) : 1;
        $newCardID = "CARD-$currentYear-" . str_pad($newCardNumber, 5, '0', STR_PAD_LEFT);

        CarteFidelite::create([
            'commercial_ID' => $newCardID,
            'points_sum' => $request->points_sum,
            'tier' => $request->tier,
            'name' => $request->name,
            'fidelity_program' => $request->fidelity_program,
        ]); 

        return redirect()->route('carte_fidelite.index')->with('message', 'New card has been added');
    }

        public function edit(CarteFidelite $carte)
        {
            $clients = Client::all(); // Fetch all clients
        
            return view('carte_fidelite.edit', [
                'title' => 'Edit Card',
                'carte' => $carte,
                'clients' => $clients, // Pass the $clients variable to the view
            ]);
        }

        public function update(EditCardRequest $request, CarteFidelite $carte)
        {
            $carte->points_sum = $request->points_sum;
            $carte->tier = $request->tier;
            $carte->name = $request->name;
            $carte->fidelity_program = $request->fidelity_program;
            $carte->save();

            return redirect()->route('carte_fidelite.index')->with('message', 'Card updated successfully!');
        }

        public function destroy(CarteFidelite $carte)
        {
            $carte->delete();

            return redirect()->route('carte_fidelite.index')->with('message', 'Card deleted successfully!');
        }
}
