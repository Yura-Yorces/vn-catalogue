<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\VisualNovelController as StaffVisualNovelController;
use App\Http\Controllers\Staff\RoleController as StaffRoleController;
use App\Http\Controllers\Staff\UserController as StaffUserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;

use App\Http\Controllers\VisualNovelController;
use Illuminate\Support\Facades\Route;

// Public

Route::redirect('/', '/novels');

Route::get('/novels', [VisualNovelController::class, 'index'])->name('novels.index');
Route::get('/novels/{visualNovel}', [VisualNovelController::class, 'show'])->name('novels.show');


// Guest

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Users

Route::middleware('auth')->group(function () {
    Route::post('/novels/{visualNovel}/ratings', [RatingController::class, 'store'])
        ->name('ratings.store');
    Route::delete('/novels/{visualNovel}/ratings', [RatingController::class, 'destroy'])
        ->name('ratings.destroy');

    Route::post('/novels/{visualNovel}/favorite', [FavoriteController::class, 'store'])
        ->name('favorites.store');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('profile.favorites');
    Route::get('/my-reviews', [RatingController::class, 'mine'])->name('profile.my-rating');
});


// Staff

Route::middleware(['auth', 'role:moderator,admin'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');

        Route::resource('novels', StaffVisualNovelController::class)->except('show');

        Route::get('users', [StaffUserController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [StaffUserController::class, 'ban'])->name('users.ban');
        Route::patch('users/{id}/restore', [StaffUserController::class, 'restore'])->name('users.restore');

        Route::middleware('role:admin')->group(function () {
            Route::get('roles', [StaffRoleController::class, 'index'])->name('roles.index');
            Route::patch('roles/{user}', [StaffRoleController::class, 'update'])->name('roles.update');
        });
    });

