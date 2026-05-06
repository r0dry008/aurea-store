<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Session;
use Livewire\Component;

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



    public function render()
    {
        $products = Product::all();

        return view('livewire.public.catalog-component', compact('products'));
    }
    public function index(){
        $this->render();
    }

}
