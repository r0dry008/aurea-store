<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Session;
use Livewire\Component;
use Illuminate\Http\Request;

class CatalogComponent extends Component
{

    public $cantidad = 1;

    #[Session]
    public array $cartItems = [];

    public function increment(){
        $this->cantidad++;
    }
    public function decrement(){
        $this->cantidad--;
    }
    public function addToCart(int $id, int $cantidad){
        $product = Product::findOrFail($id);
        if(!$product){
            return;
        }
        if(isset($this->cartItems[$id])){
            $this->cartItems[$id]['cantidad'] += $cantidad;
            // $this->dispatch('cart:Updated');
            // $this->reset('openModal');
        }else{            
        $this->cartItems[$id] = [
            'id' => $product->id,
            'nombre' => $product->name,
            'precio' => $product->price,
            'descripcion' => $product->description,
            'cantidad' => $cantidad,
        ];
    }
        session()->put('cartItems', $this->cartItems);
        $this->dispatch('cart:Updated');
        $this->reset('cantidad');
    }
    // lo necesario para traer solo los productos que tienen skus
    // public function filterProducts(Request $request){
    //     $products = Product::has('skus')->get();
    //     return $products;
    // }

    // end filter products

    // para traer las categorias de los productos

    // end get categories
    public $selectedCategoryId = null;
    public function render()
    {

    // traer las categorias de los productos
        $navCategories = Category::whereNull('parent_id')->with('children')->get();
        $query = Product::query();
        if($this->selectedCategoryId){
            $query->where('category_id', $this->selectedCategoryId);
        }
    //

        $products = $query->get();
        // $productSkus = $products->map(function ($product) {
        //     return $product->skus;
        // });
        return view('livewire.public.catalog-component', compact('products', 'navCategories'));
    }
    public function index(){
        $this->render();
    }

}
