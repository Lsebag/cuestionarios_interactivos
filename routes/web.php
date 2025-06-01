<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\QuizController;
use App\Http\Middleware\IsTeacher;
use Illuminate\Http\Request;
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

    // Rutas para importar preguntas
    Route::get('/quizzes/{quiz}/questions/import', [QuestionController::class, 'import'])->name('teacher.questions.import');

    Route::post('/quizzes/{quiz}/questions/import', [QuestionController::class, 'storeImport'])->name('teacher.questions.storeImport');
    Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'showByQuiz'])->name('teacher.questions.showByQuiz');

    // Rutas sesiones profesor
    Route::get('/meetings', [MeetingController::class, 'index'])->name('teacher.meetings.index');
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('teacher.meetings.create');
    Route::get('/meetings/{id}', [MeetingController::class, 'show'])->name('teacher.meetings.show');
    Route::post('/teacher/meetings', [MeetingController::class, 'store'])->name('teacher.meetings.store');
});

Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
Route::get('/student/meetings', [StudentController::class, 'showMeetings'])->name('student.meetings');

// Ruta unirse a sesión
Route::get('/student/join', function () {
    return view('student.meetings.join');
})->name('student.joinMeetingForm');

Route::post('/student/join', [MeetingController::class, 'handleJoin'])->name('student.joinMeeting');


require __DIR__.'/auth.php';
