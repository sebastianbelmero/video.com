<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/show/{id}', [VideoController::class, 'show'])->name('video.show');


Route::middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {
    Route::get('/admin', DashboardController::class)->name('dashboard');

    Route::resource('/admin/categories', CategoryController::class);
    Route::post('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/admin/get/categories', [CategoryController::class, 'getCategories'])->name('categories.get-categories');
    
    Route::resource('/admin/videos', VideoController::class);
    Route::post('/admin/videos/{category}', [VideoController::class, 'update'])->name('videos.update');
    Route::get('/admin/get/videos', [VideoController::class, 'getVideos'])->name('videos.get-videos');
});