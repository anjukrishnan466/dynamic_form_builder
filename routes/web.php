<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 
 use App\Http\Controllers\AdminController;

 
 
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;

 

 
 Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('login');
 
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

 

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('form', FormController::class);
Route::get('/admin/forms', [FormController::class, 'index'])->name('form.index');
  Route::get('/forms/create', [FormController::class, 'create'])->name('form.create');
    Route::post('/forms/store', [FormController::class, 'store'])->name('form.store');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/form/{formId}/field/create', [FormFieldController::class, 'create'])->name('field.create');
Route::post('/form/{formId}/field/store', [FormFieldController::class, 'store'])->name('field.store');
});
Route::middleware(['auth', 'admin'])->get('/test-admin', function () {
    return 'Hello Admin';
});
// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/admin/login');
})->name('logout');