<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('welcome.about');
})->name('about');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::prefix('election')->group(function () {
        Route::get('/', [ElectionController::class, 'index'])->name('election.index');
        Route::get('/candidate/{candidate}/detail', [ElectionController::class, 'showCandidateDetail'])->name('election.candidate.detail');
        Route::get('/vote/{candidate}/confirm', [ElectionController::class, 'confirmVote'])->name('election.vote.confirm');
        Route::post('/vote/{candidate}', [ElectionController::class, 'submitVote'])->name('election.vote.submit');
    });
});

require __DIR__.'/auth.php';
