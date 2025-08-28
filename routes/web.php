<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackierController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CampaignController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
});

Route::get('/', [TrackierController::class, 'getCampaigns'])->name('offers');
Route::post('/offer-clicks', [TrackierController::class, 'store'])->name('offer-clicks.store');
Route::post('/offer-clicks1', [TrackierController::class, 'store1'])->name('offer-clicks1.store1');

