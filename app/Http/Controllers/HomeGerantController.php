<?php

namespace App\Http\Controllers;

use App\Client;
use App\CarteFidelite;
use App\Program;
use App\Transaction ;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Carbon;


class HomeGerantController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $companyId = Auth::user()->company_id;

        // Retrieve data from the database for clients
        $clientsDataQuery = Client::where('company_id',$companyId)
                        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        
                        ->groupBy('month');
        if ($startDate && $endDate) {
            $clientsDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $clientsData = $clientsDataQuery->get();

        // Retrieve data from the database for fidelity cards
        $fidelityCardsDataQuery = CarteFidelite::where('company_id',$companyId)
                        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        
                        ->groupBy('month');
        if ($startDate && $endDate) {
            $fidelityCardsDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $fidelityCardsData = $fidelityCardsDataQuery->get();

        // Retrieve top clients based on points_sum
        $topClients = CarteFidelite::select('holder_name', 'points_sum')->where('company_id',$companyId)
                        ->orderBy('points_sum', 'desc')
                        ->limit(10)
                        ->get();

        // Retrieve data for program cards usage
        $programsData = Program::where('company_id',$companyId)->withCount('carteFidelites')->get();

        // Retrieve data from the database for total money spent by clients per month
        $moneySpentMonthlyQuery = Transaction::select(
            DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
            DB::raw('SUM(amount_spent) as total_money_spent')
        )

        ->groupBy('month');
        if ($startDate && $endDate) {
            $moneySpentMonthlyQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        }
        $moneySpentMonthly = $moneySpentMonthlyQuery->get()->map(function ($item) {
            // Convert the month to month name
            $item->month = Carbon::createFromFormat('Y-m', $item->month)->formatLocalized('%B');
            return $item;
        });

        // Passing the data to the view
        return view('home_gerant', [
            'clientsData' => $clientsData,
            'fidelityCardsData' => $fidelityCardsData,
            'topClients' => $topClients,
            'programsData' => $programsData,
            'moneySpentMonthly' => $moneySpentMonthly,
        ]);
    }
}