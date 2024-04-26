<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;

class GerantOffersController extends Controller
{
    public function index()
    {
        return view('gerantOffers.list', [
            'title' => 'Programs List',
            'offers' => Offer::paginate(10)
        ]);
    }
    
    // public function create()
    // {
    //     return view('clients.create', [
    //     'title' => 'New Client',
    //     'clients' => Program::paginate(10)
    //     ]);
    // }

    // public function store(AddProgramRequest $request)
    // {
    //     Program::create([
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //     ]); 

    //     // Redirect the user back to the client listing page or any other desired page
    //     return redirect()->route('clients.index')->with('message', 'Client added successfully!');
    // }

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
