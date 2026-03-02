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

    Route::livewire('/dashboard/admin', 'pages::dashboard.admin-dashboard')
        ->name('dashboard.admin');

    Route::livewire('/dashboard/head', 'pages::dashboard.hk-dashboard')
        ->name('dashboard.head');

    Route::livewire('/dashboard/plog', 'pages::dashboard.plog-dashboard')
        ->name('dashboard.plog');

    Route::livewire('/dashboard/plok', 'pages::dashboard.plok-dashboard')
        ->name('dashboard.plok');

    Route::livewire('/dashboard/aslap', 'pages::dashboard.aslap-dashboard')
        ->name('dashboard.aslap');

    Route::livewire('/dashboard/driver', 'pages::dashboard.driver-dashboard')
        ->name('dashboard.driver');
});


    Route::livewire('/biodata', 'pages::biodata')->name('biodata');
    Route::livewire('/biodata/update', 'pages::form.input-biodata')->name('form.biodata');
    
    Route::livewire('/profile', 'pages::profile')->name('profile');
    Route::livewire('/change-password', 'pages::change-password')->name('change_password');


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'driver_role'])->group(function () {
    Route::livewire('/log_distribution', 'pages::log_distribution')->name('log_distribution');
});

Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::livewire('/users', 'pages::user.users')->name('user.view');
    Route::livewire('/users/{user_id}', 'pages::user.user-detail')->name('user.detail');
});

Route::middleware(['auth', 'role:ADMIN,ASLAP'])->group(function () {

    Route::livewire('/manage/schools', 'pages::school.school-index')->name('school.index');
    Route::livewire('/manage/schools/list', 'pages::school.school-view')->name('school.view');
    Route::livewire('/manage/schools/create', 'pages::school.school-create')->name('school.create');
    Route::livewire('/manage/schools/portions', 'pages::school.school-portion-index')->name('school.portion');
    Route::livewire('/manage/schools/portions/log', 'pages::school.log-portion')->name('school.log-portion');
    Route::livewire('/manage/schools/{school_id}', 'pages::school.school-detail')->whereNumber('school_id')->name('school.detail');
    Route::livewire('/manage/schools/{school_id}/edit', 'pages::school.school-edit')->whereNumber('school_id')->name('school.edit');
    
    Route::livewire('/manage/posyandu', 'pages::posyandu.posyandu-view')->name('posyandu.view');
    Route::livewire('/manage/posyandu/create', 'pages::posyandu.posyandu-create')->name('posyandu.create');
    Route::livewire('/manage/posyandu/portions', 'pages::posyandu.posyandu-portion-index')->name('posyandu.portion');
    Route::livewire('/manage/posyandu/portions/log', 'pages::posyandu.log-portion')->name('posyandu.log-portion');
    Route::livewire('/manage/posyandu/{posyandu_id}', 'pages::posyandu.posyandu-detail')->whereNumber('posyandu_id')->name('posyandu.detail');
    Route::livewire('/manage/posyandu/{posyandu_id}/edit', 'pages::posyandu.posyandu-edit')->whereNumber('posyandu_id')->name('posyandu.edit');
    
    
    Route::livewire('/manage/distribusi', 'pages::distribution.dist-index')->name('distribution.index');
    Route::livewire('/manage/distribusi/rute', 'pages::distribution.create-route')->name('distribution.road-route');
    
    
    
    Route::livewire('/test', 'pages::test')->name('test');
    
});