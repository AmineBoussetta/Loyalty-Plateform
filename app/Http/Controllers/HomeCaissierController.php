<?php
// DISPLAYS CLIENTS AND FIDELITY CARDS INFORMTIONS IN THE DASHBOARD STILL NOT MODIFIED AND SHARE THE "USER COUNTS"
namespace App\Http\Controllers;

use App\User;
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
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        return view('home_caissier', compact('widget'));
    }
}
