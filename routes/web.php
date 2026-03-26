<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;


Route::get('/', function () {
    return view('welcome');
});




Route::get('/', [FundController::class, 'index']);
Route::post('/save-donation', [FundController::class, 'saveDonation']);

Route::get('/admin', [FundController::class, 'admin']);
Route::post('/admin/fund/store', [FundController::class, 'store']);
Route::get('/admin/fund/delete/{id}', [FundController::class, 'delete']);



Route::get('/', [FundController::class, 'index']);
