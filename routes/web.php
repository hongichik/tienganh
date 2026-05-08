<?php

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\WritingController;
use App\Http\Controllers\User\PartOneController;
use App\Http\Controllers\User\PartTwoController;
use App\Http\Controllers\User\VocabularyLearningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	if (Auth::check()) {
		return redirect()->route('user.home');
	}

	return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function (): void {
	Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function (): void {
	Route::get('/home', [HomeController::class, 'index'])->name('user.home');
	Route::get('/writing', [WritingController::class, 'index'])->name('user.writing');
	Route::get('/writing/part-1', [PartOneController::class, 'show'])->name('user.writing.part1');
	Route::post('/writing/part-1/answer', [PartOneController::class, 'submitAnswer'])->name('user.writing.part1.answer');
	Route::post('/writing/part-1/personal-hint', [PartOneController::class, 'savePersonalHint'])->name('user.writing.part1.personal-hint');
	Route::post('/writing/part-1/restart', [PartOneController::class, 'restart'])->name('user.writing.part1.restart');
	Route::get('/writing/part-2', [PartTwoController::class, 'show'])->name('user.writing.part2');
	Route::post('/writing/part-2/answer', [PartTwoController::class, 'submitAnswer'])->name('user.writing.part2.answer');
	Route::post('/writing/part-2/personal-hint', [PartTwoController::class, 'savePersonalHint'])->name('user.writing.part2.personal-hint');
	Route::post('/writing/part-2/restart', [PartTwoController::class, 'restart'])->name('user.writing.part2.restart');
	Route::get('/writing/vocabulary', [VocabularyLearningController::class, 'show'])->name('user.writing.vocabulary');
	Route::post('/writing/vocabulary/mode-1', [VocabularyLearningController::class, 'submitModeOne'])->name('user.writing.vocabulary.mode1');
	Route::post('/writing/vocabulary/mode-2', [VocabularyLearningController::class, 'submitModeTwo'])->name('user.writing.vocabulary.mode2');
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
