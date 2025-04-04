<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('projects', ProjectController::class)->except(['create', 'show']);
Route::resource('tasks', TaskController::class)->except(['create', 'show']);
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
