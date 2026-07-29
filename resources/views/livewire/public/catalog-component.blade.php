<div>

<div class="max-w-[1400px] mx-auto px-8 py-6">
        
<nav class="flex items-center flex-wrap gap-2 py-4 text-sm text-gray-500 font-medium">
    @foreach($breadcrumbs as $crumb)
        @if(!$loop->first)
            <span class="text-gray-300 select-none text-base">&rsaquo;</span>
        @endif

        @if($loop->last)
            <span class="text-gray-900 font-bold capitalize">
                {{ $crumb['label'] }}
            </span>
        @else
            <button type="button" 
                    wire:click="selectCategory({{ $crumb['id'] ?? 'null' }})" 
                    class="hover:text-black transition duration-150 capitalize cursor-pointer focus:outline-hidden">
                {{ $crumb['label'] }}
            </button>
        @endif
    @endforeach
</nav>
        <div class="flex flex-col lg:flex-row gap-8">
            
            <aside class="w-full lg:w-64 shrink-0 space-y-8">
                <div>
                    <div class="flex justify-between items-center mb-4 cursor-pointer">
                        <h2 class="font-bold text-lg tracking-wide">Categories</h2>
                        <i class="fa-solid fa-chevron-up text-sm"></i>
                    </div>
                    <ul class="space-y-2 text-sm font-medium">
                        <li>
                        {{-- start dropdown --}}
                        <div class="flex flex-col space-y-2 w-full" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                        
                        @foreach ($navCategories as $parentCategory)
                            <div x-data="{ isOpen: false, openedWithKeyboard: false }" class="w-full m-0">
                                
                                <button type="button" 
                                    x-on:click="isOpen = ! isOpen" 
                                    x-on:keydown.space.prevent="openedWithKeyboard = true" 
                                    x-on:keydown.enter.prevent="openedWithKeyboard = true" 
                                    x-on:keydown.down.prevent="openedWithKeyboard = true" 
                                    x-bind:class="isOpen || openedWithKeyboard ? 'text-on-surface-strong dark:text-on-surface-dark-strong' : 'text-on-surface dark:text-on-surface-dark'" 
                                    x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                    class="flex w-full items-center justify-between gap-2 whitespace-nowrap rounded-radius border border-outline bg-[#FDF5E6] px-4 py-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:focus-visible:outline-outline-dark-strong" 
                                    aria-haspopup="true">
                                    
                                    {{ $parentCategory->name }}
                                    
                                    <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                                        class="size-4 transition-transform duration-200" :class="isOpen || openedWithKeyboard ? 'rotate-180' : 'rotate-0'">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                    </svg>        
                                </button>

                                <div x-cloak 
                                    x-show="isOpen || openedWithKeyboard" 
                                    
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                    
                                    x-trap="openedWithKeyboard" 
                                    x-on:click.outside="isOpen = false, openedWithKeyboard = false" 
                                    x-on:keydown.down.prevent="$focus.wrap().next()" 
                                    x-on:keydown.up.prevent="$focus.wrap().previous()" 
                                    class="relative mt-1 flex w-full flex-col overflow-hidden rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt shadow-sm z-10" 
                                    role="menu">
                                    
                                    <button wire:click="selectCategory({{ $parentCategory->id }})" x-on:click="isOpen = false" class="text-left bg-surface-alt px-4 py-2 text-xs font-bold text-blue-600 hover:bg-surface-dark-alt/5 cursor-pointer">
                                        Ver todo
                                    </button>
                                    <hr class="border-outline/30 dark:border-outline-dark/30">

                                    @foreach ($parentCategory->children as $childCategory)
                                        <a href="#" 
                                            wire:click.prevent="selectCategory({{ $childCategory->id }})"
                                            x-on:click="isOpen = false, openedWithKeyboard = false"
                                            class="bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" 
                                            role="menuitem">
                                            {{ $childCategory->name }}
                                        </a>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach

                    </div>
                        {{-- end dropdown --}}
                            <ul class="pl-6 mt-2 space-y-2 text-gray-600 text-xs">
                                <li class="text-black font-semibold"><i class="fa-solid fa-chevron-right text-[10px] mr-1 text-gray-400"></i> T-Shirts</li>
                                <li class="hover:text-black cursor-pointer"><i class="fa-solid fa-chevron-right text-[10px] mr-1 text-gray-400"></i> Pants</li>
                                <li class="hover:text-black cursor-pointer"><i class="fa-solid fa-chevron-right text-[10px] mr-1 text-gray-400"></i> Shoes</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <hr class="border-gray-200/60">

                <div class="space-y-6">
                    <div class="flex justify-between items-center cursor-pointer">
                        <h2 class="font-bold text-lg tracking-wide">Filters</h2>
                        <i class="fa-solid fa-chevron-up text-sm"></i>
                    </div>

                    <div>
                        <span class="block text-sm font-semibold mb-3">Color</span>
                        <div class="flex items-center space-x-3">
                            <button class="w-6 h-6 rounded-full bg-black ring-1 ring-offset-2 ring-gray-400"></button>
                            <button class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-white text-xs ring-1 ring-offset-2 ring-blue-500">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <button class="w-6 h-6 rounded-full bg-red-600"></button>
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-semibold mb-3">Size</span>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1.5 bg-blue-600 text-white font-semibold rounded-md text-xs tracking-wide">M</button>
                            <button class="px-3 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-md text-xs hover:border-black transition">L</button>
                            <button class="px-3 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-md text-xs hover:border-black transition">XL</button>
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-semibold mb-2">Price Range</span>
                        <div class="relative pt-1">
                            <div class="h-1 bg-gray-200 rounded-full">
                                <div class="absolute h-1 bg-blue-600 rounded-full left-[10%] right-[30%]"></div>
                            </div>
                            <div class="absolute top-0 left-[10%] w-3 h-3 bg-blue-600 rounded-full -mt-1 cursor-pointer"></div>
                            <div class="absolute top-0 right-[30%] w-3 h-3 bg-blue-600 rounded-full -mt-1 cursor-pointer"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-gray-500 mt-4 font-medium">
                            <span>From - $29.90</span>
                            <span>to - $700</span>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200/60">

                <div class="flex justify-between items-center cursor-pointer">
                    <span class="text-sm font-bold tracking-wide">Brand</span>
                    <i class="fa-solid fa-chevron-down text-sm"></i>
                </div>
            </aside>



            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 2xl:grid-cols-4 gap-6">
                    {{-- card product --}}
                   @foreach ($products as $product)

                        {{-- {{$this->sumaStockSkus($product->id)}} --}}
                    <div class="bg-[#FFFDF6] border border-gray-100 rounded-xl p-4 flex flex-col justify-between group transition">
                        @if($this->sumaStockSkus($product->id))
                        <div class="relative bg-[#FDFBF2] rounded-lg aspect-square flex items-center justify-center">
                            <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition"><i class="fa-regular fa-heart text-lg"></i></button>
                            <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=500&auto=format&fit=crop" alt="Black T-Shirt" class="object-cover transition duration-700 ease-out group-hover:scale-105 cursor-pointer">
                        </div>
                        @else
                        <div class="relative bg-[#FDFBF2] rounded-lg aspect-square flex items-center justify-center">
                            <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition"><i class="fa-regular fa-heart text-lg"></i></button>
                            <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=500&auto=format&fit=crop" alt="Black T-Shirt" class="object-cover transition duration-700 ease-out group-hover:scale-105 cursor-pointer">
                            <h2 class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Agotado</h2>
                        </div>

                        @endif
                        <div>
                            <a href="{{ route('reverb.product.show', $product->slug) }}" wire:navigate>
                                <h3 class="font-bold text-3xl text-black mb-1">{{ $product->name }}</h3>
                            </a>
                            <div class="flex space-x-1 mb-2">
                                <span class="bg-gray-100 px-1.5 py-0.5 text-[10px] rounded text-gray-600">Black</span>
                                <span class="bg-blue-100 px-1.5 py-0.5 text-[10px] rounded text-blue-600 font-bold">M</span>
                                <span class="bg-gray-100 px-1.5 py-0.5 text-[10px] rounded text-gray-600">M</span>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="font-bold text-sm text-black">   
                                    @if($product->skus->isNotEmpty())
                                        Bs.{{number_format($product->skus->first()->price, 2) }}
                                    @else
                                        Precio no disponible
                                    @endif
                                </span>
                                {{-- <button wire:click="addToCart({{ $product->id }},{{ $cantidad }})" class="cursor-pointer bg-black hover:bg-gray-800 text-white text-xs font-semibold px-4 py-2 rounded-md tracking-wide transition">Add to Cart</button> --}}



                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- end card product --}}
                </div>
                <div class="flex justify-center items-center space-x-2 mt-12 text-sm font-semibold">
                    <button class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-md shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 hover:bg-gray-100 rounded-md transition">2</button>
                    <button class="w-8 h-8 flex items-center justify-center bg-white text-gray-600 hover:bg-gray-100 rounded-md transition">3</button>
                    <button class="px-3 h-8 flex items-center justify-center bg-white text-gray-600 hover:bg-gray-100 rounded-md transition space-x-1">
                        <span>Next</span> <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- //////////////////////////// --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($products as $product)
        <article class="group flex rounded-radius max-w-sm flex-col overflow-hidden border border-outline text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <div class="h-44 md:h-64 overflow-hidden"> 
                <img src="https://penguinui.s3.amazonaws.com/component-assets/card-img-2.webp" class="object-cover transition duration-700 ease-out group-hover:scale-105" alt="view of a coastal Mediterranean village on a hillside, with small boats in the water." />
            </div>
            <div class="flex flex-col gap-4 p-6">

                <h3 class="text-balance text-xl lg:text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong" aria-describedby="tripDescription">{{ $product->name }}</h3>
                <div class="flex text-2xl items-center justify-center gap-1 font-medium">
                    <span class="">
                        @if($product->skus->isNotEmpty())
                            Bs.{{number_format($product->skus->first()->price, 2) }}
                        @else
                            Precio no disponible
                        @endif
                    </span>
                </div>
                <p id="tripDescription" class="text-pretty text-sm mb-2">
                    {{ $product->description }}
                </p>
