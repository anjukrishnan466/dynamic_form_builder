<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 
 use App\Http\Controllers\AdminController;

 use App\Http\Controllers\FormController;

 
 
 Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('login');
 
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

 

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::middleware(['auth', 'admin'])->get('/test-admin', function () {
    return 'Hello Admin';
});
// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/admin/login');
})->name('logout');