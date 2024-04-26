<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\AddCompanyRequest;
use App\Http\Requests\EditCompanyRequest;
use Illuminate\Support\Facades\Auth;
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
    return view('companies.list_company', [
        'title' => 'Company List',
        'companies' => Company::paginate(10)
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
    
        return view('companies.create_company', [
            'title' => 'New Company',
            'companies' => company::paginate(10)
        ]);
    }
    
    public function store(AddCompanyRequest $request)
    {
        Company::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'default_currency' => $request->default_currency,
            'country' => $request->country,
            'tax_id' => $request->tax_id,
            'managers' => $request->managers,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description
        ]);
    
        return redirect()->route('companies.index')->with('message', 'Company added successfully!');
    }
    
    
    public function edit(Company $company)
{
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
    $company->name = $request->name;
    $company->abbreviation = $request->abbreviation;
    $company->default_currency = $request->default_currency;
    $company->country = $request->country;
    $company->tax_id = $request->tax_id;
    $company->managers = $request->managers;
    $company->phone = $request->phone;
    $company->email = $request->email;
    $company->website = $request->website;
    $company->description = $request->description;

    $company->save();

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
        return redirect()->route('company.index')->with('warning', 'You cannot delete your own company!');
    }

    // Delete the company
    $company->delete();

    return redirect()->route('companies.index')->with('message', 'Company deleted successfully!');
}

}
