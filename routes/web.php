<?php

use App\CarteFidelite;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CarteFideliteController;


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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::resource('companies', CompanyController::class);
Route::get('/companies/{company}/edit_company', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('companies.edit_company');

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

Route::get('/profileCaissier', 'ProfileController@index')->name('profileCaissier'); // STILL NEED ADJUSMTENTS IN CONTROLLERS
Route::put('/profileCaissier', 'ProfileController@update')->name('profileCaissier.update'); // STILL NEED ADJUSMTENTS IN CONTROLLERS

Route::get('/carte-fidelite', 'CarteFideliteController@index')->name('carte_fidelite.index');
Route::get('/carte-fidelite/create', 'CarteFideliteController@create')->name('carte_fidelite.create');
Route::post('/carte-fidelite', 'CarteFideliteController@store')->name('carte_fidelite.store');
Route::get('/carte-fidelite/{carte_fidelite}/edit', 'CarteFideliteController@edit')->name('carte_fidelite.edit');

// Route::put('/clients/{client}', 'ClientController@update')->name('clients.update');

Route::delete('/carte_fidelite/{id}', 'CarteFideliteController@destroy')->name('carte_fidelite.destroy');






