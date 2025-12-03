<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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
Route::get('/',[StudentController::class,'dashboard'])->name('student.dashboard');

Route::get('/index',[TeacherController::class,'index'])->name('teacher.index');

Route::prefix('student')->group(function(){

    Route::get('/register',[StudentController::class,'register'])->name('student.register');
    Route::get('/index',[StudentController::class,'index'])->name('student.index');

    Route::post('/save',[StudentController::class,'store'])->name('student.store');
    Route::get('/delete/{id}',[StudentController::class,'delete'])->name('student.delete');
    Route::get('/edit/{id}',[StudentController::class,'edit'])->name('student.edit');
    Route::post('/update',[StudentController::class,'update'])->name('student.update');
/*    Route::get('/search', [StudentController::class, 'search'])->name('student.search');*/


});


