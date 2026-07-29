<?php

namespace App\Livewire\Public;

use Livewire\Component;

class HeaderSearchComponent extends Component
{
    public string $search = '';

    public function searchProducts(){
        if(trim ($this->search) === ''){
            return redirect()->route('reverb.catalog');
        }
        return redirect()->route('reverb.catalog', 
        ['search' => $this->search]);
    }

    public function render()
    {
        return view('livewire.public.header-search-component');
    }
}
