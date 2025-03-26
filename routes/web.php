<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Контролери
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LifeguardDashboardController;
use App\Http\Controllers\Admin\UserController;

// Middleware для перевірки аутентифікації та схвалення користувача
use App\Http\Middleware\EnsureUserIsApproved;

/*
|--------------------------------------------------------------------------
| Головна сторінка та PWA маршрути
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('welcome');

// Офлайн-сторінка для PWA
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

/*
|--------------------------------------------------------------------------
| Група маршрутів для авторизованих та схвалених користувачів
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', EnsureUserIsApproved::class])->group(function () {

    // Панель керування
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Маршрути для роботи зі змінами
    Route::controller(ShiftController::class)->prefix('shifts')->name('shifts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{shift}/edit', 'edit')->name('edit');
        Route::put('/{shift}', 'update')->name('update');
        Route::post('/{shift}/check-in', 'checkIn')->name('checkin');
        Route::post('/{shift}/check-out', 'checkOut')->name('checkout');
    });

    // Особистий кабінет рятувальника
    Route::controller(LifeguardDashboardController::class)->prefix('dashboard/lifeguard')->name('lifeguard.')->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/report/{shift}', 'report')->name('report');
        Route::post('/report/{shift}', 'storeReport')->name('report.store');
    });

    // Карта постів
    Route::get('/posts/map', [PostController::class, 'map'])->name('posts.map');

    // Профіль користувача
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // Адмінські маршрути для управління користувачами
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::post('/{user}/update', 'update')->name('update');
            Route::post('/{user}/approve', 'approve')->name('approve');
        });
    });
});

// Маршрути автентифікації
require __DIR__.'/auth.php';