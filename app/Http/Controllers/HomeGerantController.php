<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use App\Program;
use Illuminate\Http\Request;
class HomeGerantController extends Controller
{
    public function index()
    {
        // Retrieve data from the database for clients
        $clientsData = Client::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->get();

        // Retrieve data from the database for fidelity cards
        $fidelityCardsData = CarteFidelite::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->get();

        // Retrieve top clients based on points_sum
        $topClients = CarteFidelite::select('holder_name', 'points_sum')
                        ->orderBy('points_sum', 'desc')
                        ->limit(10)
                        ->get();

        // Retrieve data for program cards usage
        $programsData = Program::withCount('carteFidelites')->get();

        // Pass the data to the view
        return view('home_gerant', [
            'clientsData' => $clientsData,
            'fidelityCardsData' => $fidelityCardsData,
            'topClients' => $topClients,
            'programsData' => $programsData,
        ]);
    }
}