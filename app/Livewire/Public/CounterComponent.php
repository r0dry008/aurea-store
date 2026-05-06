<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;

class CounterComponent extends Component
{
    public $counter = 0;

    public $cartItems = [];

    #[On('cart:Updated')]
    public function mount(){
        $cartItems = session()->get('cartItems', []);
        $this->counter = count($cartItems);
    }

    public function render()
    {
        return view('livewire.public.counter-component');
    }
}
