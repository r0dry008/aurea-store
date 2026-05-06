<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence(3, true); // Genera 3 palabras, como un título

        return [
            // 2. Usamos la variable $name definida arriba.
            'name' => $name,
            
            // 3. CRÍTICO: Genera el slug A PARTIR del nombre.
            // Esto asegura que si el nombre es "Amazing Product", el slug es "amazing-product".
            'slug' => Str::slug($name), // Requiere "use Illuminate\Support\Str;"
            
            // Texto y Precio
            'description' => $this->faker->text(100),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'image' => $this->faker->imageUrl(640, 480, 'products'), // Mejor especificar categoría
            
            // SEO: Ajustar el tamaño a valores más realistas para SEO.
            'seo_title' => $this->faker->text(60), // Máx 60 caracteres para títulos de Google
            'seo_description' => $this->faker->text(160), // Máx 160 caracteres
            'seo_keywords' => $this->faker->words(5, true), // Lista de 5 palabras clave separadas por coma
        ];
    }
}
