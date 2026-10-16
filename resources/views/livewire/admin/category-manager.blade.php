<div>
    <div class="flex items-center justify-between mb-4">
        <nav class="text-sm font-medium text-on-surface dark:text-on-surface-dark" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1">
            <li class="flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong">{{ __('Dashboard') }}</a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </li>
            <li class="flex items-center text-on-surface-strong gap-1 font-bold dark:text-on-surface-dark-strong" aria-current="page">{{ __('Categorias') }}</li>
        </ol>
        </nav>

        {{-- inicio del modal nueva categoria --}}
        <div x-data="{modalIsOpen: false}">
            <button x-on:click="modalIsOpen = true" wire:click="resetForm" type="button" class="cursor-pointer whitespace-nowrap rounded-radius bg-success border border-success px-4 py-2 text-sm font-medium tracking-wide text-onSuccess transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-onSuccess dark:focus-visible:outline-success">Nueva categoria</button>
            <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:close-create-modal.window="modalIsOpen=false" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb- backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                <!-- Modal Dialog -->     
                <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 -translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="flex max-w-2xl flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">             
                    <!-- Dialog Header -->
                    <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                        <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">Crear nueva categoria</h3>
                        <button x-on:click="modalIsOpen = false" aria-label="close modal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Dialog Body -->
                    <div class="px-4"> 
                        <p class="text-sm text-on-surface-variant dark:text-on-surface-dark-variant">
                            Introduzca el nombre y una descripción concisa para la nueva categoria. Esta información será visible para los usuarios en la página principal del catálogo.
                        </p>
                    </div>
                    <form action="" wire:submit.prevent="save" enctype="multipart/form-data" method="POST">
                    <div class="px-4 py-4 flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                        <label class="flex items-center text-sm dark:text-on-surface-dark cursor-pointer pb-2">
                            <span class="mr-2">Crear otra categoría al guardar</span>
                            <input type="checkbox" wire:model="createAnother" class="cursor-pointer rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </label>
                        <label for="create_name" class="w-fit pl-0.5 text-sm">Nombre</label>
                        <input wire:model.live="name" id="create_name" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="name" placeholder="Ingresa el nombre del servicio"/>
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                        <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                            <label for="os" class="w-fit pl-0.5 text-sm">Categoria principal: si la categoria que esta por crear pertenece es una subcategoia por favor seleccione la categoria a la que pertenece</label>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-13 size-5">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            <select wire:model.live="parent_id" id="parent_id" name="parent_id" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                                <option selected>Sin categoria padre</option>
                                @foreach ($parentCategories as $category)
                                    
                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                @endforeach
                            </select>
                        </div>


                        <label for="create_slug" class="w-fit pl-0.5 text-sm">slug</label>
                        <input wire:model.live="slug" id="create_slug" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="slug" placeholder="Ingresa el nombre del servicio"/>
                        @error('slug')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror

                        <label for="create_description" class="w-fit pl-0.5 text-sm">Descripción</label>
                        <textarea wire:model.live="description" id="create_description"  rows = "3"class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="description" placeholder="Ingresa una descripción concisa del servicio"></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror

                        
                        <img class="max-w-50" src="{{ $image ? $image->temporaryUrl() : '' }}" alt="">
                        <label for="create_image" class="w-fit pl-0.5 text-sm">Imagen</label>
                        <input accept="image/*" wire:model.live="image" id="create_image" type="file" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="image" placeholder="Ingresa la URL de la imagen del servicio"/>
                        @error('image')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Dialog Footer -->
                    <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                        <button x-on:click="modalIsOpen = false" type="button" class="cursor-pointer whitespace-nowrap rounded-radius px-4 py-2 text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark">Cancelar</button>
                        <button type="submit" class="cursor-pointer whitespace-nowrap rounded-radius bg-primary border border-primary dark:border-primary-dark px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">Guardar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    {{-- fin del modal nueva categoria --}}


    <div class="mt-5 overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">Categoria</th>
                    <th scope="col" class="p-4">Slug</th>
                    <th scope="col" class="p-4">Descripción</th>
                    <th scope="col" class="p-4">imagen</th>
                    <th scope="col" class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @foreach($categories as $categoria)
                    <tr>
                        <td class="p-4">{{$categoria->name}}</td>
                        <td class="p-4">{{$categoria->slug}}</td>
                        <td class="p-4">{{$categoria->description}}</td>
                        <td class="p-4"><img src="{{$categoria->image_path? Storage::url($categoria->image_path) : asset('images/no-image.png') }}" alt="" onerror="this.src='{{asset('images/no-image.png')}}';"></td>
                        <td class="p-4">
                {{-- inicio del modal editar --}}
                        <div x-data="{modalEditIsOpen: false}">
                            <button type="button" x-on:click="modalEditIsOpen = true" wire:click='editCategory({{$categoria->id}})' class="cursor-pointer whitespace-nowrap rounded-radius bg-surface-alt border border-surface-alt px-4 py-2 text-sm font-medium tracking-wide text-on-surface-strong transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark-strong dark:focus-visible:outline-surface-dark-alt">Editar</button>
                            <div x-cloak x-show="modalEditIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalEditIsOpen" x-on:keydown.esc.window="modalEditIsOpen = false" x-on:click.self="modalEditIsOpen = false" x-on:close-edit-modal.window="modalEditIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                                <!-- Modal Dialog -->     
                                <div x-show="modalEditIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 -translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="flex max-w-2xl flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">             
                                    <!-- Dialog Header -->
                                    <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                                        <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">Editar categoria</h3>
                                        <button x-on:click="modalEditIsOpen = false" aria-label="close modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5 cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Dialog Body -->
                                    <div class="px-4 py-4"> 
                                    <p class="text-sm text-on-surface-variant dark:text-on-surface-dark-variant">
                                        Introduzca el nombre y una descripción concisa para la nueva categoria. Esta información será visible para los usuarios en la página principal del catálogo.
                                    </p>
                                    </div>
                                    <form action="" wire:submit.prevent="update" enctype="multipart/form-data" method="POST">
                                    <div class="px-4 py-4 flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">

                                        <label for="edit_name" class="w-fit pl-0.5 text-sm">Nombre</label>
                                        <input wire:model.live="name" id="edit_name" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="name" placeholder="Ingresa el nombre del servicio"/>
                                        @error('name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                        
                                        <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                                            <label for="os" class="w-fit pl-0.5 text-sm">Categoria principal: si la categoria que esta por crear pertenece es una subcategoia por favor seleccione la categoria a la que pertenece</label>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-13 size-5">
                                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                            <select wire:model.live="parent_id" id="parent_id" name="parent_id" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                                                <option selected>Please Select</option>
                                                @foreach ($parentCategories as $parent)
                                                    @if ($parent->id != $categoria->id)
                                                        <option value="{{$parent->id}}">{{$parent->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <label for="edit_slug" class="w-fit pl-0.5 text-sm">slug</label>
                                        <input wire:model.live="slug" id="edit_slug" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="slug" placeholder="Ingresa el nombre del servicio"/>
                                        @error('slug')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror

                                        <label for="edit_description" class="w-fit pl-0.5 text-sm">Descripción</label>
                                        <textarea wire:model.live="description" id="edit_description"  rows = "3"class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="description" placeholder="Ingresa una descripción concisa del servicio"></textarea>
                                        @error('description')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror

                                        <label for="edit_imagen" class="w-fit pl-0.5 text-sm">Imagen</label>
                                        <div class="grid grid-cols-2 gap-4">
                                        <input accept="image/*" wire:model.live="image" id="edit_imagen" type="file" class="w-full h-10 rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="image" placeholder="Ingresa la URL de la imagen del servicio"/>
                                        <img class="max-w-50" src="{{$image ? $image->temporaryUrl() : ($currentImageUrl ? Storage::url($currentImageUrl): '') }}" alt="" srcset="">
                                        </div>
                                        @error('image')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Dialog Footer -->
                                    <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                                        <button x-on:click="modalEditIsOpen = false" type="button" class="cursor-pointer whitespace-nowrap rounded-radius px-4 py-2 text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark">Cancelar</button>
                                        <button type="submit" class="cursor-pointer whitespace-nowrap rounded-radius bg-primary border border-primary dark:border-primary-dark px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">Guardar</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        {{-- fin del modal editar --}}

                        <button wire:click="$dispatch('confirm-delete', {id: {{$categoria->id}} })" type="button" class="cursor-pointer whitespace-nowrap rounded-radius bg-danger border border-danger px-4 py-2 text-sm font-medium tracking-wide text-onDanger transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-danger dark:border-danger dark:text-onDanger dark:focus-visible:outline-danger">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 flex justify-end">
        {{$categories->links('livewire.custom-pagination')}}
    </div>
</div>



