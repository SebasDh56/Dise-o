<?php

use App\Http\Controllers\ApiCooperativaController;

Route::get('/cooperativas', [ApiCooperativaController::class, 'getCooperativas']);
Route::get('/cooperativas/{id}', [ApiCooperativaController::class, 'getCooperativa']);
Route::post('/cooperativas/{id}/revisiones', [ApiCooperativaController::class, 'enviarRevisiones']);