<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\UserFormController;
use Illuminate\Support\Facades\Mail;



/*
|--------------------------------------------------------------------------
| PUBLIC USER ROUTES (No login required)
|--------------------------------------------------------------------------
*/

// Show all public forms
Route::get('/forms', [UserFormController::class, 'index'])->name('user.forms.index');

// Show a specific form to fill
Route::get('/forms/{id}', [UserFormController::class, 'show'])->name('user.forms.show');

// Submit a filled form
Route::post('/forms/{id}', [UserFormController::class, 'submit'])->name('user.forms.submit');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Admin login page
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('login');

// Handle admin login
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/admin/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Requires login + admin middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Full form management using resource route
    Route::resource('form', FormController::class);

    // Explicit routes (you can remove these if resource is fully covering them)
    Route::get('/admin/forms', [FormController::class, 'index'])->name('form.index');
    Route::get('/admin/form/create', [FormController::class, 'create'])->name('form.create');
    Route::post('/admin/forms/store', [FormController::class, 'store'])->name('form.store');

    // Form field management (Add fields to a form)
    Route::get('/form/{formId}/field/create', [FormFieldController::class, 'create'])->name('field.create');
    Route::post('/form/{formId}/field/store', [FormFieldController::class, 'store'])->name('field.store');

    // Test route (for testing middleware)

});
