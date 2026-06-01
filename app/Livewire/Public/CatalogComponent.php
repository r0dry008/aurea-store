<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

class CatalogComponent extends Component
{
    public $cantidad = 1;
    public array $cartItems = [];
    public ?int $selectedCategoryId = null;

    // Usamos las propiedades reactivas en la URL con la sintaxis de Livewire 3
    protected $queryString = [
        'selectedCategoryId' => ['as' => 'category'],
    ];

    public function mount()
    {
        $this->cartItems = session()->get('cartItems', []);
    }

    /**
     * 🔥 Acción reactiva: Cambia la categoría actual al hacer click en el Breadcrumb o menú.
     */
    public function selectCategory(?int $categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->reset('cantidad'); // Resetea selectores abiertos por si acaso
    }

    /**
     * Construcción dinámica y recursiva del árbol de migas de pan.
     */
    public function buildBreadcrumbs(): array
    {
        // El inicio siempre es fijo
        $breadcrumbs = [
            [
                'label' => 'Home',
                'id' => null, // Volver al inicio limpia filtros
            ],
            [
                'label' => 'Catalog',
                'id' => null, // Catalog base limpia filtros de categoría
            ],
        ];

        if (! $this->selectedCategoryId) {
            return $breadcrumbs;
        }

        $category = Category::with('parent')->find($this->selectedCategoryId);

        if (! $category) {
            return $breadcrumbs;
        }

        $chain = [];
        $current = $category;

        // Bucle recursivo hacia arriba para recolectar los ancestros
        while ($current) {
            array_unshift($chain, $current);
            $current = $current->parent;
        }

        // Agregamos cada eslabón al árbol de breadcrumbs
        foreach ($chain as $crumbCategory) {
            $breadcrumbs[] = [
                'label' => $crumbCategory->name,
                'id' => $crumbCategory->id,
            ];
        }

        return $breadcrumbs;
    }

    public function increment()
    {
        $this->cantidad++;
    }

    public function decrement()
    {
        if ($this->cantidad > 1) {
            $this->cantidad--;
        }
    }

    public function addToCart(int $id, int $cantidad)
    {
        $product = Product::find($id);
        if (! $product) return;

        // Nota: Asegúrate de usar 'product_id' en lugar de 'id' para mantener simetría con tu saveOrder()
        if (isset($this->cartItems[$id])) {
            $this->cartItems[$id]['cantidad'] += $cantidad;
        } else {            
            $this->cartItems[$id] = [
                'product_id' => $product->id, 
                'nombre'     => $product->name,
                'precio'     => $product->price,
                'cantidad'   => $cantidad,
            ];
        }

        session()->put('cartItems', $this->cartItems);
        $this->dispatch('cart:Updated');
        $this->reset('cantidad');
    }

    public function render()
    {
        // 1. Cargar categorías principales y sus hijos para la barra de navegación lateral/superior
        $navCategories = Category::whereNull('parent_id')->with('children')->get();

        // 2. Filtrar productos según la categoría seleccionada
        $query = Product::query()->has('skus'); // Trae solo productos con stock/skus activos

        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        $products = $query->with('skus')->get();

        // 3. Generar el árbol reactivo
        $breadcrumbs = $this->buildBreadcrumbs();

        return view('livewire.public.catalog-component', compact('products', 'navCategories', 'breadcrumbs'));
    }
}