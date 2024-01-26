<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FuncController;
use Illuminate\Support\Facades\Session;



// User
Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

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

Route::get('/emotion', function () {
    return view('home.emotion');
});

Route::get('/gallery', function () {
    return view('home.gallery');
});

Route::get('/emi-calculator', function () {
    return view('home.emi-calculator');
});

Route::get('/modify-entry/{Stage}/{Order}/{TradeID}', [HomeController::class, 'modifyEntryFetch']);

Route::post('/modify-entry', [HomeController::class, 'modifyEntry']);

Route::get('/is-closed/{TradeID}', [HomeController::class, 'isClosed']);

Route::get('/trade-journal', [HomeController::class, 'tradeJournal']);

Route::post('/trade-journal', [HomeController::class, 'tradeJournal']);

Route::get('/trade-summary', [HomeController::class, 'tradeSummary']);

Route::post('/trade-summary', [HomeController::class, 'tradeSummary']);

Route::get('/delete-entry/{TradeID}/{Order}', [HomeController::class, 'deleteEntry']);

Route::get('/risk-factor', [HomeController::class, 'riskFactor']);

Route::get('/add-journal', function () {
    return view('home.add-journal');
});

// Route::get('/template', function () {
//     return view('home.template');
// });
Route::get('/template', [HomeController::class, 'template']);

Route::post('/add-journal', [AccountController::class, 'addJournal']);

Route::post('/add-comment', [HomeController::class, 'addComment']);

// Functionality

Route::get('/check-script', 'UserController@checkEmailAvailability')->name('check.email');


