<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::livewire('/', 'pages::main');
    Route::livewire('/login', 'pages::login-page')->name('login');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = Auth::user()->role->name;

        return match ($role) {
            'ADMIN'   => redirect()->route('admin.dashboard'),
            'PLOG'   => redirect()->route('plog.dashboard'),
            'PLOK'   => redirect()->route('plok.dashboard'),
            'ASLAP'   => redirect()->route('aslap.dashboard'),
            'DRIVER'  => redirect()->route('driver.dashboard'),
            'relawan' => redirect()->route('relawan.dashboard'),
            default   => abort(403),
        };
    })->name('dashboard');

    Route::livewire('/admin/dashboard', 'pages::dashboard.admin-dashboard')
        ->name('admin.dashboard');

    Route::livewire('/head/dashboard', 'pages::dashboard.hk-dashboard')
        ->name('head.dashboard');

    Route::livewire('/plog/dashboard', 'pages::dashboard.plog-dashboard')
        ->name('plog.dashboard');

    Route::livewire('/plok/dashboard', 'pages::dashboard.plok-dashboard')
        ->name('plok.dashboard');

    Route::livewire('/aslap/dashboard', 'pages::dashboard.aslap-dashboard')
        ->name('aslap.dashboard');

    Route::livewire('/driver/dashboard', 'pages::dashboard.driver-dashboard')
        ->name('driver.dashboard');
});


    Route::livewire('/biodata', 'pages::biodata')->name('biodata');
    Route::livewire('/biodata/update', 'pages::form.input-biodata')->name('form.biodata');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'driver_role'])->group(function () {
    Route::livewire('/log_distribution', 'pages::log_distribution')->name('log_distribution');
});

Route::middleware(['auth', 'admin_role'])->group(function () {
    Route::livewire('/manage/users', 'pages::user.users')->name('user.view');
});