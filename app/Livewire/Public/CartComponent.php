<?php

namespace App\Livewire\Public;

use App\Models\Order;
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

    public $cartItems = [];

    public $openModal = false;

    public $viaOptions = [
        'Delivery' => 'Delivery',
        'Store' => 'Store',
    ];


    public function mount()
    {
        $this->cartItems = session()->get('cartItems', []);
    }

    public function total(){
        return array_sum(
            array_map(function($item){
                return $item['precio'] * $item['cantidad'];
            }, $this->cartItems));
    }
        public function removeFromCart($productId)
    {
        if(isset($this->cartItems[$productId])){
            unset($this->cartItems[$productId]);
        session()->put('cartItems', $this->cartItems);
        $this->dispatch('cart:Updated');
        }
    }

    // funciones increment y decrement
    public function increment($productId){
        $this->cartItems = session()->get('cartItems', []);
        if(isset($this->cartItems[$productId])){
            $this->cartItems[$productId]['cantidad']++;
            session()->put('cartItems', $this->cartItems);
            $this->dispatch('cart:Updated');
        }
    }
    public function decrement($productId){
        $this->cartItems = session()->get('cartItems', []);
        if(isset($this->cartItems[$productId])){
            $this->cartItems[$productId]['cantidad']--;
            if($this->cartItems[$productId]['cantidad'] <= 0){
                unset($this->cartItems[$productId]);
            }
            session()->put('cartItems', $this->cartItems);
            $this->dispatch('cart:Updated');
        }
    }

    // guardar la order
    public function saveOrder(){

        $this->cartItems = session()->get('cartItems', []);
        $this->validate();
        
        $order = Order::create(
            $this->only('name_client', 'phone_client', 'email', 'message', 'via')
        );
        foreach ($this->cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['id'],
                'quantity' => $item['cantidad'],
                'price' => $item['precio'],
            ]);
        // dd($order);
        }
        // $this->dispatch('cart:Updated');
        session()->forget('cartItems');
        $this->dispatch('cart:Updated');
        return redirect()->route('reverb.cart');
    }


    public function render()
    {
        return view('livewire.public.cart-component');
    }
}
