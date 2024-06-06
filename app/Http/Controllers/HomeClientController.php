<?php

namespace App\Http\Controllers;


use App\Client;
use Illuminate\Support\Facades\DB;
use App\CarteFidelite;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeClientController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client-auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


     public function index()
     {
        $clientsDataQuery = Client::where('email',Auth::user()->email)
                        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        
                        ->groupBy('month');
        $moneySpentMonthlyQuery = Transaction::where('client_id',Auth::user()->id)->select(
        DB::raw('DATE_FORMAT(amount, "%Y-%m") as month'),
        DB::raw('SUM(amount_spent) as total_money_spent')
        )                
                    ->groupBy('month'); 

        $moneySpentMonthly = $moneySpentMonthlyQuery->get()->map(function ($item) {
        // Convert the month to month name
            $item->month = Carbon::createFromFormat('Y-m', $item->month)->formatLocalized('%B');
            return $item;
        });
        $pointsSumArrays = CarteFidelite::where('holder_id', Auth::user()->id)->get();


        
        $pointsData = [];
        foreach ($pointsSumArrays as $pointsSumArray) {
            $pointsData[] = [
                'points_sum' => $pointsSumArray->points_sum,
                
            ];
        }
        
        return view('home_client',[
            'moneySpentMonthly' => $moneySpentMonthly,
            'pointsData' => $pointsData,
         ]);
     } 
}
