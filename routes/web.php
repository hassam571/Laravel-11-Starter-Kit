<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QrcodeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginform'])->name('loginform');
Route::get('/register', [AuthController::class, 'registerform'])->name('registerform');
Route::post('register', [AuthController::class, 'register'])->name('register');;
Route::post('login', [AuthController::class, 'login'])->name('login');;

Route::post('logout', [AuthController::class, 'logout'])->name('logout');




// Route::prefix('barcodes')->group(function () {


// });



Route::get('/error', [AuthController::class, 'error403'])->name('auth.errors.error403');


Route::middleware(['auth'])->group(function () {


    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
});



Route::prefix('user')->middleware(['role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
});


});





