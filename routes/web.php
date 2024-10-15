<?php

use App\Http\Controllers\belajar\viewcontroller;
use App\Http\Controllers\todo\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',  [TodoController::class, 'index'])->name('todo');
Route::post('/', [TodoController::class, 'store'])->name('todo.post');
Route::put('/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todo.delete');
