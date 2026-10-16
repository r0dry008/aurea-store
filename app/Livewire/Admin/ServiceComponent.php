<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ServiceComponent extends Component
{
    use WithPagination;


    //variables para paginación y búsqueda
    #[Url(history: true)]
    public $search;
    #[Url(history: true)]
    public $perPage = 5;
    #[Url(history: true)]
    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    //variables para los datos del formulario
    use WithFileUploads;
    // #[Rule('required')]
    public $name;

    // #[Rule('required')]
    public $description;

    // #[Rule('required')]
    public $image;

    public $imageEdit;
    public $serviceId;


    public function save()
    {
        $data = $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        if ($this->image) {
            $data['image'] = $this->image->store('services','public');
            
        }
        // $data['image'] = "imagen.jpg";        
        $service = Service::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Servicio creado correctamente',
            'text' => 'El servicio se ha creado exitosamente',
        ]);
        
        return redirect()->route('admin.servicios.index', $service);
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        $this->serviceId = $service->id;

        $this->name = $service->name;
        $this->description = $service->description;
        $this->imageEdit = $service->image;
    }

    public function update()
    {
        $data = $this->validate([
            'name' => 'required',
            'description' => 'required',
            // 'image' => 'required',
        ]);

        $service = Service::findOrFail($this->serviceId);
        if ($this->image) {
            // dd($this->imageEdit);   

            if($this->imageEdit){
                Storage::disk('public')->delete($this->imageEdit);
            }
            $data['image'] = $this->image->store('services','public');
            
        }
        // $data['image'] = "imagen.jpg";        
        $service->update($data);
        
        // Mostrar notificación de éxito y cerrar modal
        $this->dispatch('notify', 
            variant: 'success', 
            title: 'Servicio actualizado correctamente',
            message: 'El servicio se ha actualizado exitosamente'
        );
        // Cerrar el modal de edición
        $this->dispatch('close-edit-modal');
        // Limpiar el formulario
        $this->resetForm();
    }
    //para eliminar un servicio

    #[On('delete-service')]
    public function delete($id)
    {
        $service = Service::findOrFail($id);

        if($service->image){
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();
        // return redirect()->route('admin.servicios.index');
        $this->dispatch('notify', 
            variant: 'success', 
            title: '¡Eliminado!',
            message: 'El registro se ha eliminado correctamente.'
        );
    }

    public function updated($property)
    {
        if($property === 'search') {
            $this->resetPage();
        }
    }

    // public function confirmDelete($id)
    // {
    //     $this->dispatch('swal:confirm', [
    //     'title' => '¿Estás seguro?',
    //     'text' => 'No podrás revertir esta acción.',
    //     'id' => $id,
    //     'componentId' => $this->getId(), // ID interno de Livewire
    //     'method' => 'delete'             // El método real que elimina
    // ]);
    // }

// para resetear el formulario
    public function resetForm(){
        $this->reset([
            'name',
            'description',
            'image',
            'imageEdit',
            'serviceId',
        ]);
    }

    // #[On('service-deleted')]
    // public function refresh()
    // {
    // }
    public function setSortBy($sortByField)
    {
        if($sortByField === $this->sortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDirection = 'asc';
    }

    public function render()
    {
        $services = Service::search($this->search)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
        
        return view('livewire.admin.service-component', compact('services'));

    }

    public function index()
    {
        return $this->render();
    }

    

}
