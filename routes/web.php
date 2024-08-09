<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/jobs', [JobController::class, 'index']);
Route::post('/create-job', [JobController::class, 'store']);
