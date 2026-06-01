<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;

class CounterComponent extends Component
{
    public $counter = 0;

    // Nota: Removimos la propiedad pública $cartItems si no la usas en la vista del header,
    // mantenerla pública innecesariamente hace que viaje peso extra en cada petición.

    /**
     * Se ejecuta SOLO al cargar la página por primera vez.
     */
    public function mount()
    {
        $this->loadCartCount();
    }

    /**
     * 🔥 Escucha el evento y actualiza el contador en tiempo real sin recargar la página.
     */
    #[On('cart:Updated')]
    public function updateCounter()
    {
        $this->loadCartCount();
    }

    /**
     * Método auxiliar para consultar la sesión de manera limpia.
     */
    private function loadCartCount()
    {
        $cartItems = session()->get('cartItems', []);
        
        // Si en tu carrito sumas cantidades (ej: 2 manzanas + 1 pera = 3 artículos), usa array_sum:
        $this->counter = array_sum(array_column($cartItems, 'cantidad'));
        
        // Si solo te interesa contar cuántos productos distintos hay, usa count:
        // $this->counter = count($cartItems);
    }

    public function render()
    {
        return view('livewire.public.counter-component');
    }
}