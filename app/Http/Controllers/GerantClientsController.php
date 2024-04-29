<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\AddClientRequest;

class GerantClientsController extends Controller
{
    public function index()
    {
        return view('gerantClients.list', [
            'title' => 'Clients List',
            'gerantClients' => Client::paginate(10)
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
        ]); 

        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('gerantClients.index')->with('message', 'Client added successfully!');
    }

    // public function edit(Program $client)
    // {
    //     return view('clients.edit', [
    //         'title' => 'Edit Client',
    //         'client' => $client // Pass the client data to the view
    //     ]);
    // }

    // public function update(EditProgramRequest $request, Program $client)
    // {
    //     $client->name = $request->name;
    //     $client->phone = $request->phone;
    //     $client->email = $request->email;
    //     $client->save();

    //     return redirect()->route('clients.index')->with('message', 'Client updated successfully!');
    // }

    // public function destroy(Program $program)
    // {
    //     $program->delete();

    //     return redirect()->route('program.index')->with('message', 'User deleted successfully!');
    // }
}
