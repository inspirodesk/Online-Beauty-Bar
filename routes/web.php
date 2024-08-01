<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ObituaryController;
use App\Http\Controllers\RememberenceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PageController;

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
    'roles' => RoleController::class,
    'users' => UserController::class,
    'newses' => NewsController::class,
    'sites' => SiteController::class,
    'categories' => CategoryController::class,
    'advertisements' => AdvertisementController::class,
    'obituaries' => ObituaryController::class,
    'rememberences' => RememberenceController::class,
    'permissions' => PermissionController::class,
    'settings' => SettingController::class,
    'pages' => PageController::class
]);

Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image')->middleware('web');