<div class="" x-data="{modalIsOpen: false}">
    <button x-on:click="modalIsOpen = true" type="button" class="btn-primary">Detalles</button>
    <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex w-full items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
        <!-- Modal Dialog -->
        <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <!-- Dialog Header -->
            <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                {{-- <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">Special Offer</h3> --}}
                <button x-on:click="modalIsOpen = false" aria-label="close modal" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <!-- Dialog Body -->

            <div class="h-44 md:h-64 overflow-hidden"> 
                <img src="https://penguinui.s3.amazonaws.com/component-assets/card-img-2.webp" class="object-cover transition duration-700 ease-out group-hover:scale-105" alt="view of a coastal Mediterranean village on a hillside, with small boats in the water." />
            </div>
            <div class="flex flex-col gap-4 p-6">

                <h3 class="text-balance text-xl lg:text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong" aria-describedby="tripDescription">{{ $product->name }}</h3>
                <div class="flex text-2xl items-center justify-center gap-1 font-medium">
                    <span class="">Bs. {{ $product->price }}</span>
                </div>
                <p id="tripDescription" class="text-pretty text-sm mb-2">
                    {{ $product->description }}
                </p>
            </div>
            <!-- Dialog Footer -->
            <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                <div class="modal-cantidad flex items-center gap-5 my-4">
<!-- Control de Cantidad: modal-cantidad -->
<div class="flex items-center gap-5 my-6"> <!-- gap-5 para 20px, my-6 para margin vertical -->
    <!-- Etiqueta -->
    <label for="cantidad" class="text-lg font-semibold text-gray-700">Cantidad:</label>
    <!-- Contenedor del Control (Para el diseño agrupado) -->
    <div class="flex items-center space-x-0 border border-gray-300 rounded-xl overflow-hidden shadow-sm">
        <!-- Botón Decremento -->
        <!-- Estilo mejorado: H-12 W-12 para 48x48px (cercano a 50px), hover, focus, border-r -->
        <button 
            type="button" 
            wire:click="decrement" 
            class="cursor-pointer h-12 w-12 text-xl font-medium bg-gray-50 text-gray-700 
                   hover:bg-gray-200 transition duration-150 border-r border-gray-300 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            -
        </button>
        <!-- Display de Cantidad (Span) -->
        <!-- Estilo mejorado: Padding ajustado y texto centrado, sin bordes internos gracias al contenedor padre -->
        <span 
            wire:model="cantidad" 
            class="min-w-[50px] text-center px-4 py-2 text-lg font-bold text-gray-900 bg-white">
        {{ $cantidad }}
        </span>
        <!-- Botón Incremento -->
        <!-- Estilo mejorado: H-12 W-12, hover, focus, border-l -->
        <button 
            type="button" 
            wire:click="increment" 
            class="cursor-pointer h-12 w-12 text-xl font-medium bg-gray-50 text-gray-700 
                   hover:bg-gray-200 transition duration-150 border-l border-gray-300 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        +
        </button>
    </div>
</div>
                <button type="button" wire:click="addToCart({{ $product->id }},{{ $cantidad }})" x-on:click="modalIsOpen = false" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark cursor-pointer">Agregar al carrito</button>
            </div>
        </div>
    </div>
</div>
    </div>
            </div>
        </article>
    @endforeach
</div>



