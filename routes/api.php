<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login',       [ApiController::class, 'login']);
Route::post('/register',    [ApiController::class, 'register']);
Route::get( '/cehs',        [ApiController::class, 'cehs']);
Route::post('/roles',       [ApiController::class, 'roles']);
Route::post('/items',       [ApiController::class, 'items']);
Route::get( '/colors',      [ApiController::class, 'colors']);
Route::get( '/transtypes',  [ApiController::class, 'transtypes']);
Route::post('/transact',    [ApiController::class, 'transact']);
Route::post('/worktime',    [ApiController::class, 'worktime']);