<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TerminalCheckController;
use App\Models\Cooperativa;
use App\Models\Persona;
use Illuminate\Http\Request;


Route::get('/', [TerminalCheckController::class, 'index'])->name('terminal-check.index');
Route::get('/{cooperativa_id}', [TerminalCheckController::class, 'index'])->name('terminal-check.by-id');
Route::post('/terminal-check/enviar-correo', [TerminalCheckController::class, 'enviarCorreo'])->name('terminal-check.enviar-correo');