<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('candidates', CandidateController::class);
});