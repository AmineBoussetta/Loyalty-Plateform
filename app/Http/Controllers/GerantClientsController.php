<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
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
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
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
        'title' => 'New Client',
        'gerant' => $gerant,
        'clients' => Client::paginate(10)
        ]);
    }

    public function store(AddClientRequest $request, $gerant)
    {
        try {
            // Extraction des données de la requête
            $companyId = Auth::user()->company_id;
            $nameParts = explode(' ', $request->name);
            $userName = $nameParts[0];
            $userLastName = isset($nameParts[1]) ? $nameParts[1] : '';
            $password = Str::random(8);
            $hashedPassword = Hash::make($password);
    
            // Création du client
            $client = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'company_id' => $companyId,
                'money_spent' => 0.0,
            ]); 
    
            // Création de l'utilisateur
            User::create([
                'name' => $userName,
                'last_name' => $userLastName,
                'role' => 4,
                'email' => $request->email,
                'password' => $hashedPassword,
                'company_id' => $companyId
            ]);
    
            // Envoi de l'email
            Mail::to($request->email)->send(new ClientCredentialsEmail($userName, $request->email, $password));
    
            return redirect()->route('gerantClients.index', ['gerant' => $gerant])->with('message', 'Client ajouté avec succès !');
        } catch (\Exception $e) {
            // Gestion des erreurs
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'ajout du client : ' . $e->getMessage());
        }
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
