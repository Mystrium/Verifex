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
    AuthController,
    CehController,
    PayController,
};

Route::get('/', function () { return view('auth/login'); })->name('login');

Route::post('login',    [AuthController::class, 'login']);
Route::get( 'register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'adduser']);

Route::middleware('auth')->group(function () {
    Route::get( 'logout',   [AuthController::class, 'logout']);

    Route::prefix('cehtypes')->middleware('access:cehtypes')->group(function () {
        Route::get( '/',                [CehtypeController::class, 'view']);
        Route::post('add',              [CehtypeController::class, 'add']);
        Route::post('update/{id}',      [CehtypeController::class, 'edit']);
        Route::get( 'delete/{id}',      [CehtypeController::class, 'delete']);
    });

    Route::prefix('cehs')->middleware('access:cehs')->group(function () {
        Route::get( '/',                [CehController::class,      'view']);
        Route::post('/add',             [CehController::class,      'add']);
        Route::post('/update/{id}',     [CehController::class,      'edit']);
        Route::get( '/delete/{id}',     [CehController::class,      'delete']);
    });

    Route::prefix('units')->middleware('access:units')->group(function () {
        Route::get( '/',                [UnitController::class,     'view']);
        Route::post('/add',             [UnitController::class,     'add']);
        Route::post('/update/{id}',     [UnitController::class,     'edit']);
        Route::get( '/delete/{id}',     [UnitController::class,     'delete']);
    });

    Route::prefix('colors')->middleware('access:colors')->group(function () {
        Route::get( '/',                [ColorController::class,    'view']);
        Route::post('/add',             [ColorController::class,    'add']);
        Route::post('/update/{id}',     [ColorController::class,    'edit']);
        Route::get( '/delete/{id}',     [ColorController::class,    'delete']);
    });

    Route::prefix('categoryes')->middleware('access:categoryes')->group(function () {
        Route::get( '/',                [CategoryController::class,    'view']);
        Route::post('/add',             [CategoryController::class,    'add']);
        Route::post('/update/{id}',     [CategoryController::class,    'edit']);
        Route::get( '/delete/{id}',     [CategoryController::class,    'delete']);
    });

    Route::prefix('items')->middleware('access:items')->group(function () {
        Route::get( '/',                [ItemController::class,     'items']);
        Route::get( '/new',             [ItemController::class,     'new']);
        Route::post('/add',             [ItemController::class,     'add']);
        Route::get( '/edit/{id}',       [ItemController::class,     'edit']);
        Route::post('/update/{id}',     [ItemController::class,     'update']);
        Route::get( '/delete/{id}',     [ItemController::class,     'delete']);
    });

    Route::prefix('worktypes')->middleware('access:worktypes')->group(function () {
        Route::get( '/',                [WorktypeController::class, 'view']);
        Route::get( '/new',             [WorktypeController::class, 'new']);
        Route::post('/add',             [WorktypeController::class, 'add']);
        Route::get( '/edit/{id}',       [WorktypeController::class, 'edit']);
        Route::post('/update/{id}',     [WorktypeController::class, 'update']);
        Route::get( '/delete/{id}',     [WorktypeController::class, 'delete']);
    });

    Route::prefix('workers')->middleware('access:workers')->group(function () {
        Route::get( '/',                [WorkerController::class,   'view']);
        Route::get( '/new',             [WorkerController::class,   'new']);
        Route::post('/add',             [WorkerController::class,   'add']);
        Route::get( '/edit/{id}',       [WorkerController::class,   'edit']);
        Route::post('/update/{id}',     [WorkerController::class,   'update']);
        Route::post('/check/{id}',      [WorkerController::class,   'check']);
        Route::get( '/delete/{id}',     [WorkerController::class,   'delete']);
    });

    Route::prefix('purchases')->middleware('access:purchases')->group(function () {
        Route::get( '/',                [PurchaseController::class, 'view']);
        Route::get( '/new',             [PurchaseController::class, 'new']);
        Route::post('/add',             [PurchaseController::class, 'add']);
        Route::get( '/edit/{id}',       [PurchaseController::class, 'edit']);
        Route::post('/update/{id}',     [PurchaseController::class, 'update']);
        Route::get( '/arhivate',        [PurchaseController::class, 'archivate']);
        Route::get( '/materials',       [PurchaseController::class, 'material_ceh']);
        Route::post('/materials/update',[PurchaseController::class, 'ceh_update']);
    });

    Route::prefix('roles')->middleware('access:roles')->group(function () {
        Route::get( '/',                [RolesController::class, 'view']);
        Route::get( '/new',             [RolesController::class, 'new']);
        Route::post('/add',             [RolesController::class, 'add']);
        Route::get( '/edit/{id}',       [RolesController::class, 'edit']);
        Route::post('/update/{id}',     [RolesController::class, 'update']);
        Route::get( '/delete/{id}',     [RolesController::class, 'delete']);
    });

    Route::prefix('admins')->middleware('access:admins')->group(function () {
        Route::get( '/',                [AdminsController::class,   'view']);
        Route::get( '/new',             [AdminsController::class,   'new']);
        Route::post('/add',             [AdminsController::class,   'add']);
        Route::get( '/edit/{id}',       [AdminsController::class,   'edit']);
        Route::post('/update/{id}',     [AdminsController::class,   'update']);
        Route::post('/check/{id}',      [AdminsController::class,   'check']);
        Route::get( '/delete/{id}',     [AdminsController::class,   'delete']);
    });
    Route::get( '/profile',             [AdminsController::class,   'profile']);
    Route::post('/profile',             [AdminsController::class,   'saveprofile']);

    Route::prefix('pay')->middleware('access:pay')->group(function () {
        Route::get('/',                 [PayController::class,      'view']);
        Route::get('/{id}',             [PayController::class,      'byworker']);
    });

    Route::get('/remains',              [MovementController::class, 'view'])->middleware('access:remains');
    Route::get('/movement',             [MovementController::class, 'movement'])->middleware('access:movement');
    Route::get('/production',           [MovementController::class, 'production'])->middleware('access:production');

    Route::get('/cost',                 [SelfcostController::class, 'view'])->middleware('access:cost');

    Route::get('/worktime',             [ChartController::class, 'hours']);

    Route::get('/images/{name}',        [ImageController::class, 'view']);
});