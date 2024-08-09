<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/jobs', [JobController::class, 'index']);
Route::post('/create-job', [JobController::class, 'store']);
Route::get('/edit-job/{id}', [JobController::class, 'edit', 'id']);
Route::put('/edit-job', [JobController::class, 'update']);
Route::delete('/delete-job', [JobController::class, 'delete']);
