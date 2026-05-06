<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($products as $product)
        <article class="group flex rounded-radius max-w-sm flex-col overflow-hidden border border-outline text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
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
        @dump($cartItems)

</div>
