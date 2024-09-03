<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;


Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('login.destroy');

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::middleware(['role:prof,head'])->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    });

    Route::middleware(['role:prof,head,student'])->group(function () {
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    });

    Route::middleware(['role:prof'])->group(function () {
        Route::get('/professorsRequests', [ProfessorController::class, 'requestList'])->name('professors.requestList');
        Route::get('/professorsRequests/{request}', [ProfessorController::class, 'requestDetails'])->name('professors.requestDetails');
        Route::post('/professorsRequests/{request}/deny', [ProfessorController::class, 'denyRequest'])->name('professors.denyRequest');
        Route::post('/professorsRequests/{request}/grant', [ProfessorController::class, 'grantRequest'])->name('professors.grantRequest');
    });

    Route::middleware(['role:head'])->group(function () {
        Route::get('/student/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index')->middleware(['auth', 'role:head']);
        Route::get('/professors/create', [ProfessorController::class, 'create'])->name('professors.create')->middleware(['auth', 'role:head']);
        Route::post('/professors', [ProfessorController::class, 'store'])->name('professors.store')->middleware(['auth', 'role:head']);
        Route::get('/professors/{id}/edit', [ProfessorController::class, 'edit'])->name('professors.edit')->middleware(['auth', 'role:head']);
        Route::put('/professors/{id}', [ProfessorController::class, 'update'])->name('professors.update')->middleware(['auth', 'role:head']);
        Route::delete('/professors/{id}', [ProfessorController::class, 'destroy'])->name('professors.destroy')->middleware(['auth', 'role:head']);
        Route::get('/professors/{id}', [ProfessorController::class, 'show'])->name('professors.show')->middleware(['auth', 'role:head']);

        Route::get('/classes', [ClassController::class, 'index'])->name('classes.index')->middleware(['auth', 'role:head']);
        Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create')->middleware(['auth', 'role:head']);
        Route::post('/classes', [ClassController::class, 'store'])->name('classes.store')->middleware(['auth', 'role:head']);
        Route::get('/classes/{id}/edit', [ClassController::class, 'edit'])->name('classes.edit')->middleware(['auth', 'role:head']);
        Route::put('/classes/{id}', [ClassController::class, 'update'])->name('classes.update')->middleware(['auth', 'role:head']);
        Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware(['auth', 'role:head']);
        Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show')->middleware(['auth', 'role:head']);
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/studentprofile', [StudentController::class, 'profile'])->name('students.profile');

        Route::post('/students/{id}/request', [StudentController::class, 'storeRequest'])
            ->name('students.storeRequest');

        Route::get('/students/{id}/request', [StudentController::class, 'requestEditForm'])
            ->name('students.requestEditForm');

        Route::get('/studentsrequests', [StudentController::class, 'showRequestList'])
            ->name('students.requestList');

        Route::get('/studentsrequests/{id}', [StudentController::class, 'showRequestDetails'])
            ->name('students.requestDetails');

        Route::delete('/students/requests/{id}', [StudentController::class, 'deleteRequest'])->name('students.deleteRequest');
    });
});
