<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;


Route::post('/login',       [ApiController::class, 'login']);
Route::post('/register',    [ApiController::class, 'register']);
Route::get( '/cehs',        [ApiController::class, 'cehs']);
Route::post('/roles',       [ApiController::class, 'roles']);
Route::post('/items',       [ApiController::class, 'items']);
Route::get( '/colors',      [ApiController::class, 'colors']);
Route::get( '/transtypes',  [ApiController::class, 'transtypes']);
Route::post('/transact',    [ApiController::class, 'transact']);
Route::post('/worktime',    [ApiController::class, 'worktime']);
Route::post('/workers',     [ApiController::class, 'workers']);

Route::post('/chart/hours', [ApiController::class, 'hours_chart']);
Route::post('/chart/pay',   [ApiController::class, 'pay_chart']);
Route::post('/chart/items', [ApiController::class, 'items_chart']);