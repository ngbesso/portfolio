<?php

use App\Presentation\Http\Controllers\Api\ContactApiController;
use App\Presentation\Http\Controllers\Api\ProjectApiController;
use App\Presentation\Http\Controllers\Api\SkillApiController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes (Public)
|--------------------------------------------------------------------------
*/

// Projects
Route::get('/projects', [ProjectApiController::class, 'index']);
Route::get('/projects/featured', [ProjectApiController::class, 'featured']);
Route::get('/projects/{slug}', [ProjectApiController::class, 'show']);

// Skills
Route::get('/skills', [SkillApiController::class, 'index']);

// Contact
Route::post('/contact', [ContactApiController::class, 'store']);



/*
|--------------------------------------------------------------------------
| CORS Configuration
|--------------------------------------------------------------------------
|
| Pour le développement local, configurer CORS dans config/cors.php
|
| 'paths' => ['api/*'],
| 'allowed_origins' => ['http://localhost:5173'], // Vite dev server
| 'allowed_methods' => ['*'],
| 'allowed_headers' => ['*'],
*/
