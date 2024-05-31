<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;

use App\Company;
use App\Http\Mail\ClientCredentialsEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Http\Requests\AddClientRequest;
use App\Http\Requests\EditClientRequest;
use App\Services\ClientImportService;

class ClientController extends Controller
{

    public function index($caissier)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
        }

        $companyId = Auth::user()->company_id;
        $caissierClients = Client::where('company_id', $companyId)->paginate(10);
        return view('clients.list', [
            'title' => 'Clients List',
            'clients' => $caissierClients,
            'caissier' => $caissier
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
        $companyId = Auth::user()->company_id;
        
        


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
            'company_id' => $companyId,
            'money_spent' => 0.0,
        ]); 

        User::create([
            'name' => $user_name,
            'last_name'=>$user_last_name,
            'role'=>4,
            'email'=> $email,
            'password'=>$hashedPassword,
            'company_id' => $companyId

        ]);


        $emailSent= Mail::to($email)->send(new ClientCredentialsEmail($request->name,  $email, $password));
        
        if ($emailSent) {
            return redirect()->route('clients.index')->with('message', 'Client added successfully!');
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
        $client->delete();

        return redirect()->route('clients.index')->with('message', 'User deleted successfully!');
    }

    public function search(Request $request)
{
    $query = $request->input('query');
    $clients = GerantClient::where('name', 'like', '%' . $query . '%')->get();
    return response()->json($clients);
}

    public function loadAll()
    {
        // Fetch all clients
        $gerantClients = Client::all();
        
        // Pass the clients to the view
        return view('gerantClients.list', compact('gerantClients'));
    }



// import export methods by excel ( baha )
    protected $clientImportService;

    public function __construct(ClientImportService $clientImportService)
    {
        $this->clientImportService = $clientImportService;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $filePath = $request->file('file')->getRealPath();
        $this->clientImportService->import($filePath);

        return redirect()->back()->with('success', 'Clients imported successfully.');
    }


}


