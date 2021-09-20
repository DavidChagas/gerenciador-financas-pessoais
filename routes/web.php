<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index'])->name('receitas');

Route::get('/contas', [App\Http\Controllers\ContaController::class, 'index'])->name('conta.listar');
Route::get('/contas/{conta}/edit', [App\Http\Controllers\ContaController::class, 'edit']);
Route::post('/conta', [App\Http\Controllers\ContaController::class, 'store']);
Route::get('/contas/create', [App\Http\Controllers\ContaController::class, 'create'])->name('conta.cadastrar');


// Route::get('/home', function(){
// 	return view('layouts/home');
// });
