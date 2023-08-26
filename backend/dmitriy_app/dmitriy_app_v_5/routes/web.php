<?php

use App\Http\Controllers\Admin\CourseCrudController;
use Illuminate\Support\Facades\Route;

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
Route::get('/getAll', [CourseCrudController::class, 'allData'])->name('course-list');

Route::post('/admin')->name('admin-panel');

Route::get('/purchase/Course/{id}', [CourseCrudController::class, 'purchaseCourse'])->name('course-purchase-data');

Route::get('/purchase/{key}', [CourseCrudController::class, 'downCourse'])->name('down-data');

Route::get('/final', function(){
    return view('inc/finish');
})->name('finish');
