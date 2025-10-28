<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
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
Route::get('/',[StudentController::class,'create'])->name('student.create');
Route::get('/list',[StudentController::class,'index'])->name('student.list');
Route::post('/save',[StudentController::class,'store'])->name('student.store');
