<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/api/getTotais', [App\Http\Controllers\HomeController::class, 'getTotais']);
Route::get('/api/getTotaisCategorias', [App\Http\Controllers\HomeController::class, 'getTotaisCategorias']);
Route::get('/api/aportes', [App\Http\Controllers\ObjetivoAporteController::class, 'aportes']);
Route::get('/api/reativarObjetivo', [App\Http\Controllers\ObjetivoController::class, 'reativarObjetivo']);
Route::get('/api/reativarConta', [App\Http\Controllers\ContaController::class, 'reativarConta']);
Route::get('/api/reativarCategoria', [App\Http\Controllers\CategoriaController::class, 'reativarCategoria']);
Route::get('/api/getPendencias', [App\Http\Controllers\HomeController::class, 'getPendencias']);
Route::get('/api/getPendencias', [App\Http\Controllers\HomeController::class, 'getPendencias']);
Route::get('/api/receitas/pagar', [App\Http\Controllers\ReceitaController::class, 'marcarComoPaga']);
Route::get('/api/despesas/pagar', [App\Http\Controllers\DespesaController::class, 'marcarComoPaga']);

Route::get('/getRelatorios', [App\Http\Controllers\RelatoriosController::class, 'getRelatorios']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/usuario/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->middleware('auth');
Route::put('/usuario/{usuario}', [App\Http\Controllers\UsuarioController::class, 'update'])->middleware('auth');
Route::delete('/usuario/{usuario}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->middleware('auth');

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
Route::post('/receitas/delete/{receita}', [App\Http\Controllers\ReceitaController::class, 'destroy'])->middleware('auth');

Route::get('/despesas', [App\Http\Controllers\DespesaController::class, 'index'])->name('despesa.listar')->middleware('auth');
Route::get('/despesas/create', [App\Http\Controllers\DespesaController::class, 'create'])->name('despesa.cadastrar')->middleware('auth');
Route::post('/despesas', [App\Http\Controllers\DespesaController::class, 'store'])->middleware('auth');
Route::get('/despesas/{despesa}/edit', [App\Http\Controllers\DespesaController::class, 'edit'])->middleware('auth');
Route::put('/despesas/{despesa}', [App\Http\Controllers\DespesaController::class, 'update'])->middleware('auth');
Route::post('/despesas/delete/{despesa}', [App\Http\Controllers\DespesaController::class, 'destroy'])->middleware('auth');

Route::get('/objetivos', [App\Http\Controllers\ObjetivoController::class, 'index'])->name('objetivo.listar')->middleware('auth');
Route::get('/objetivos/create', [App\Http\Controllers\ObjetivoController::class, 'create'])->name('objetivo.cadastrar')->middleware('auth');
Route::post('/objetivos', [App\Http\Controllers\ObjetivoController::class, 'store'])->middleware('auth');
Route::get('/objetivos/{objetivo}/edit', [App\Http\Controllers\ObjetivoController::class, 'edit'])->middleware('auth');
Route::put('/objetivos/{objetivo}', [App\Http\Controllers\ObjetivoController::class, 'update'])->middleware('auth');
Route::delete('/objetivos/{objetivo}', [App\Http\Controllers\ObjetivoController::class, 'destroy'])->middleware('auth');

Route::post('/objetivoAportes', [App\Http\Controllers\ObjetivoAporteController::class, 'store'])->middleware('auth');
Route::delete('/objetivoAportes/{objetivoAporte}', [App\Http\Controllers\ObjetivoAporteController::class, 'destroy'])->middleware('auth');
Route::put('/objetivoAportes/{objetivoAporte}', [App\Http\Controllers\ObjetivoAporteController::class, 'update'])->middleware('auth');

Route::get('/relatorios', function(){
	return view('layouts/relatorios');
});

// Route::get('/home', function(){
// 	return view('layouts/home');
// });
