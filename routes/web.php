<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientGroupController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ClientController::class, 'getAllClients'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/client/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/client/store', [ClientController::class,'store'])->name('client.store');
    Route::patch('/client/{client}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{client}', [ClientController::class, 'destroy'])->name('client.destroy');

    Route::post('/send-email', [EmailController::class, 'send'])->name('send.email');

    Route::get('/client/groups', [ClientGroupController::class, 'index'])->name('groups.index');
    Route::post('/client/groups', [ClientGroupController::class,'store'])->name('groups.store');
    Route::delete('/client/groups/{group}', [ClientGroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/client/groups/{group}/edit', [ClientGroupController::class, 'edit'])->name('groups.edit');
    Route::patch('/client/groups/{group}', [ClientGroupController::class, 'update'])->name('groups.update');

});



require __DIR__.'/auth.php';
