<?php

namespace App\Livewire\Public;

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CartComponent extends Component
{
    #[Rule('required|min:3|max:255')]
    public $name_client = '';

    #[Rule('required|min:8|numeric')]
    public $phone_client = '';

    #[Rule('required|email')]
    public $email = '';

    public $message = '';

    #[Rule('required')]
    public $via = '';

    public array $cartItems = [];

    public $openModal = false;

    public array $viaOptions = [
        'Delivery' => 'Delivery',
        'Store' => 'Store',
    ];

    public function mount()
    {
        $this->cartItems = session()->get('cartItems', []);
    }

    /**
     * Propiedad Computada: Cachea el total en memoria durante el renderizado.
     * En tu vista Blade la debes llamar como: $this->total (sin los paréntesis).
     */
    #[Computed]
    public function total()
    {
        return collect($this->cartItems)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });
    }

    public function increment($productId)
    {
        if (isset($this->cartItems[$productId])) {
            $this->cartItems[$productId]['cantidad']++;
            $this->saveCartState();
        }
    }

    public function decrement($productId)
    {
        if (isset($this->cartItems[$productId])) {
            $this->cartItems[$productId]['cantidad']--;

            if ($this->cartItems[$productId]['cantidad'] <= 0) {
                unset($this->cartItems[$productId]);
            }

            $this->saveCartState();
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cartItems[$productId])) {
            unset($this->cartItems[$productId]);
            $this->saveCartState();
        }
    }

    /**
     * Guarda el pedido en la Base de Datos.
     */
    public function saveOrder()
    {
        // Validación automática mediante las propiedades #[Rule]
        $this->validate();

        if (empty($this->cartItems)) {
            $this->addError('cart', 'No puedes procesar un pedido con el carrito vacío.');
            return;
        }

        // Crear la orden principal
        $order = Order::create(
            $this->only('name_client', 'phone_client', 'email', 'message', 'via')
        );

        // Guardar cada ítem asociado a la orden (Corregido con los índices reales)
        foreach ($this->cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'], //  Corregido (Coincide con tu estructura de sesión)
                'quantity'   => $item['cantidad'],
                'price'      => $item['precio'],
            ]);
        }

        // Limpiar la sesión del carrito y actualizar la propiedad local
        session()->forget('cartItems');
        $this->cartItems = [];

        // Notificar a componentes globales (como un contador del navbar)
        $this->dispatch('cart:Updated');

        // Redirección limpia
        return redirect()->route('reverb.cart');
    }

    /**
     * Método auxiliar privado para evitar repetir código (DRY).
     */
    private function saveCartState()
    {
        session()->put('cartItems', $this->cartItems);
        $this->dispatch('cart:Updated');
    }

    public function render()
    {
        return view('livewire.public.cart-component');
    }
}