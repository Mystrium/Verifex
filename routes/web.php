<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    MovementController,
    PayController,
    SelfcostController,
    PurchaseController,
    WorktypeController,
    CehtypeController,
    WorkerController,
    ColorController,
    UnitController,
    ItemController,
    CehController,
};


Route::get('/', function () { return view('welcome');});

Route::get( '/cehtypes',                [CehtypeController::class, 'view']);
Route::post('/cehtypes/add',            [CehtypeController::class, 'addType']);
Route::post('/cehtypes/update/{id}',    [CehtypeController::class, 'editType']);
Route::get( '/cehtypes/delete/{id}',    [CehtypeController::class, 'deleteType']);

Route::get( '/cehs',                    [CehController::class,      'view']);
Route::post('/cehs/add',                [CehController::class,      'addCeh']);
Route::post('/cehs/update/{id}',        [CehController::class,      'editCeh']);
Route::get( '/cehs/delete/{id}',        [CehController::class,      'deleteCeh']);

Route::get( '/units',                   [UnitController::class,     'view']);
Route::post('/units/add',               [UnitController::class,     'add']);
Route::post('/units/update/{id}',       [UnitController::class,     'edit']);
Route::get( '/units/delete/{id}',       [UnitController::class,     'delete']);

Route::get( '/colors',                  [ColorController::class,    'view']);
Route::post('/colors/add',              [ColorController::class,    'add']);
Route::post('/colors/update/{id}',      [ColorController::class,    'edit']);
Route::get( '/colors/delete/{id}',      [ColorController::class,    'delete']);

Route::get( '/items',                   [ItemController::class,     'view']);
Route::get( '/items/new',               [ItemController::class,     'new']);
Route::post('/items/add',               [ItemController::class,     'add']);
Route::get( '/items/edit/{id}',         [ItemController::class,     'edit']);
Route::post('/items/update/{id}',       [ItemController::class,     'update']);
Route::get( '/items/delete/{id}',       [ItemController::class,     'delete']);

Route::get( '/worktypes',               [WorktypeController::class, 'view']);
Route::get( '/worktypes/new',           [WorktypeController::class, 'new']);
Route::post('/worktypes/add',           [WorktypeController::class, 'add']);
Route::get( '/worktypes/edit/{id}',     [WorktypeController::class, 'edit']);
Route::post('/worktypes/update/{id}',   [WorktypeController::class, 'update']);
Route::get( '/worktypes/delete/{id}',   [WorktypeController::class, 'delete']);

Route::get( '/workers',                 [WorkerController::class,   'view']);
Route::get( '/workers/new',             [WorkerController::class,   'new']);
Route::post('/workers/add',             [WorkerController::class,   'add']);
Route::get( '/workers/edit/{id}',       [WorkerController::class,   'edit']);
Route::post('/workers/update/{id}',     [WorkerController::class,   'update']);
Route::get( '/workers/delete/{id}',     [WorkerController::class,   'delete']);

Route::get('/purchases',            [PurchaseController::class, 'view']);
Route::post('/purchases/add',       [PurchaseController::class, 'add']);

Route::get('/pay',                  [PayController::class,      'view']);
Route::get('/pay/{id}',             [PayController::class,      'byworker']);

Route::get('/movement',             [MovementController::class, 'view']);

Route::get('/cost',                 [SelfcostController::class, 'view']);

