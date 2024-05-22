<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use App\Program;
use App\Caissier;
use Illuminate\Http\Request;
use App\Gerant;

class HomeGerantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('gerant-auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clientsCount = Client::count();
        $caissiersCount = Caissier::count();
        $programsCount = Program::count();
        $offersCount = Offer::count();
        

        $widget = [
            'caissiersCount' => $caissiersCount,
            'clientsCount' => $clientsCount,
            'programsCount' => $programsCount,
            'offersCount' => $offersCount,
            // Add more widget data if needed
        ];

        return view('home_gerant', compact('widget'));
    }
}