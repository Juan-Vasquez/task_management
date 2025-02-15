<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [RegisterController::class, 'register'])->name('api.v1.register');
Route::post('login', [LoginController::class, 'login'])->name('api.v1.login');

Route::middleware(['jwt', 'headers.verified'])->group(function(){

    Route::get('projects', [ProjectController::class, 'index'])->name('api.v1.projects.index');
    Route::get('projects/{project}', [ProjectController::class, 'show'])->name('api.v1.projects.show');
    Route::post('projects', [ProjectController::class, 'store'])->name('api.v1.projects.store');
    Route::patch('projects/{project}', [ProjectController::class, 'update'])->name('api.v1.projects.update');
    Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('api.v1.projects.destroy');

    Route::get('tasks', [TaskController::class, 'index'])->name('api.v1.tasks.index');
    Route::post('tasks', [TaskController::class, 'store'])->name('api.v1.tasks.store');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('api.v1.tasks.show');

});