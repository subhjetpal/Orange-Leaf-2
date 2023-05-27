<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FuncController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// User
Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [UserController::class, 'login']);

Route::get('/register', function () {
    return view('login');
});

Route::post('/register', [UserController::class, 'register']);

// Route::get('/logout', function () {
//     Session::forget('user');
//     return redirect('index');
// });

Route::get('/logout', [UserController::class, 'logout']);

// Home

Route::get('/home', function () {
    return view('home.home');
});

Route::get('/view-trade/{TradeID}', [HomeController::class, 'viewTrade']);

Route::get('/open-trade', [HomeController::class, 'openTrade']);

Route::get('/performance', function () {
    return view('home.performance');
});

Route::get('/add-entry', function () {
    return view('home.add-entry');
});

Route::post('/add-entry', [HomeController::class, 'addEntry']);

Route::get('/calculator', function () {
    return view('home.calculator');
});

Route::get('/emi-calculator', function () {
    return view('home.emi-calculator');
});

Route::get('/modify-entry/{Order}/{TradeID}', [HomeController::class, 'modifyEntryFetch']);

Route::post('/modify-entry', [HomeController::class, 'modifyEntry']);

Route::get('/trade-journal', [HomeController::class, 'tradeJournal']);

Route::get('/trade-summary', [HomeController::class, 'tradeSummary']);

Route::get('/delete-entry/{TradeID}/{Order}', [HomeController::class, 'deleteEntry']);

// Functionality

Route::get('/check-script', 'UserController@checkEmailAvailability')->name('check.email');


