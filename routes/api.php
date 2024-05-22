<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;


Route::post('/login',       [ApiController::class, 'login']);
Route::post('/register',    [ApiController::class, 'register']);
Route::get( '/cehs',        [ApiController::class, 'cehs']);
Route::post('/roles',       [ApiController::class, 'roles']);
Route::post('/items',       [ApiController::class, 'items']);
Route::get( '/colors',      [ApiController::class, 'colors']);
Route::post('/transtypes',  [ApiController::class, 'transtypes']);
Route::post('/transaction', [ApiController::class, 'transact']);
Route::post('/worktime',    [ApiController::class, 'worktime']);
Route::post('/workers',     [ApiController::class, 'workers']);
Route::post('/profile',     [ApiController::class, 'editworker']);
Route::post('/produced',    [ApiController::class, 'produced']);
Route::post('/transaction/edit',    [ApiController::class, 'edittrans']);
// Route::post('/hours',       [ApiController::class, 'hours']);


Route::post('/chart/hours',     [ApiController::class, 'hours_chart']);
Route::post('/chart/payment',   [ApiController::class, 'pay_chart']);
Route::post('/chart/items',     [ApiController::class, 'items_chart']);