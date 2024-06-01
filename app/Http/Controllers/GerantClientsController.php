<?php

namespace App\Http\Controllers;

use App\Client;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\AddClientRequest;
use App\Http\Requests\EditClientRequest;
use App\User;
use App\Http\Mail\ClientCredentialsEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class GerantClientsController extends Controller
{
    public function index($gerant)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir cette page.');
        }

        $companyId = Auth::user()->company_id;
        $gerantCaissiers = Client::where('company_id', $companyId)->paginate(10);
        return view('gerantClients.list', [
            'title' => 'Clients List',
            'gerantClients' => $gerantCaissiers,
            'gerant' => $gerant
        ]);
    }
    
    public function create($gerant)
    {
        $companies = Company::all();
        return view('gerantClients.create', [
            'title' => 'New Client ',
            'gerant' => $gerant,
            'clients' => Client::paginate(10)
        ]);
    }

    public function store(AddClientRequest $request, $gerant)
    {
        

            
            $nameParts = explode(' ', $request->name);
            $userName = $nameParts[0];
            $userLastName = isset($nameParts[1]) ? $nameParts[1] : '';
            $password = Str::random(8);
            $hashedPassword = Hash::make($password);
    
            $client = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'company_id' => $gerant,
                'money_spent' => 0.0,
            ]); 
    
            User::create([
                'name' => $userName,
                'last_name' => $userLastName,
                'role' => 4,
                'email' => $request->email,
                'password' => $hashedPassword,
                'company_id' => $gerant
            ]);
    
            Mail::to($request->email)->send(new ClientCredentialsEmail($userName, $request->email, $password));
    
            return redirect()->route('gerantClients.index', ['gerant' => $gerant])->with('message', 'Client added successfully!');
        
        
    }

    public function edit(Client $client)
    {
        $gerant = Auth::user()->id; // Supposons que l'utilisateur authentifié est le gérant

        return view('gerantClients.edit', [
            'title' => 'Edit Client',
            'client' => $client,
            'gerant' => $gerant // Passez l'ID du gérant à la vue
        ]);
    }

    public function update(EditClientRequest $request, Client $client)
    {
        $gerant = Auth::user()->id; // Supposons que l'utilisateur authentifié est le gérant

        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->save();

        return redirect()->route('gerantClients.index', ['gerant' => $gerant])->with('message', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $gerant = Auth::user()->id; // Supposons que l'utilisateur authentifié est le gérant

        $client->delete();

        return redirect()->route('gerantClients.index', ['gerant' => $gerant])->with('message', 'Client deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $clients = Client::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($clients);
    }

    public function loadAll()
    {
        $clients = Client::all();
        return response()->json($clients);
    }
}
