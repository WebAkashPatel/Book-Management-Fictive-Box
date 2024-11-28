<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\HomeController;
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

//Auth Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('/');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

//Home Routes
Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

//Profile & Password Route
Route::post('/password/update', [HomeController::class, 'password_update'])->name('admin.password.update');

//User Route
Route::get('/users', [UserController::class, 'index'])->name('admin.users');
Route::get('/users/data', [UserController::class, 'data'])->name('admin.users.data');
Route::post('/users/status', [UserController::class, 'status'])->name('admin.users.status');

//Book Route
Route::get('/books', [BookController::class, 'index'])->name('admin.books');
Route::get('/books/data', [BookController::class, 'data'])->name('admin.books.data');
Route::get('/books/add', [BookController::class, 'add'])->name('admin.books.add');
Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('admin.books.edit');
Route::post('/books/store', [BookController::class, 'store'])->name('admin.books.store');
Route::put('/books/store/{id}', [BookController::class, 'store'])->name('admin.books.update');

//Feedback Route
Route::get('/feedback', [FeedbackController::class, 'index'])->name('admin.feedback');
Route::get('/feedback/data', [FeedbackController::class, 'data'])->name('admin.feedback.data');
Route::get('/feedback/view/{id}', [FeedbackController::class, 'view'])->name('admin.feedback.view');