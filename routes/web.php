<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManyatinterestController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login',[LoginController::class,'loginFormShow'])->name('login');
        // Route::view('/login-css', 'dashboard.admin.layouts.login')->name('login_css');
        Route::post('/check', [LoginController::class, 'loginCheck'])->name('check');


    });

    Route::middleware(['auth:admin'])->group(function () {

        Route::view('/dashboard', 'admin.layouts.dashboard')->name('dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        //user
        Route::get('/index', [UserController::class,'index'])->name('index');
        Route::get('/create', [UserController::class,'create'])->name('create');
        Route::post('/store', [UserController::class,'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class,'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class,'update'])->name('update');
        Route::post('destroy', [UserController::class, 'destroy'])->name('delete');
        Route::get('status', [UserController::class,'statusChange'])->name('status');

        //maney
        Route::get('/index-maney', [ManyatinterestController::class,'index'])->name('m_index');
        Route::get('/create_many', [ManyatinterestController::class,'create'])->name('m_create');
        Route::post('/store_many', [ManyatinterestController::class,'store'])->name('m_store');
        Route::get('/deposite', [ManyatinterestController::class,'deposite'])->name('deposite');

        //Change Password
    Route::get('/changePassword',      [LoginController::class,'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword',     [LoginController::class, 'changePasswordPost'])->name('changePasswordPost');






    });
});
