<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('candidates', CandidateController::class);
    Route::resource('interviews', InterviewController::class);
    Route::resource('client-requests', ClientRequestController::class);
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('client-requests/import', [ClientRequestController::class, 'import'])->name('client-requests.import');
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Chart / data endpoints
    Route::get('/dashboard/stats/overview', [DashboardController::class, 'overviewJson'])->name('dashboard.stats.overview');
    Route::get('/dashboard/stats/hiring-funnel', [DashboardController::class, 'hiringFunnelJson'])->name('dashboard.stats.funnel');
    Route::get('/dashboard/stats/candidates-trend', [DashboardController::class, 'candidatesTrendJson'])->name('dashboard.stats.candidates_trend');
    Route::get('/dashboard/stats/interviews-by-day', [DashboardController::class, 'interviewsByDayJson'])->name('dashboard.stats.interviews_by_day');
    // Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');


});


    Route::post('candidates/import', [CandidateController::class, 'import'])
    ->name('candidates.import')
    ->middleware('auth');

    Route::post('interviews/import', [InterviewController::class, 'import'])
    ->name('interviews.import')
    ->middleware('auth');


    
