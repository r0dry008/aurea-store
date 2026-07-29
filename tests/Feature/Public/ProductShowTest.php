<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSku;

test('the product detail page shows similar products from the same category', function () {
    $category = Category::factory()->create();

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Producto principal',
        'slug' => 'producto-principal',
        'is_active' => true,
    ]);

    $relatedProduct = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Producto similar',
        'slug' => 'producto-similar',
        'is_active' => true,
    ]);

    ProductSku::factory()->create([
        'product_id' => $product->id,
        'price' => 100,
        'is_active' => true,
    ]);

    ProductSku::factory()->create([
        'product_id' => $relatedProduct->id,
        'price' => 80,
        'is_active' => true,
    ]);

    $response = $this->get('/reverb/productos/producto-principal');

    $response
        ->assertStatus(200)
        ->assertSee('Productos similares')
        ->assertSee('Producto similar');
});
