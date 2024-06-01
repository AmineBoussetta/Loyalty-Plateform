<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use App\CarteFidelite;
use App\Transaction;
use App\Company;
use App\Http\Mail\ClientCredentialsEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Http\Requests\AddClientRequest;
use App\Http\Requests\EditClientRequest;


class ClientController extends Controller
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

        $clients = $query->paginate(50);

        return view('clients.list', [
            'title' => 'Clients List',
            'clients' => $clients
        ]);
    }
    
    public function create($caissier)
    {
        $companies = Company::all();
        return view('clients.create', [
        'title' => 'New Client',
        'caissier' => $caissier,
        'clients' => Client::paginate(10)
        ]);
    }

    public function store(AddClientRequest $request,$caissier)
    {
        
        
        


        $user_name=explode(' ', $request->name)[0];
        $user_last_name=explode(' ', $request->name)[1];
        $email = $request->email;
        $password=Str::random(8);
        $hashedPassword = Hash::make($password);
        //$userEmail = $user_name . '.' . $user_last_name . '@' . $company_name . '.com';

        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $email,
            'company_id' => $caissier,
            'money_spent' => 0.0,
        ]); 

        User::create([
            'name' => $user_name,
            'last_name'=>$user_last_name,
            'role'=>4,
            'email'=> $email,
            'password'=>$hashedPassword,
            'company_id' => $caissier

        ]);


        $emailSent= Mail::to($email)->send(new ClientCredentialsEmail($request->name,  $email, $password));
        
        if ($emailSent) {
            return redirect()->route('clients.index',['caissier' => $caissier])->with('message', 'Client added successfully!');
        }
        // Redirect the user back to the client listing page or any other desired page
    }

    public function edit(Client $client)
    {
        return view('clients.edit', [
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

        return redirect()->route('clients.index')->with('message', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        if ($client->carteFidelite) {
            return redirect()->route('clients.index')->with('warning', 'This client has an active fidelity card. Please remove the fidelity card before deleting the client.');
        }
    
        $client->delete();

        return redirect()->route('clients.index')->with('message', 'User deleted successfully!');
    }




}


