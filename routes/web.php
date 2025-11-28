<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (!Auth::check()) return redirect('/admin/login');
    return redirect()->route('kurir.index');
});

Route::middleware(['auth'])->group(function () {
    // Menu-menu
    Route::get('/kurir/app', [CourierController::class, 'index'])->name('kurir.index'); // Home
    Route::get('/kurir/active', [CourierController::class, 'active'])->name('kurir.active'); // MENU BARU (Tugas)
    Route::get('/kurir/history', [CourierController::class, 'history'])->name('kurir.history'); // Riwayat
    Route::get('/kurir/profile', [CourierController::class, 'profile'])->name('kurir.profile'); // Akun

    
    // Fitur Chat Realtime (AJAX)
    Route::get('/chat/get/{orderId}', [CourierController::class, 'getChats'])->name('chat.get');
    Route::post('/chat/send/{orderId}', [CourierController::class, 'sendChat'])->name('chat.send');

    // Aksi
    Route::post('/kurir/ambil/{id}', [CourierController::class, 'takeOrder'])->name('kurir.take');
    Route::post('/kurir/selesai/{id}', [CourierController::class, 'completeOrder'])->name('kurir.complete');
});