<?php
namespace App\Http\Controllers;

use App\Caissier;
use App\Company;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Mail\CaissierCredentialsEmail;
use App\Http\Requests\AddCaissierRequest;
use App\Http\Requests\EditCaissierRequest;


class GerantCaissiersController extends Controller
{
    public function index(Request $request,$gerant)
    {
        // Vérifiez si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
        }
        $search = $request->input('search');
        $query = Caissier::where('company_id', Auth::user()->company_id);

        if ($search) {
            $query->where(function ($subQuery) use ($search) {
            $subQuery->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
        });
        }

        $gerantCaissiers = $query->paginate(10);

        
        


        return view('gerantCaissiers.list', [
            'title' => 'Cashier List',
            'gerantCaissiers' => $gerantCaissiers,
            
            'gerant' => $gerant
        ]);
    }

    public function create($gerant)
    {
        $caissierID = $this->generateCaissierID();
        $companies = Company::all();

        return view('gerantCaissiers.create', [
            'title' => 'New Cashier',
            'companies' => $companies,
            'Caissier_ID' => $caissierID,
            'gerant' => $gerant
        ]);
    }

    public function store(AddCaissierRequest $request, $gerant)
{
    $companyId = Auth::user()->company_id;
    $caissierID = $this->generateCaissierID();

    $nameParts = explode(' ', $request->name);
    $userName = $nameParts[0];
    $userLastName = isset($nameParts[1]) ? $nameParts[1] : '';
    $email = $request->email;
    $userEmail = $userName . '.' . $userLastName . '@' . $request->company_name . '.com';
    $password = Str::random(8);
    $hashedPassword = Hash::make($password);

    // Créez d'abord l'utilisateur
    $user = User::create([
        'name' => $userName,
        'last_name' => $userLastName,
        'role' => 3,
        'email' => $userEmail,
        'password' => $hashedPassword,
        'company_id' => $companyId
    ]);

    // Ensuite, créez le caissier en utilisant l'ID de l'utilisateur
    Caissier::create([
        'Caissier_ID' => $caissierID,
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $email,
        'company_name' => $request->company_name,
        'company_id' => $companyId,
        'user_id' => $user->id  // Utiliser l'ID de l'utilisateur créé
    ]);

    // Envoyer un email avec les informations de connexion
    Mail::to($email)->send(new CaissierCredentialsEmail($userName, $userEmail, $password));

    return redirect()->route('gerantCaissiers.index', ['gerant' => $gerant])->with('message', 'Cashier added successfully!');
}


    public function edit($gerant, $caissierID)
{
    // Récupérer le caissier par son identifiant
    $caissier = Caissier::where('Caissier_ID', $caissierID)->firstOrFail();
    $companies = Company::all();

    return view('gerantCaissiers.edit', [
        'title' => 'Edit Cashier',
        'caissier' => $caissier,
        'companies' => $companies,
        'gerant' => $gerant,
        'gerantCaissiers' => $caissier, // Passer le caissier à la vue
    ]);
}



public function update(EditCaissierRequest $request, $gerant, $caissierID)
{
    
    // Mettre à jour les champs du caissier avec les données du formulaire
    $caissier = Caissier::findOrFail($caissierID);
    $caissier->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'company_name' => $request->input('company_name'),
    ]);

    // Rediriger vers la route 'gerantCaissiers.index' avec le paramètre 'gerant'
    return redirect()->route('gerantCaissiers.index', ['gerant' => $gerant])
                     ->with('message', 'Caissier updated successfully !');
}


public function destroy($gerant, $caissierID){
{
    $caissier = Caissier::where('Caissier_ID', $caissierID)->firstOrFail();

        $caissier->delete();
        return redirect()->route('gerantCaissiers.index', ['gerant' => $gerant])->with('message', 'Cashier deleted successfully!');
       
    }
}


    private function generateCaissierID()
    {
        $currentYear = date('Y');
        $latestCaissier = Caissier::where('Caissier_ID', 'like', "CAISS-$currentYear%")
            ->orderBy('Caissier_ID', 'desc')
            ->first();
        $newCaissierNumber = $latestCaissier ? ((int)substr($latestCaissier->Caissier_ID, -5) + 1) : 1;
        return "CAISS-$currentYear-" . str_pad($newCaissierNumber, 5, '0', STR_PAD_LEFT);
    }
}