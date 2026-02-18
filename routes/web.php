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
            'ADMIN'   => redirect()->route('dashboard.admin'),
            'PLOG'   => redirect()->route('dashboard.plog'),
            'PLOK'   => redirect()->route('dashboard.plok'),
            'ASLAP'   => redirect()->route('dashboard.aslap'),
            'DRIVER'  => redirect()->route('dashboard.driver'),
            'relawan' => redirect()->route('dashboard.relawan'),
            default   => abort(403),
        };
    })->name('dashboard');

    Route::livewire('/admin/dashboard', 'pages::dashboard.admin-dashboard')
        ->name('dashboard.admin');

    Route::livewire('/head/dashboard', 'pages::dashboard.hk-dashboard')
        ->name('dashboard.head');

    Route::livewire('/plog/dashboard', 'pages::dashboard.plog-dashboard')
        ->name('dashboard.plog');

    Route::livewire('/plok/dashboard', 'pages::dashboard.plok-dashboard')
        ->name('dashboard.plok');

    Route::livewire('/aslap/dashboard', 'pages::dashboard.aslap-dashboard')
        ->name('dashboard.aslap');

    Route::livewire('/driver/dashboard', 'pages::dashboard.driver-dashboard')
        ->name('dashboard.driver');
});


    Route::livewire('/biodata', 'pages::biodata')->name('biodata');
    Route::livewire('/biodata/update', 'pages::form.input-biodata')->name('form.biodata');
    
    Route::livewire('/profile', 'pages::profile')->name('profile');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'driver_role'])->group(function () {
    Route::livewire('/log_distribution', 'pages::log_distribution')->name('log_distribution');
});

Route::middleware(['auth', 'admin_role'])->group(function () {
    Route::livewire('/manage/users', 'pages::user.users')->name('user.view');
});