<?php

namespace App\Http\Controllers;

use Log;
use App\Client;
use App\Program;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddCardRequest;
use App\Http\Requests\EditCardRequest;

class GerantCarteFideliteController extends Controller
{
    public function index()
    {
        $cartes = CarteFidelite::with('client')->paginate(10);
        $programs = Program::all();
        $clients = Client::all();
        return view('gerantCF.list', [
            'title' => 'Cards List',
            'cartes' => $cartes,
            'programs' => $programs,
            'clients' => $clients
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
        $programs = Program::where('status', 'active')->get();

        return view('gerantCF.create', [
            'title' => 'New Card',
            'clients' => $clients, // Passage de la liste des clients à la vue
            'commercial_ID' => $commercial_ID, // Passage de l'identifiant commercial à la vue
            'programs' => $programs
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

        $client = Client::where('name', $request->holder_name)->first();
        $program = Program::where('name', $request->fidelity_program)->first();

        CarteFidelite::create([
            'commercial_ID' => $newCardID,
            'points_sum' => $request->points_sum,
            'tier' => $request->tier,
            'holder_name' => $request->holder_name,
            'holder_id' => $client->id,
            'program_id' => $program->id,
            'fidelity_program' => $request->fidelity_program,
        ]); 

        return redirect()->route('gerantCF.index')->with('message', 'New card has been added');
    }

        public function edit(CarteFidelite $carte)
        {
            $clients = Client::all();
            $programs = Program::where('status', 'active')->get();
            return view('gerantCF.edit', [
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
            $carte->save();

            return redirect()->route('gerantCF.index')->with('message', 'Card updated successfully!');
        }

        public function destroy(CarteFidelite $carte)
        {
            $carte->delete();

            return redirect()->route('gerantCF.index')->with('message', 'Card deleted successfully!');
        }
}
