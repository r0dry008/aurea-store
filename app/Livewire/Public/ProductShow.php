<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Component;

class ProductShow extends Component
{
    public $product;


    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.product-show');
    }
}
