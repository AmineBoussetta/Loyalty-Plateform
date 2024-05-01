<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use App\Offer;
use App\Program;
use Illuminate\Http\Request;

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
        $programsCount = Program::count();
        $offersCount = Offer::count();

        $widget = [
            'clientsCount' => $clientsCount,
            'programsCount' => $programsCount,
            'offersCount' => $offersCount,
            // Add more widget data if needed
        ];

        return view('home_gerant', compact('widget'));
    }
}

