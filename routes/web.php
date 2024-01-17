<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UnsplashController;
use App\Http\Controllers\UserAPIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GoogleDocsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/google-docs/{id}', [GoogleDocsController::class, 'view']);
Route::get('/google-docs-view', [GoogleDocsController::class, 'index']);
Route::get('/google/docs/submit', [GoogleDocsController::class, 'storeGoogleDoc']);
Route::get('/google-docs/delete/{id}', [GoogleDocsController::class, 'deleteGoogleDoc']);
Route::get('/google/docs/add', [GoogleDocsController::class, 'viewAddDocs']);
Route::get('/google/docs/user-docs', [GoogleDocsController::class, 'getUserDocs']);
Route::get('/explain-add-doc', [GoogleDocsController::class, 'explainAddDoc']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/unsplash/search', [UnsplashController::class, 'searchImages']);

Route::get('/search-user-api/username', [UserAPIController::class, 'searchUserByUserName']);
Route::get('/search-user-api/email', [UserAPIController::class, 'searchUserByEmail']);
Route::get('/search-user-api/id', [UserAPIController::class, 'searchUserById']);

Route::get('/user/delete', [UserController::class, 'deleteAccount']);
Route::get('/user/search/email', [UserController::class, 'searchUserByEmail']);
Route::get('/user/search/id', [UserController::class, 'searchUserById']);
Route::get('/user/create-fake-user', [UserController::class, 'generateFakeUser']);
Route::get('/user/create-user', [UserController::class, 'CreateUser']);

Route::get('/spotify/search', [SpotifyController::class, 'search']);

Route::get('/test', [TestController::class, 'index']);