<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

//отслеживаем захода пользователя на страницу для получения данных для вывода
Route::get('/getAll', [ProductController::class, 'allData'])->name('product-list');

Route::post('/', function () {
    return view('home');
})->name('product-data');
