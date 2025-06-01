<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Middleware\IsTeacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Route::get('teacher/dashboard', function () {
    return view('teacher/dashboard');
})->middleware(IsTeacher::class); */

Route::middleware(['auth', IsTeacher::class])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    // Cuestionarios
    Route::get('/quizzes', [QuizController::class, 'index'])->name('teacher.quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('teacher.quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('teacher.quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('teacher.quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('teacher.quizzes.update');

    // Ruta para importar preguntas
    Route::get('/quizzes/{quiz}/questions/import', [QuestionController::class, 'import'])->name('teacher.questions.import');

    Route::post('/quizzes/{quiz}/questions/import', [QuestionController::class, 'storeImport'])->name('teacher.questions.storeImport');
    Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'showByQuiz'])->name('teacher.questions.showByQuiz');

});

Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

require __DIR__.'/auth.php';
