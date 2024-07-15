<?php

use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\CreateAndShowUserController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('auth.login');
Route::get('/logout',[LoginController::class,'logout'])->name('auth.logout');

Route::group(['middleware' => 'admin'], function(){
    Route::get('/admin/home', [HomeController::class, 'RoleToHome'])->name('admin.home');
    //CreateAndShowUserController
    Route::get('/admin/ShowUser', [CreateAndShowUserController::class, 'ShowUser'])->name('admin.ShowUser');
    Route::post('/admin/create', [CreateAndShowUserController::class, 'CreateUser'])->name('admin.create');
    Route::post('/admin/delete/{id}', [CreateAndShowUserController::class, 'DeleteUser'])->name('admin.delete');
    Route::get('/admin/edit/{id}', [CreateAndShowUserController::class, 'EditUser'])->name('admin.edit');
    Route::put('/admin/update/{id}', [CreateAndShowUserController::class, 'UpdateUser'])->name('admin.update');
    Route::get('/admin/filter', [CreateAndShowUserController::class, 'FilterUser'])->name('admin.filter');
    Route::get('/admin/search', [CreateAndShowUserController::class, 'SearchUser'])->name('admin.search');
    //ClassRoomController
    Route::get('/admin/classroom', [ClassRoomController::class, 'index'])->name('admin.classroom');
    Route::post('/admin/addclass', [ClassRoomController::class, 'AddClass'])->name('admin.addclass');
    Route::get('/admin/editclass/{id}', [ClassRoomController::class, 'EditClass'])->name('admin.editclass');
    Route::put('/admin/updateclass/{id}', [ClassRoomController::class, 'UpdateClass'])->name('admin.updateclass');
    Route::get('/admin/filterstatus', [ClassRoomController::class, 'FilterStatus'])->name('admin.filterstatus');
    //Subjectontroller
    Route::get('/admin/subject', [SubjectController::class, 'index'])->name('admin.subject');
    Route::post('/admin/addsubject', [SubjectController::class, 'AddSubject'])->name('admin.addsubject');
    Route::get('/admin/editsubject/{id}', [SubjectController::class, 'EditSubject'])->name('admin.editsubject');
    Route::put('/admin/updatesubject/{id}',[SubjectController::class,'UpdateSubject'])->name('admin.updatesubject');
    Route::post('/assign-subject', [SubjectController::class, 'AssignSubject'])->name('admin.assign-subject');
    
    //StudentController
    Route::get('/admin/student', [StudentController::class, 'index'])->name('admin.student');
    Route::post('/admin/addstudent', [StudentController::class, 'Addstudent'])->name('admin.addstudent');
    Route::get('/admin/editstudent/{id}', [StudentController::class, 'EditStudent'])->name('admin.editstudent');
    Route::post('/admin/updatestudent/{id}',[StudentController::class,'UpdateStudent'])->name('admin.updatestudent');

});

Route::group(['middleware' => 'teacher'],function(){
    Route::get('/teacher/home', [HomeController::class, 'RoleToHome'])->name('teacher.home');
    
});