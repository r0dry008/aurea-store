<?php

namespace App\Livewire\Admin;

use App\Models\Service as ModelsService;
use Illuminate\Http\Request;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Service extends Component
{

    // #[Rule('required')]
    public $name;

    // #[Rule('required')]
    public $description;

    // #[Rule('required')]
    public $image;

    public function index()
    {
        return $this->render();
    }

    public function save()
    {
        // dd($this->name, $this->description, $this->image);
        $data = $this->validate([
            'name' => 'required',
            'description' => 'required',
            // 'image' => 'required',
        ]);
        $data['image'] = "imagen.jpg";
        $service =  ModelsService::create($data);
        return redirect()->route('admin.servicios.index', $service);
    }



    public function render()
    {
        //     return view('livewire.admin.service')
        // ->layout('components.layouts.app');
        return view('livewire.admin.service');
    }

    public function store()
    {
        
    }

}
