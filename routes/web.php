<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Livewire\CourseForm;
use App\Livewire\CreateCourse;
use App\Livewire\CreateSubject;
use Illuminate\Support\Facades\Route;
use Vtiful\Kernel\Excel;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});








Route::prefix('student')->group(function(){


    // 🔐 PROTECTED ROUTES
    Route::middleware('student.auth')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');


});



    Route::get('/register',[StudentController::class,'register'])->name('student.register');
    Route::get('/index',[StudentController::class,'index'])->name('student.index');

    Route::post('/save',[StudentController::class,'store'])->name('student.store');
    Route::get('/delete/{id}',[StudentController::class,'delete'])->name('student.delete');
    Route::get('/edit/{id}',[StudentController::class,'edit'])->name('student.edit');
    Route::post('/update',[StudentController::class,'update'])->name('student.update');
    Route::get('/student/{student}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/student/export/pdf', [StudentController::class, 'exportPDF'])
        ->name('student.export.pdf');
Route::get('/student/export/csv', [StudentController::class, 'exportCsv'])->name('student.export.csv');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');




});
Route::prefix('teacher')->group(function(){
 Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');



     Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::delete('teacher/delete/{id}', [TeacherController::class, 'delete'])->name('teacher.delete');
Route::get('teacher/edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('teacher/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
Route::get('/teacher/export/pdf', [TeacherController::class, 'exportPdf'])->name('teacher.export.pdf');
Route::get('/teacher/export/csv', [TeacherController::class, 'exportCsv'])->name('teacher.export.csv');
    Route::post('/teachers/import', [TeacherController::class, 'import'])->name('teachers.import');


});


Route::prefix('course')->group(function(){
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
    Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/delete/{id}', [CourseController::class, 'delete'])->name('course.delete');
    Route::get('/edit/{id}',[CourseController::class,'edit'])->name('course.edit');
    Route::put('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('/course/export/pdf', [CourseController::class, 'exportPDF'])
        ->name('course.export.pdf');
    Route::get('/course/export/csv', [CourseController::class, 'exportCsv'])->name('course.export.csv');
    Route::post('/courses/import', [CourseController::class, 'import'])->name('courses.import');



});

Route::prefix('subject')->group(function(){

    Route::get('/subject',[SubjectController::class,'index'])->name('subject.index');
    Route::get('/create',[SubjectController::class,'create'])->name('subject.create');
    Route::delete('/subject/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
    Route::get('/edit/{id}',[SubjectController::class,'edit'])->name('student.edit');

    Route::put('/subject/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::get('/export/pdf', [SubjectController::class, 'exportPDF'])->name('subject.export.pdf');
    Route::get('/export/csv', [SubjectController::class, 'exportCSV'])->name('subject.export.csv');
    Route::post('/subjects/import', [SubjectController::class, 'import'])->name('subjects.import');


Route::get('/subjects', [SubjectController::class, 'getSubjects']);

});


Route::prefix('grade')->group(function(){
    Route::get('/grade',[GradeController::class,'index'])->name('grade.index');
    Route::post('/create', [GradeController::class, 'store'])->name('grade.create');
    Route::delete('/grade/{id}', [GradeController::class, 'delete'])->name('grade.delete');
    Route::get('/edit/{id}',[GradeController::class,'edit'])->name('grade.edit');

    Route::put('/grade/update/{id}', [GradeController::class, 'update'])->name('grade.update');
});

Route::prefix('class')->group(function(){
    Route::get('/class',[ClassController::class,'index'])->name('class.index');
    Route::post('/create', [ClassController::class, 'store'])->name('class.create');
    Route::get('/class/{id}/edit', [ClassController::class, 'edit'])->name('class.edit');

    Route::put('/class/update/{id}', [ClassController::class, 'update'])->name('class.update');

    Route::delete('/class/{id}', [ClassController::class, 'delete'])->name('class.delete');
  Route::post('/import', [ClassController::class, 'import'])->name('classes.import');
    Route::get('/export/csv', [ClassController::class, 'exportCsv'])->name('class.export.csv');
    Route::get('/export/pdf', [ClassController::class, 'exportPdf'])->name('class.export.pdf');

   
});





