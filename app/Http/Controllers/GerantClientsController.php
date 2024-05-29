<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use Illuminate\Http\Request;
use App\Http\Requests\AddClientRequest;
use App\Http\Requests\EditClientRequest;

class GerantClientsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Client::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $gerantClients = $query->paginate(50);

        return view('gerantClients.list', [
            'title' => 'Clients List',
            'gerantClients' => $gerantClients
        ]);
    }
    
    public function create()
    {
        return view('gerantClients.create', [
        'title' => 'New Client',
        'clients' => Client::paginate(10)
        ]);
    }

    public function store(AddClientRequest $request)
    {
        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'money_spent' => 0.0,
        ]); 

        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('gerantClients.index')->with('message', 'Client added successfully!');
    }

    public function edit(Client $client)
    {
        return view('gerantClients.edit', [
            'title' => 'Edit Client',
            'client' => $client // Pass the client data to the view
        ]);
    }

    public function update(EditClientRequest $request, Client $client)
    {
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->save();

        return redirect()->route('gerantClients.index')->with('message', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('gerantClients.index')->with('message', 'Client deleted successfully!');
    }
}
