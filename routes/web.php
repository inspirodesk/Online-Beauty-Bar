<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PrintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::resources([
    'home' => HomeController::class,
    'roles' => RoleController::class,
    'users' => UserController::class,
    'permissions' => PermissionController::class,
    'settings' => SettingController::class,
    'pages' => PageController::class,
    'sales' => SaleController::class,
    'orders' => OrderController::class,
    'notes'=>NoteController::class,
    'prints'=>PrintController::class
]);

Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image')->middleware('web');
// routes/web.php
Route::get('/sync-orders', [OrderController::class, 'syncOrders']);
Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::patch('/sales/{id}/status', [SaleController::class, 'updateStatus'])->name('sales.updateStatus');
Route::get('/orders/status/{status}', [OrderController::class, 'showByStatus'])->name('orders.byStatus');
Route::get('notes/search', [NoteController::class, 'search'])->name('notes.search');
Route::patch('sales/{id}/block', [SaleController::class, 'block'])->name('sales.block');
Route::get('/block-list', [SaleController::class, 'blockList'])->name('sales.blockList');
Route::delete('/sales/{id}', [SaleController::class, 'deleteUser'])->name('sales.deleteUser');

