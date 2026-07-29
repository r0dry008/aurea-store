<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Url;

class CatalogComponent extends Component
{
    public $cantidad = 1;
    public array $cartItems = [];



    #[Url(as: 'category')]
    public ?int $selectedCategoryId = null;
    //variables para busqueda

    #[Url(except: '')]
    public ?string $search = '';

    // Usamos las propiedades reactivas en la URL con la sintaxis de Livewire 3
    protected $queryString = [
        'selectedCategoryId' => ['as' => 'category'],
        'search' => ['except' => ''],
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
        $this->search = '';
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


    protected function descendantCategoryIds(int $categoryId): array
    {
        $ids = [$categoryId];

        foreach (Category::where('parent_id', $categoryId)->pluck('id') as $childId) {
            $ids = array_merge($ids, $this->descendantCategoryIds((int) $childId));
        }

        return array_values(array_unique($ids));
    }
    public function sumaStockSkus(int $productId):bool|int
        { 
            $product = Product::where('id', $productId)
                                    ->activeProduct()
                                    ->hasActiveSkus()
                                    ->with(['skus'=>fn($q)=>$q->activeSku()])
                                // ->with(['skus' => fn ($query) => $query->where('is_active', true)])

                                    ->first();
                                    if($product->skus->sum('stock')>0){
                                        return true;
                                    }
                                    return false;
            // return ;
        }

    public function render()
    {
        // 1. Cargar categorías principales y sus hijos para la barra de navegación lateral/superior
        $navCategories = Category::whereNull('parent_id')->with('children')->get();

        // 2. Filtrar productos según la categoría seleccionada
        $query = Product::query()->has('skus')->activeProduct()
                                    ->hasActiveSkus(); // Trae solo productos con stock/skus activos

        if ($this->selectedCategoryId) {
            $query->whereIn('category_id', $this->descendantCategoryIds($this->selectedCategoryId));
        }

        // metodo de busqueda de productos por nombre, categoria o descripcion
        // 3. Si la categoría está seleccionada, filtra por categoría
        if (! empty(trim($this->search))) {
            $searchTerm = '%' . trim($this->search) . '%';
            $matchingCategoryIds = Category::where('name', 'like', $searchTerm)
                // ->where('is_active', true)
                ->pluck('id')
                ->all();

            $categoryTreeIds = [];

            foreach ($matchingCategoryIds as $categoryId) {
                $categoryTreeIds = array_merge($categoryTreeIds, $this->descendantCategoryIds((int) $categoryId));
            }

            $categoryTreeIds = array_values(array_unique($categoryTreeIds));

            $query->where(function ($subQuery) use ($searchTerm, $categoryTreeIds) {
                $subQuery->where('name', 'like', $searchTerm)
                    // ->where('is_active', true)
                    ->orWhere('description', 'like', $searchTerm)
                    ->when(! empty($categoryTreeIds), function ($query) use ($categoryTreeIds) {
                        $query->orWhereIn('category_id', $categoryTreeIds);
                    });
            });
        }
        // end


        $products = $query->with('skus')->get();
        // 3. Generar el árbol reactivo
        $breadcrumbs = $this->buildBreadcrumbs();

        return view('livewire.public.catalog-component', compact('products', 'navCategories', 'breadcrumbs'));
    }
}