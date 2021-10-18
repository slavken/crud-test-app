<?php

use App\Http\Controllers\API\Admin\BeerController as AdminBeerController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BeerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'token']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function () {
        Route::apiResource('beers', AdminBeerController::class)->except('show');
    });

Route::prefix('beers')->name('beers.')->group(function () {
    Route::get('/', [BeerController::class, 'index'])->name('index');
    Route::get('/{beer}', [BeerController::class, 'show'])->name('show');
});
