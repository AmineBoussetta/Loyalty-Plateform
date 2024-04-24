<?php

namespace App\Http\Controllers;

use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddCardRequest;

class CarteFideliteController extends Controller
{
    public function index()
    {
        return view('carte_fidelite.list', [
            'title' => 'Cards List',
            'cartes' => CarteFidelite::paginate(10)
        ]);
    }
    
    public function create()
    {
        return view('carte_fidelite.create', [
        'title' => 'New Card',
        'cartes' => CarteFidelite::paginate(10)
        ]);
    }

    public function store(AddCardRequest $request)
    {
        CarteFidelite::create([
            'commercial_ID' => $request->commercial_ID,
            'points_sum' => $request->points_sum,
            'tier' => $request->tier,
            'name' => $request->name,
        ]); 

    // Redirect the user back to the card listing page or any other desired page
        return redirect()->route('carte_fidelite.index')->with('message', 'Client added successfully!');
    }

    // public function edit(Client $client)
    // {
    //     return view('clients.edit', [
    //         'title' => 'Edit Client',
    //         'client' => $client // Pass the client data to the view
    //     ]);
    // }

    // public function update(EditClientRequest $request, Client $client)
    // {
    //     $client->name = $request->name;
    //     $client->phone = $request->phone;
    //     $client->email = $request->email;
    //     $client->save();

    //     return redirect()->route('clients.index')->with('message', 'Client updated successfully!');
    // }

    // public function destroy(Client $client)
    // {
    //     $client->delete();

    //     return redirect()->route('clients.index')->with('message', 'User deleted successfully!');
    // }
}
