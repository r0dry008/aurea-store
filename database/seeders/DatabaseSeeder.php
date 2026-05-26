<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSku;
// use App\Models\Service;
// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    // 1. Crear Atributos base
    $color = Attribute::create(['name' => 'Color']);
    $talla = Attribute::create(['name' => 'Talla']);

    // 2. Crear valores para esos atributos
    $rojo = AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Rojo']);
    $azul = AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Azul']);
    $s    = AttributeValue::create(['attribute_id' => $talla->id, 'value' => 'S']);
    $m    = AttributeValue::create(['attribute_id' => $talla->id, 'value' => 'M']);

    // 3. Crear 3 Categorías Principales (Padres sin parent_id)
    Category::factory(3)->create(['parent_id' => null])->each(function ($parentCategory) use ($rojo, $azul, $s, $m) {
        
        // 4. Por cada categoría principal, crear 2 Subcategorías (Hijas)
        Category::factory(2)->create(['parent_id' => $parentCategory->id])->each(function ($subCategory) use ($rojo, $azul, $s, $m) {
            
            // 5. Crear 3 Productos asignados estrictamente a la SUBCATEGORÍA
            Product::factory(3)->create(['category_id' => $subCategory->id])->each(function ($product) use ($rojo, $azul, $s, $m) {
                
                // 6. Crear 2 SKUs por cada producto
                $skus = ProductSku::factory(2)->create(['product_id' => $product->id]);

                // 7. ASIGNAR ATRIBUTOS A LOS SKUS (La tabla pivote)
                foreach ($skus as $sku) {
                    // Combinamos un color y una talla aleatoria para armar la variante
                    $sku->attributeValues()->attach([
                        collect([$rojo->id, $azul->id])->random(),
                        collect([$s->id, $m->id])->random(),
                    ]);
                }
            });
        });
    });
}
}
