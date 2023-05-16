<?php

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
    return redirect('dental/dashboard');
});

Route::get('/home', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');

Route::get('/dental/logout', 'App\Http\Controllers\HomeController@logout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dental/home', 'App\Http\Controllers\HomeController@index');
    Route::get('/dental/dashboard', 'App\Http\Controllers\DashboardController@index');

    Route::resource('/dental/pasien', 'App\Http\Controllers\PasienController');
    Route::resource('/dental/pengingat', 'App\Http\Controllers\PengingatController');
    Route::resource('/dental/users', 'App\Http\Controllers\UserController');
    // Route::patch('/admin/users/{id}/update', 'App\Http\Controllers\UserController@update')->name('users.update');

});

