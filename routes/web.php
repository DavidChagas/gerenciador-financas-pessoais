<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index'])->name('receitas');
Route::get('/conta', function(){
	return view('layouts/contas/cadastrar');
})->name('conta');
// Route::get('/home', function(){
// 	return view('layouts/home');
// });
