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
            'HEAD'   => redirect()->route('dashboard.head'),
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
    Route::livewire('/change-password', 'pages::change-password')->name('change_password');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'driver_role'])->group(function () {
    Route::livewire('/log_distribution', 'pages::log_distribution')->name('log_distribution');
});

Route::middleware(['auth', 'admin_role'])->group(function () {

    Route::livewire('/manage/users', 'pages::user.users')->name('user.view');
    Route::livewire('/manage/users/{user_id}', 'pages::user.user-detail')->name('user.detail');

    Route::livewire('/manage/schools', 'pages::school.school-view')->name('school.view');
    Route::livewire('/manage/schools/create', 'pages::school.school-create')->name('school.create');
    Route::livewire('/manage/schools/portions', 'pages::school.school-portion-index')->whereNumber('school_id')->name('school.portion');
    Route::livewire('/manage/schools/{school_id}', 'pages::school.school-detail')->whereNumber('school_id')->name('school.detail');
    Route::livewire('/manage/schools/{school_id}/edit', 'pages::school.school-edit')->whereNumber('school_id')->name('school.edit');

});