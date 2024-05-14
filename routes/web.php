<?php

use App\CarteFidelite;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CarteFideliteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileCaissierController;
use App\Http\Controllers\ProfileGerantController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login',[AuthController::class,'login'])->name('login');
//Route::post('/login',[AuthController::class,'login'])->name('sign');
Route::get('/home', 'HomeController@index')->name('home');




Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');




Route::get('/companies/{company}/edit_company', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('companies.edit_company');
Route::patch('/companies/{company}', [\App\Http\Controllers\CompanyController::class, 'update'])->name('companies.update');
Route::delete('/companies/{company}', [\App\Http\Controllers\CompanyController::class, 'destroy'])->name('companies.destroy');


Route::middleware('auth')->group(function() {
    Route::get('/basic/{company}/edit', 'BasicController@edit')->name('basic.edit');
    Route::resource('basic', BasicController::class);
    Route::resource('companies', CompanyController::class);

});

Route::get('/home_caissier', 'HomeCaissierController@index')->name('home_caissier');

Route::get('/clients', 'ClientController@index')->name('clients.index');
Route::get('/clients/create', 'ClientController@create')->name('clients.create');
Route::post('/clients', 'ClientController@store')->name('clients.store');
Route::get('/clients/{client}/edit', 'ClientController@edit')->name('clients.edit');
Route::put('/clients/{client}', 'ClientController@update')->name('clients.update');
Route::delete('/clients/{client}', 'ClientController@destroy')->name('clients.destroy');

Route::get('/profileCaissier', 'ProfileCaissierController@index')->name('profileCaissier'); // STILL NEED ADJUSMTENTS IN CONTROLLERS
Route::put('/profileCaissier', 'ProfileCaissierController@update')->name('profileCaissier.update'); // STILL NEED ADJUSMTENTS IN CONTROLLERS

Route::get('/carte-fidelite', 'CarteFideliteController@index')->name('carte_fidelite.index');
Route::get('/carte-fidelite/create', 'CarteFideliteController@create')->name('carte_fidelite.create');
Route::post('/carte-fidelite', 'CarteFideliteController@store')->name('carte_fidelite.store');
Route::get('/carte-fidelite/{carte}/edit', 'CarteFideliteController@edit')->name('carte_fidelite.edit');
Route::put('/carte_fidelite/{carte}', 'CarteFideliteController@update')->name('carte_fidelite.update');
Route::delete('/carte_fidelite/{carte}', 'CarteFideliteController@destroy')->name('carte_fidelite.destroy');


Route::get('/transactions', 'TransactionController@index')->name('transactions.index');
Route::get('/transactions/create', 'TransactionController@create')->name('transactions.create');
Route::post('/transactions', 'TransactionController@store')->name('transactions.store');
Route::get('/transactions/{transaction}/edit', 'TransactionController@edit')->name('transactions.edit');
Route::put('/transactions/{transaction}', 'TransactionController@update')->name('transactions.update');
Route::delete('/transactions/{transaction}', 'TransactionController@destroy')->name('transactions.destroy');




Route::get('/home_gerant', 'HomeGerantController@index')->name('home_gerant');

Route::get('/profileGerant', 'ProfileGerantController@index')->name('profileGerant'); // STILL NEED ADJUSMTENTS IN CONTROLLERS
Route::put('/profileGerant', 'ProfileGerantController@update')->name('profileGerant.update'); // STILL NEED ADJUSMTENTS IN CONTROLLERS

Route::get('/gerant-programs', 'GerantProgramsController@index')->name('gerantPrograms.index');
Route::get('/gerant-clients', 'GerantClientsController@index')->name('gerantClients.index');
Route::get('/gerant-offers', 'GerantOffersController@index')->name('gerantOffers.index');

//gerant clients
Route::get('gerant-clients/create', 'GerantClientsController@create')->name('gerantClients.create');
Route::post('gerant-clients/client', 'GerantClientsController@store')->name('gerantClients.store');
Route::get('/gerant-clients/{client}/edit', 'GerantClientsController@edit')->name('gerantClients.edit');
Route::put('/gerant-clients/{client}', 'GerantClientsController@update')->name('gerantClients.update');
Route::delete('/gerant-clients/{client}', 'GerantClientsController@destroy')->name('gerantClients.destroy');

//gerant program
Route::get('gerant-programs/create', 'GerantProgramsController@create')->name('gerantPrograms.create');
Route::post('gerant-programs/program', 'GerantProgramsController@store')->name('gerantPrograms.store');
Route::get('/gerant-programs/{program}/edit', 'GerantProgramsController@edit')->name('gerantPrograms.edit');
Route::put('/gerant-programs/{program}', 'GerantProgramsController@update')->name('gerantPrograms.update');
Route::delete('/gerant-programs/{program}', 'GerantProgramsController@destroy')->name('gerantPrograms.destroy');

//inactive programs page 
Route::get('/gerant-programs/inactive', 'GerantProgramsController@inactive')->name('gerantPrograms.inactive');
Route::put('/gerant-programs/activate/{program}', 'GerantProgramsController@activate')->name('gerantPrograms.activate');
Route::put('/gerantPrograms/{program}/toggle-status', 'GerantProgramsController@toggleStatus')->name('gerantPrograms.toggleStatus');

//gerant carte fidelite page 
Route::get('/gerant-carte-fidelite', 'GerantCarteFideliteController@index')->name('gerantCF.index');
Route::get('/gerant-carte-fidelite/create', 'GerantCarteFideliteController@create')->name('gerantCF.create');
Route::post('/gerant-carte-fidelite', 'GerantCarteFideliteController@store')->name('gerantCF.store');
Route::get('/gerant-carte-fidelite/{carte}/edit', 'GerantCarteFideliteController@edit')->name('gerantCF.edit');
Route::put('/gerant-carte_fidelite/{carte}', 'GerantCarteFideliteController@update')->name('gerantCF.update');
Route::delete('/gerant-carte_fidelite/{carte}', 'GerantCarteFideliteController@destroy')->name('gerantCF.destroy');

// routes/web.php for search
Route::get('/search/companies', 'CompanyController@search')->name('search_companies');









