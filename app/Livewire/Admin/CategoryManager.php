<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nette\Schema\Message;

use function Livewire\Volt\title;

class CategoryManager extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name = '';
    public $description = '';
    public $slug = '';
    public $image;

    public $currentImageUrl;

    public $categoryId;

    public $isCustomSlug = false;

    public $createAnother = false;

    public $parent_id = null;

    public function updatedName($value){
        if(! $this -> isCustomSlug){
            $this->slug = Str::slug($value);
        }
    }

    public function updatedSlug($value){
        $this->isCustomSlug = true;
        $this->slug = Str::slug($value);
    }
    // parent id de una categoria

    // public function

    // final de parent id de una categoria

        public function save(){


        $this->validate([
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:categories,slug',
        'description' => 'required|string',
        'image'       => 'required|image|max:2048',
        'parent_id'   => 'nullable|exists:categories,id',
        ]);
        $imagePath = $this->image ? $this->image->store('categories','public') :null;

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'image_path'=>$imagePath,
            'parent_id'=>$this->parent_id,
            'slug' => $this->slug,
            ]);
        $this->resetForm();
    
            if(! $this->createAnother){
                $this->dispatch('close-create-modal');

            }
            
        $this->dispatch(
            'notify',
            variant:'success',
            title:'Creado',
            message:'La categoria ha sido creada correctamente'
        );
    }
    public function resetForm(){
        $this->reset(['name','slug','description','image','currentImageUrl','parent_id']);
        $this->resetErrorBag();
    }
    // editar categoria
    public function editCategory($id){

        $this->resetForm();


        $category = Category::findOrFail($id);

        $this->categoryId       = $category->id;
        $this->name             = $category->name; 
        $this->description      = $category->description; 
        $this->parent_id        = $category->parent_id;
        $this->currentImageUrl  = $category->image_path;
        $this->slug             = $category->slug; 
        
    }
    public function update(){
        $this->validate([
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:categories,slug,' . $this->categoryId,
        'description' => 'required|string',
        'image'       => 'nullable|image|max:2048',
        'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $imagePath = $category->image_path;

        if($this->image){
            if($category->image_path && Storage::disk('public')->exists($category->image_path)){
                Storage::disk('public')->delete($category->image_path);
            }
            $imagePath = $this->image->store('categories','public');
        }
        $category->update([
            'name'=> $this->name,
            'description'=> $this->description,
            'slug'=> $this->slug,
            'parent_id' => $this->parent_id? :null,
            'image_path'=> $imagePath,
        ]);
        $this->dispatch('close-edit-modal');
    }
    // fin de editar categoria

    // eliminar categoria
    #[On('delete-category')]
    public function delete($id){
        $category = Category::findOrFail($id);
        
        if($category->image_path){
            Storage::disk('public')->delete($category->image_path);
        }
        $category->delete();

        // para el toast
        $this->dispatch('notify', 
            variant:'success',
            title:'Elminado!',
            message:'La categoria se ha eliminado correctamente.'
        );
    }

    // fin eliminar categoria
    public function render()
    {
        $categories = Category::latest()->paginate(5);

        $parentCategories = Category::whereNull('parent_id')->get();

        return view('livewire.admin.category-manager',compact('categories','parentCategories'));
    }
}
