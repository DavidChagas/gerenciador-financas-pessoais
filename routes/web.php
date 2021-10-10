<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/api/teste', [App\Http\Controllers\HomeController::class, 'teste']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/contas', [App\Http\Controllers\ContaController::class, 'index'])->name('conta.listar')->middleware('auth');
Route::get('/contas/create', [App\Http\Controllers\ContaController::class, 'create'])->name('conta.cadastrar')->middleware('auth');
Route::post('/contas', [App\Http\Controllers\ContaController::class, 'store'])->middleware('auth');
Route::get('/contas/{conta}/edit', [App\Http\Controllers\ContaController::class, 'edit'])->middleware('auth');
Route::put('/contas/{conta}', [App\Http\Controllers\ContaController::class, 'update'])->middleware('auth');
Route::delete('/contas/{conta}', [App\Http\Controllers\ContaController::class, 'destroy'])->middleware('auth');

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categoria.listar')->middleware('auth');
Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categoria.cadastrar')->middleware('auth');
Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->middleware('auth');
Route::get('/categorias/{categoria}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->middleware('auth');
Route::put('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'update'])->middleware('auth');
Route::delete('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->middleware('auth');

Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index'])->name('receita.listar')->middleware('auth');
Route::get('/receitas/create', [App\Http\Controllers\ReceitaController::class, 'create'])->name('receita.cadastrar')->middleware('auth');
Route::post('/receitas', [App\Http\Controllers\ReceitaController::class, 'store'])->middleware('auth');
Route::get('/receitas/{receita}/edit', [App\Http\Controllers\ReceitaController::class, 'edit'])->middleware('auth');
Route::put('/receitas/{receita}', [App\Http\Controllers\ReceitaController::class, 'update'])->middleware('auth');
Route::delete('/receitas/{receita}', [App\Http\Controllers\ReceitaController::class, 'destroy'])->middleware('auth');

Route::get('/despesas', [App\Http\Controllers\DespesaController::class, 'index'])->name('despesa.listar')->middleware('auth');
Route::get('/despesas/create', [App\Http\Controllers\DespesaController::class, 'create'])->name('despesa.cadastrar')->middleware('auth');
Route::post('/despesas', [App\Http\Controllers\DespesaController::class, 'store'])->middleware('auth');
Route::get('/despesas/{despesa}/edit', [App\Http\Controllers\DespesaController::class, 'edit'])->middleware('auth');
Route::put('/despesas/{despesa}', [App\Http\Controllers\DespesaController::class, 'update'])->middleware('auth');
Route::delete('/despesas/{despesa}', [App\Http\Controllers\DespesaController::class, 'destroy'])->middleware('auth');


// Route::get('/home', function(){
// 	return view('layouts/home');
// });
