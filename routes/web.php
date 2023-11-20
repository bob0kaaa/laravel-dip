<?php

use App\Http\Controllers\HallController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware('guest')->group(function () {
    // Регистрация
    Route::get('registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('registration', [RegistrationController::class, 'store'])->name('registration.store');

    // Вход
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});
//Route::get('/hall', [HallController::class, 'show'])->name('user.hall');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


