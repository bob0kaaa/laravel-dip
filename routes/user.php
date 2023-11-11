<?php

use App\Http\Controllers\HallController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (){

    Route::get('/hall', [HallController::class, 'show'])->name('user.hall');
    Route::get('/ticket', [TicketController::class, 'index'])->name('user.ticket');
    Route::any('/seat', [SeatController::class, 'edit'])->name('user.seat');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('user.ticket.create');

});
