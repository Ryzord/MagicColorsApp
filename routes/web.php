<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorCombinationController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/combination/by-colors', [ColorCombinationController::class, 'findByColors']);

Route::get('/combination/by-name', [ColorCombinationController::class, 'findByName']);

Route::get('/offline', function() {
    return view('vendor.laravelpwa.offline');
});
