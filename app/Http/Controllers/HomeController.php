<?php

namespace App\Http\Controllers;

use App\Gerant;
use App\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gerants = Gerant::all(); 
        $gerants = Gerant::count();
        $companies = Company::count();

        $widget = [
            'gerants' => $gerants,
            'companies' => $companies,
        ];

        return view('home', compact('widget'));
    }
}
