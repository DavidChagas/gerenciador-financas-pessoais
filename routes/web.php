<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index'])->name('receitas');

Route::get('/contas', [App\Http\Controllers\ContaController::class, 'index'])->name('conta.listar');
Route::get('/contas/create', [App\Http\Controllers\ContaController::class, 'create'])->name('conta.cadastrar');
Route::post('/contas', [App\Http\Controllers\ContaController::class, 'store']);
Route::get('/contas/{conta}/edit', [App\Http\Controllers\ContaController::class, 'edit']);
Route::put('/contas/{conta}', [App\Http\Controllers\ContaController::class, 'update']);
Route::delete('/contas/{conta}', [App\Http\Controllers\ContaController::class, 'destroy']);

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.listar');
Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categoria.cadastrar');
Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store']);
Route::get('/categorias/{categoria}/edit', [App\Http\Controllers\CategoriaController::class, 'edit']);
Route::put('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'update']);
Route::delete('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'destroy']);


// Route::get('/home', function(){
// 	return view('layouts/home');
// });
