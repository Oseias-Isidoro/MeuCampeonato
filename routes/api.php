<?php

use Illuminate\Http\Request;
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

Route::resource('leagues', \App\Http\Controllers\api\LeagueController::class);

Route::resource('teams', \App\Http\Controllers\api\LeagueTeamController::class)->except(['store']);
Route::post('league/{league}/teams', [\App\Http\Controllers\api\LeagueTeamController::class, 'store']);

Route::resource('matches', \App\Http\Controllers\api\LeagueMatchController::class)->except(['store', 'update', 'edit', 'delete']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
