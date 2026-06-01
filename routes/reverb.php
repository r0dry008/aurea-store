<?php

use App\Livewire\Public\ProductShow;
use App\Http\Controllers\Public\ServiceController;
use Illuminate\Support\Facades\Route;

Route::resource('servicios', ServiceController::class);
Route::resource('precios', ServiceController::class);
Route::resource('contacto', ServiceController::class);

Route::get('catalog', function () {
    return view('public.pages.catalog');
})->name('catalog');

Route::get('cart', function () {
    return view('public.pages.cart');
})->name('cart');

Route::get('productos/{slug}', ProductShow::class)->name('product.show');
