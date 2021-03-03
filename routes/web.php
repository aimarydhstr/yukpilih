<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
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
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/change', [ChangePasswordController::class, 'change'])->name('change')->middleware(['auth']);
Route::post('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('changePassword')->middleware(['auth']);

Route::post('/vote/store/{id}', [VoteController::class, 'store'])->name('vote.store')->middleware(['auth', 'ceklevel:user']);

Route::prefix('admin')->middleware(['auth', 'ceklevel:admin'])->group(function() {
    
    // Division
    Route::get('/division', [DivisionController::class, 'index'])->name('division');
    Route::get('/division/create', [DivisionController::class, 'create'])->name('division.create');
    Route::post('/division/store', [DivisionController::class, 'store'])->name('division.store');
    Route::get('/division/edit/{id}', [DivisionController::class, 'edit'])->name('division.edit');
    Route::put('/division/update/{id}', [DivisionController::class, 'update'])->name('division.update');
    Route::post('/division/delete/{id}', [DivisionController::class, 'destroy'])->name('division.delete');

    // Poll
    Route::get('/poll', [PollController::class, 'index'])->name('poll');
    Route::get('/poll/create/{id}', [PollController::class, 'create'])->name('poll.create');
    Route::post('/poll/store/{id}', [PollController::class, 'store'])->name('poll.store');
    Route::get('/poll/edit/{id}', [PollController::class, 'edit'])->name('poll.edit');
    Route::put('/poll/update/{id}', [PollController::class, 'update'])->name('poll.update');
    Route::post('/poll/delete/{id}', [PollController::class, 'destroy'])->name('poll.delete');
    Route::get('/poll/del/{id}', [PollController::class, 'del'])->name('poll.del');

    // Choice
    Route::get('/choice', [ChoiceController::class, 'index'])->name('choice');
    Route::get('/choice/create', [ChoiceController::class, 'create'])->name('choice.create');
    Route::post('/choice/store', [ChoiceController::class, 'store'])->name('choice.store');
    Route::get('/choice/edit/{id}', [ChoiceController::class, 'edit'])->name('choice.edit');
    Route::put('/choice/update/{id}', [ChoiceController::class, 'update'])->name('choice.update');
    Route::post('/choice/delete/{id}', [ChoiceController::class, 'destroy'])->name('choice.delete');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

});