<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UsuarioController::class)->group(function(){
   Route:: get('/usuarios', 'index');
   Route::post('/usuarios', 'store');
   Route::get('/usuarios/{id}', 'show');
});

Route::controller(TransactionController::class)->group(function(){
    Route:: get('/transactions', 'index');
    Route::post('/transactions', 'store');
 });