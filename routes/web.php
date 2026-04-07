<?php


use App\Http\Controllers\BikeSystemController;
Route::get('/', function () {
    return view('welcome');
});

// Rutas para el sistema de bicicletas
Route::get('stations', [BikeSystemController::class, 'listStations']);
Route::get('bikes/{bike}', [BikeSystemController::class, 'showBike']);
Route::get('list-journeys/{user}', [BikeSystemController::class, 'listJourneys']);
Route::get('start-journey/{user}/{bike}', [BikeSystemController::class, 'startJourney']);
Route::get('end-journey/{user}/{station}', [BikeSystemController::class, 'endJourney']);
