<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::post('/loans', [\App\Http\Controllers\LoansController::class, 'store'])
    ->name('loans.store')
    ->middleware('auth');
Route::post('/loans/update', [\App\Http\Controllers\LoansController::class, 'update'])
    ->name('loans.update')
    ->middleware('auth');
Route::post('/payments/{payment}/destroy', [\App\Http\Controllers\PaymentsController::class, 'destroy'])
    ->name('payments.destroy')
    ->middleware('auth');
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});


