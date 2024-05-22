<?php

use App\Events\NotificationCreated;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\UserController;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return Inertia::render('Home/Index');
})->name('home');

Route::get('/cart', function () {
    return Inertia::render('Home/Cart');
});

Route::get('/success', [PaypalController::class, 'success'])->name('success');
Route::get('/cancel', function () {
    return Inertia::render('Payment/Fail');
})->name('cancel');

Route::get('/success-cod', function () {
    return Inertia::render('Payment/Cod');
})->name('cod');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::middleware(['role:admin|manager', 'status'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('orders', OrderController::class);
        Route::resource('products', ItemController::class);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
