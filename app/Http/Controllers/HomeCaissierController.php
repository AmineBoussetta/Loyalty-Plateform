<?php
// DISPLAYS CLIENTS AND FIDELITY CARDS INFORMTIONS IN THE DASHBOARD STILL NOT MODIFIED AND SHARE THE "USER COUNTS"
namespace App\Http\Controllers;

use App\CarteFidelite;
use App\User;
use App\Transaction;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeCaissierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('caissier-auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clientsCount = Client::where('company_id', Auth::user()->company_id)->count();
        $cardsCount = CarteFidelite::where('company_id', Auth::user()->company_id)->count();
        $transactionCount = Transaction::where('company_id', Auth::user()->company_id)->count();

        $widget = [
            'clientsCount' => $clientsCount,
            'cardsCount' => $cardsCount,
            'transactionCount'=> $transactionCount,
            // Add more widget data if needed
        ];

        return view('home_caissier', compact('widget'));
    }
}
