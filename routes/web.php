<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadoController;

Route::get('/', function(){ return redirect()->route('estados.index'); });
Route::get('/estados', [EstadoController::class, 'index'])->name('estados.index');
Route::post('/estados/sync', [EstadoController::class, 'sync'])->name('estados.sync');
Route::get('/estados/{id}/municipios', [EstadoController::class, 'municipios'])->name('estados.municipios');
