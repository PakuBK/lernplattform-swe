<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizPlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subjects
    Route::resource('subjects', SubjectController::class);

    // Themes
    Route::resource('themes', ThemeController::class);

    // Materials
    Route::resource('materials', MaterialController::class);

    // Quizzes
    Route::resource('quizzes', QuizController::class);

    // Quiz Player
    Route::get('/quiz/{quiz}/start', [QuizPlayerController::class, 'start'])->name('quiz.start');
    Route::get('/attempt/{attempt}/play', [QuizPlayerController::class, 'play'])->name('quiz.play');
    Route::post('/attempt/{attempt}/submit', [QuizPlayerController::class, 'submit'])->name('quiz.submit');
    Route::get('/attempt/{attempt}/summary', [QuizPlayerController::class, 'summary'])->name('quiz.summary');
    Route::get('/subject/{subject}/random-quiz', [QuizPlayerController::class, 'random'])->name('quiz.random');
});

require __DIR__.'/auth.php';
