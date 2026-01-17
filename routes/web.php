<?php

use App\Presentation\Http\Controllers\ContactController;
use App\Presentation\Http\Controllers\HomeController;
use App\Presentation\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Frontend (Public)
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Pages Projets
Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/{slug}', [ProjectController::class, 'show'])
    ->name('projects.show');

// Formulaire de contact
Route::get('/contact', [ContactController::class, 'show'])
    ->name('contact.show');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
