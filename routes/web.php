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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
});



