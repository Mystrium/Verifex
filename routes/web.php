<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorktypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CehtypeController;
use App\Http\Controllers\CehController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ItemController;


Route::get('/', function () { return view('welcome');});

Route::get('/cehtypes', [CehtypeController::class, 'view']);
Route::post('/cehtypes/add', [CehtypeController::class, 'addType']);
Route::post('/cehtypes/update/{id}', [CehtypeController::class, 'editType']);
Route::get('/cehtypes/delete/{id}', [CehtypeController::class, 'deleteType']);

Route::get('/cehs', [CehController::class, 'view']);
Route::post('/cehs/add', [CehController::class, 'addCeh']);
Route::post('/cehs/update/{id}', [CehController::class, 'editCeh']);
Route::get('/cehs/delete/{id}', [CehController::class, 'deleteCeh']);

Route::get('/units', [UnitController::class, 'view']);
Route::post('/units/add', [UnitController::class, 'add']);
Route::post('/units/update/{id}', [UnitController::class, 'edit']);
Route::get('/units/delete/{id}', [UnitController::class, 'delete']);

Route::get('/colors', [ColorController::class, 'view']);
Route::post('/colors/add', [ColorController::class, 'add']);
Route::post('/colors/update/{id}', [ColorController::class, 'edit']);
Route::get('/colors/delete/{id}', [ColorController::class, 'delete']);

Route::get('/items', [ItemController::class, 'view']);
Route::post('/items/add', [ItemController::class, 'add']);
Route::post('/items/update/{id}', [ItemController::class, 'edit']);
Route::get('/items/delete/{id}', [ItemController::class, 'delete']);

Route::get('/worktypes', [WorktypeController::class, 'view']);
Route::post('/worktypes/add', [WorktypeController::class, 'add']);
Route::post('/worktypes/update/{id}', [WorktypeController::class, 'edit']);
Route::get('/worktypes/delete/{id}', [WorktypeController::class, 'delete']);

Route::get('/workers', [WorkerController::class, 'view']);
Route::post('/workers/add', [WorkerController::class, 'add']);
Route::post('/workers/update/{id}', [WorkerController::class, 'edit']);
Route::get('/workers/delete/{id}', [WorkerController::class, 'delete']);

Route::get('/purchases', [PurchaseController::class, 'view']);
Route::post('/purchases/add', [PurchaseController::class, 'add']);