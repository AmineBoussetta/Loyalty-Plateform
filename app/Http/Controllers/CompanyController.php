<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\AddCompanyRequest;
use App\Http\Requests\EditCompanyRequest;
use Illuminate\Support\Facades\Auth;
use App\Gerant;

use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    // Other methods...

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('gerants')->paginate(10);
        return view('companies.list_company', [
            'title' => 'Company List',
            'companies' => $companies
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    // Fetch currencies data
    $currencies = $this->currencies();

    return view('companies.create_company', [
        'title' => 'New Company',
        'companies' => Company::paginate(10),
        'currencies' => $currencies,
    ]);
}

    

    public function store(AddCompanyRequest $request)
    {
        // Create the company
        $company = Company::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'default_currency' => $request->default_currency,
            'country' => $request->country,
            'tax_id' => $request->tax_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
        ]);
    
        // Create gerants for the company
        if ($request->has('gerant_name')) {
            $gerantsData = $request->only(['gerant_name', 'gerant_email', 'gerant_phone']);
            $gerants = [];
    
            // Prepare gerants data
            foreach ($gerantsData['gerant_name'] as $key => $gerantName) {
                $gerants[] = [
                    'name' => $gerantName,
                    'email' => $gerantsData['gerant_email'][$key],
                    'phone' => $gerantsData['gerant_phone'][$key],
                ];
            }
    
            // Create gerants associated with the company
            $company->gerants()->createMany($gerants);
        }
    
        return redirect()->route('companies.index')->with('message', 'Company added successfully!');
    }
    
    
    
    
    public function edit(Company $company)
{
    $company->load('gerants'); 
    
    return view('companies.edit_company', [
        'title' => 'Edit Company',
        'company' => $company
    ]);
}


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCompanyRequest $request, Company $company)
{
    
    // Log the company details
    error_log('Company details: ' . print_r($company->toArray(), true));
    // Update company details
    $company->update([
        'name' => $request->name,
        'abbreviation' => $request->abbreviation,
        'default_currency' => $request->default_currency,
        'country' => $request->country,
        'tax_id' => $request->tax_id,
        'phone' => $request->phone,
        'email' => $request->email,
        'website' => $request->website,
        'description' => $request->description,
    ]);
    
    // Update or add gerants
    if ($request->has('gerant_name')) {
        $company->gerants()->delete(); // Delete all gerants associated with the company
        foreach ($request->gerant_name as $index => $gerantName) {
            // Create a new gerant
            $gerant = new Gerant;
            $gerant->fill([
                'name' => $request->gerant_name[$index],
                'email' => $request->gerant_email[$index],
                'phone' => $request->gerant_phone[$index],
                'company_id' => $company->id // Ensure the gerant is associated with the company
            ]);
            $gerant->save(); // Save the gerant
        }
    }
    return redirect()->route('companies.index')->with('message', 'Company updated successfully!');
}

    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
{
    // Check if the authenticated user is trying to delete their own company
    if (Auth::id() == $company->id) {
        return redirect()->route('companies.index')->with('warning', 'You cannot delete your own company!');
    }

    // Delete the company
    $company->delete();

    return redirect()->route('companies.index')->with('message', 'Company deleted successfully!');
}

public function show($id)
{
    $company = Company::findOrFail($id);
    return view('company.show', compact('company'));
}


public function currencies()
{
    // Fetch a list of currencies
    $currencies = [
        'TND' => 'Tunisian Dinar',
        'USD' => 'United States Dollar',
        'EUR' => 'Euro',
        'JPY' => 'Japanese Yen',
        'GBP' => 'British Pound Sterling',
        'AUD' => 'Australian Dollar',
        'CAD' => 'Canadian Dollar',
        'CHF' => 'Swiss Franc',
        'CNY' => 'Chinese Yuan',
        'SEK' => 'Swedish Krona',
    ];
    
    return $currencies;
}

public function search(Request $request)
{
    $query = $request->input('query');
    $results = Company::where('name', 'like', "%{$query}%")->get();

    $companies = [];
    foreach ($results as $company) {
        $companies[] = [
            'id' => $company->id,
            'name' => $company->name,
            'managers' => $company->gerants->pluck('name')->toArray(), // Assuming 'gerants' is the relationship
            'actions' => ['edit', 'delete'] // Example actions
        ];
    }

    return response()->json($companies);
}



}
