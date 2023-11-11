<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SeatController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth', 'role'])->group(function (){
    Route::redirect('/', '/admin')->name('admin');

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/open/{param}', [HallController::class, 'open'])->name('admin.open');
    Route::any('/createHall', [HallController::class, 'create'])->name('admin.createHall');
    Route::any('/destroyHall/{id}', [HallController::class, 'destroy'])->name('admin.destroyHall');
    Route::any('/updateHall', [HallController::class, 'update'])->name('admin.updateHall');
    Route::any('/editHall', [HallController::class, 'edit'])->name('admin.editHall');
    Route::any('/editPriceHall', [HallController::class, 'editPriceHall'])->name('admin.editPriceHall');
    Route::any('/createFilm', [FilmController::class, 'create'])->name('admin.createFilm');
    Route::any('/destroyFilm/{id}', [FilmController::class, 'destroy'])->name('admin.destroyFilm');
    Route::any('/createseance', [SeanceController::class, 'create'])->name('admin.createseance');
    Route::any('/createSeats', [SeatController::class, 'create'])->name('admin.createSeat');
    Route::any('/destroyseance/{id}', [SeanceController::class, 'destroy'])->name('admin.destroyseance');

});
