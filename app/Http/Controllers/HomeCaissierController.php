<?php
// DISPLAYS CLIENTS AND FIDELITY CARDS INFORMTIONS IN THE DASHBOARD STILL NOT MODIFIED AND SHARE THE "USER COUNTS"
namespace App\Http\Controllers;

use App\CarteFidelite;
use App\User;
use App\Client;
use Illuminate\Http\Request;

class HomeCaissierController extends Controller
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
        $clientsCount = Client::count();
        $cardsCount = CarteFidelite::count();

        $widget = [
            'clientsCount' => $clientsCount,
            'cardsCount' => $cardsCount,
            // Add more widget data if needed
        ];

        return view('home_caissier', compact('widget'));
    }
}
