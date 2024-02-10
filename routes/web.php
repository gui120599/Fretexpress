<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\FreteController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaidaController;
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
Route::get('/chartjs', function () {
    return view('chartjs');
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Rotas que requerem autenticação
Route::middleware('auth')->group(function () {

    Route::get('/entradas-saidas', [DashboardController::class,'mostrarEntradasSaidas'])->name('entradas-saidas');

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/motoristas',[MotoristaController::class,'index'])->name('motoristas.motoristas');
    Route::post('/motoristas',[MotoristaController::class,'store'])->name('motoristas.store');
    Route::get('motoristas/{id}/edit',[MotoristaController::class,'edit'])->name('motoristas.edit');
    Route::patch('/motoristas/{id}',[MotoristaController::class, 'update'])->name('motoristas.update');
    Route::delete('/motoristas/{id}',[MotoristaController::class,'destroy'])->name('motoristas.destroy');

    Route::get('/fretes',[FreteController::class,'index'])->name('fretes.fretes');
    Route::post('/fretes',[FreteController::class,'store'])->name('fretes.store');
    Route::get('/fretes/{id}/edit',[FreteController::class,'edit'])->name('fretes.edit');
    Route::patch('/fretes/{id}',[FreteController::class, 'update'])->name('fretes.update');
    Route::delete('/fretes/{id}',[FreteController::class,'destroy'])->name('fretes.destroy');

    Route::get('/entradas',[EntradaController::class,'index'])->name('entradas.entradas');
    Route::post('/entradas',[EntradaController::class,'store'])->name('entradas.store');
    Route::get('/entradas/{id}/edit',[EntradaController::class,'edit'])->name('entradas.edit');
    Route::patch('/entradas/{id}',[EntradaController::class, 'update'])->name('entradas.update');
    Route::delete('/entradas/{id}',[EntradaController::class,'destroy'])->name('entradas.destroy');

    Route::get('/saidas',[SaidaController::class,'index'])->name('saidas.saidas');
    Route::post('/saidas',[SaidaController::class,'store'])->name('saidas.store');
    Route::get('/saidas/{id}/edit',[SaidaController::class,'edit'])->name('saidas.edit');
    Route::patch('/saidas/{id}',[SaidaController::class, 'update'])->name('saidas.update');
    Route::delete('/saidas/{id}',[SaidaController::class,'destroy'])->name('saidas.destroy');

    /*Route::get('/financeiro',[FinanceiroController::class,'index'])->name('financeiro.financeiro');
    Route::post('/financeiro',[FinanceiroController::class,'store'])->name('financeiro.store');
    Route::get('/financeiro/{id}/edit',[FinanceiroController::class,'edit'])->name('financeiro.edit');
    Route::patch('/financeiro/{id}',[FinanceiroController::class, 'update'])->name('financeiro.update');
    Route::delete('/financeiro/{id}',[FinanceiroController::class,'destroy'])->name('financeiro.destroy');*/
});

require __DIR__.'/auth.php';
