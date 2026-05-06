<?php

use App\Http\Controllers\Public\ServiceController;
// use App\Livewire\Admin\Service;
use Illuminate\Support\Facades\Route;

Route::resource('/servicios', ServiceController::class);
Route::resource('/precios', ServiceController::class);
Route::resource('/contacto', ServiceController::class);

