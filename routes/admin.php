<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Service;
use App\Livewire\Admin\ServiceComponent;
use Illuminate\Support\Facades\Route;

// Estas rutas tendrán prefijo /admin y nombre admin.
Route::get('servicios', ServiceComponent::class)->name('servicios.index');

Route::resource('precios', ServiceComponent::class);
Route::resource('contacto', ServiceComponent::class);
Route::resource('catalogo',ServiceComponent::class);
// Route::get('catalog', function () {
//     return view('public.pages.catalog');
// })->name('catalog');
// para categorias
// Route::get('category', function(){return view('admin.pages.category');
Route::get('category', CategoryManager::class)->name('category');

// })->name('category');