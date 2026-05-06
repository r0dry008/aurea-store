<?php

use App\Livewire\Admin\Service;
use App\Livewire\Admin\ServiceComponent;
use Illuminate\Support\Facades\Route;

// Estas rutas tendrán prefijo /admin y nombre admin.
Route::get('servicios', ServiceComponent::class)->name('servicios.index');
Route::get('servicios/create', ServiceComponent::class)->name('servicios.create');
Route::get('servicios/{id}/edit', ServiceComponent::class)->name('servicios.edit');
Route::post('servicios', ServiceComponent::class)->name('servicios.store');
Route::put('servicios/{id}', ServiceComponent::class)->name('servicios.update');
Route::delete('servicios/{id}', ServiceComponent::class)->name('servicios.destroy');
// Route::resource('servicios', Service::class);
// Route::get('servicios', Service::class)->name('servicios.index');
// Route::get('servicios', Service::class)->name('admin.servicios.index');
Route::resource('precios', ServiceComponent::class);
Route::resource('contacto', ServiceComponent::class);
Route::resource('catalogo',ServiceComponent::class);
