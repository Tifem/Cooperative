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

// Route::get('/', function () {
//     return view('admin.dashboard');
// });

Auth::routes();

Route::get('/landing_page', [App\Http\Controllers\HomeController::class, 'create'])->name('landing_page');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name("logout");

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');

    return $exitCode;
});
Route::get('/clear-route', function () {
    $exitCode = Artisan::call('route:clear');

    return $exitCode;
});

Route::get('/clear-view', function () {
    $exitCode = Artisan::call('view:clear');

    return $exitCode;
});

Route::get('/clear-laravel-log-file', function () {
    exec('rm -f ' . storage_path('logs/*.log'));
    exec('rm -f ' . base_path('*.log'));

    return 'Log file deleted';
});
