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
| Головна сторінка
|--------------------------------------------------------------------------
| Відображаємо гостю сторінку "Welcome".
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('welcome');

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

    // Маршрути для роботи зі змінами (ShiftController)
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('/shifts/create', [ShiftController::class, 'create'])->name('shifts.create');
    Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');
    Route::post('/shifts/{shift}/check-in', [ShiftController::class, 'checkIn'])->name('shifts.checkin');
    Route::post('/shifts/{shift}/check-out', [ShiftController::class, 'checkOut'])->name('shifts.checkout');

    // Особистий кабінет рятувальника
    Route::get('/dashboard/lifeguard', [LifeguardDashboardController::class, 'index'])
         ->name('lifeguard.dashboard');
    Route::get('/dashboard/lifeguard/report/{shift}', [LifeguardDashboardController::class, 'report'])
         ->name('lifeguard.report');
    Route::post('/dashboard/lifeguard/report/{shift}', [LifeguardDashboardController::class, 'storeReport'])
         ->name('lifeguard.report.store');

    // Карта постів
    Route::get('/posts/map', [PostController::class, 'map'])->name('posts.map');

    // Профіль користувача
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Список змін
Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
// Створення зміни
Route::get('/shifts/create', [ShiftController::class, 'create'])->name('shifts.create');
// Збереження нової зміни
Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');
// Фіксація чек-іну
Route::post('/shifts/{shift}/check-in', [ShiftController::class, 'checkIn'])->name('shifts.checkin');
// Фіксація чек-ауту
Route::post('/shifts/{shift}/check-out', [ShiftController::class, 'checkOut'])->name('shifts.checkout');
// Редагування зміни (повинно повертати компонент Edit.vue)
Route::get('/shifts/{shift}/edit', [ShiftController::class, 'edit'])->name('shifts.edit');
// Оновлення зміни (повинен приймати PUT-запит)
Route::put('/shifts/{shift}/update', [ShiftController::class, 'update'])->name('shifts.update');


    // Адмінські маршрути для управління користувачами
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
    });
});

require __DIR__.'/auth.php';
