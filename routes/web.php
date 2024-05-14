<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    MovementController,
    SelfcostController,
    PurchaseController,
    WorktypeController,
    CategoryController,
    CehtypeController,
    WorkerController,
    AdminsController,
    ChartController,
    ColorController,
    ImageController,
    RolesController,
    UnitController,
    ItemController,
    CehController,
    PayController,
};


Route::get('/', function () { return view('welcome');});

Route::get( '/cehtypes',                [CehtypeController::class, 'view']);
Route::post('/cehtypes/add',            [CehtypeController::class, 'add']);
Route::post('/cehtypes/update/{id}',    [CehtypeController::class, 'edit']);
Route::get( '/cehtypes/delete/{id}',    [CehtypeController::class, 'delete']);

Route::get( '/cehs',                    [CehController::class,      'view']);
Route::post('/cehs/add',                [CehController::class,      'add']);
Route::post('/cehs/update/{id}',        [CehController::class,      'edit']);
Route::get( '/cehs/delete/{id}',        [CehController::class,      'delete']);

Route::get( '/units',                   [UnitController::class,     'view']);
Route::post('/units/add',               [UnitController::class,     'add']);
Route::post('/units/update/{id}',       [UnitController::class,     'edit']);
Route::get( '/units/delete/{id}',       [UnitController::class,     'delete']);

Route::get( '/colors',                  [ColorController::class,    'view']);
Route::post('/colors/add',              [ColorController::class,    'add']);
Route::post('/colors/update/{id}',      [ColorController::class,    'edit']);
Route::get( '/colors/delete/{id}',      [ColorController::class,    'delete']);

Route::get( '/categoryes',              [CategoryController::class,    'view']);
Route::post('/categoryes/add',          [CategoryController::class,    'add']);
Route::post('/categoryes/update/{id}',  [CategoryController::class,    'edit']);
Route::get( '/categoryes/delete/{id}',  [CategoryController::class,    'delete']);

Route::get( '/items',                   [ItemController::class,     'items']);
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
Route::post('/workers/check/{id}',      [WorkerController::class,   'check']);
Route::get( '/workers/delete/{id}',     [WorkerController::class,   'delete']);

Route::get('/purchases',                    [PurchaseController::class, 'view']);
Route::get( '/purchases/new',               [PurchaseController::class, 'new']);
Route::post('/purchases/add',               [PurchaseController::class, 'add']);
Route::get( '/purchases/edit/{id}',         [PurchaseController::class, 'edit']);
Route::post('/purchases/update/{id}',       [PurchaseController::class, 'update']);
Route::get( '/purchases/arhivate',          [PurchaseController::class, 'archivate']);
Route::get( '/purchases/materials',         [PurchaseController::class, 'material_ceh']);
Route::post('/purchases/materials/update',  [PurchaseController::class, 'ceh_update']);

Route::get( '/roles',               [RolesController::class, 'view']);
Route::get( '/roles/new',           [RolesController::class, 'new']);
Route::post('/roles/add',           [RolesController::class, 'add']);
Route::get( '/roles/edit/{id}',     [RolesController::class, 'edit']);
Route::post('/roles/update/{id}',   [RolesController::class, 'update']);
Route::get( '/roles/delete/{id}',   [RolesController::class, 'delete']);

Route::get( '/admins',                 [AdminsController::class,   'view']);
Route::get( '/admins/new',             [AdminsController::class,   'new']);
Route::post('/admins/add',             [AdminsController::class,   'add']);
Route::get( '/admins/edit/{id}',       [AdminsController::class,   'edit']);
Route::post('/admins/update/{id}',     [AdminsController::class,   'update']);
Route::post('/admins/check/{id}',      [AdminsController::class,   'check']);
Route::get( '/admins/delete/{id}',     [AdminsController::class,   'delete']);

Route::get('/pay',                  [PayController::class,      'view']);
Route::get('/pay/{id}',             [PayController::class,      'byworker']);

Route::get('/remains',              [MovementController::class, 'view']);
Route::get('/movement',             [MovementController::class, 'movement']);
Route::get('/production',           [MovementController::class, 'production']);
Route::get('/movement/delete/{id}', [MovementController::class, 'delete']);

Route::get('/cost',                 [SelfcostController::class, 'view']);

Route::get('/worktime',             [ChartController::class, 'hours']);

Route::get('/images/{name}',         [ImageController::class, 'view']);