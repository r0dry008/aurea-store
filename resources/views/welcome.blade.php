<x-layouts.public>
<div class="">
    @php
    $slides = [
        [
            'title' => 'Colección Primavera 2026',
            'subtitle' => 'Hasta 40% OFF en ropa urbana seleccionada.',
            'image' => asset('images/banner_1.webp'),
            'button_text' => 'Ver Colección',
            'link' => route('reverb.checkout'), // O la ruta de tu tienda
        ],
        [
            'title' => 'Nuevos Arribos',
            'subtitle' => 'Descubre las últimas tendencias para esta temporada.',
            'image' => asset('images/banner_2.webp'),
            'button_text' => 'Comprar Ahora',
            'link' => route('reverb.checkout'),
        ],        [
            'title' => 'Nuevos Arribos',
            'subtitle' => 'Descubre las últimas tendencias para esta temporada.',
            'image' => asset('images/banner_3.webp'),
            'button_text' => 'Comprar Ahora',
            'link' => route('reverb.checkout'),
        ],
    ];
@endphp

<div x-data="{
        activeSlide: 0,
        slidesCount: {{ count($slides) }},
        timer: null,
        startAutoplay() {
            this.timer = setInterval(() => {
                this.next();
            }, 3000);
        },
        stopAutoplay() {
            clearInterval(this.timer);
        },
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount;
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-full overflow-hidden rounded-2xl bg-gray-900 shadow-xl"
>
    <!-- Slides contenedor -->
    <div class="relative h-[400px] md:h-[600px] w-full">
        @foreach($slides as $index => $slide)
            <div 
                x-show="activeSlide === {{ $index }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute inset-0 w-full h-full"
            >
                <!-- Imagen de Fondo con Overlay Oscuro -->
                <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="w-full h-full object-cover object-top">
                <div class="absolute inset-0 bg-black/40"></div>

                <!-- Contenido de Texto -->
                <div class="absolute inset-0 flex flex-col justify-center items-start px-8 md:px-16 text-white max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-4">
                        {{ $slide['title'] }}
                    </h2>
                    <p class="text-lg md:text-xl text-gray-200 mb-6">
                        {{ $slide['subtitle'] }}
                    </p>
                    <a href="{{ $slide['link'] }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-300">
                        {{ $slide['button_text'] }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Botón Anterior -->
    <button 
        @click="prev()" 
        class="cursor-pointer absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full backdrop-blur-sm transition"
        aria-label="Anterior"
    >
        <svg class=" w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>

    <!-- Botón Siguiente -->
    <button 
        @click="next()" 
        class="cursor-pointer absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full backdrop-blur-sm transition"
        aria-label="Siguiente"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Indicadores (Dots) -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
        @foreach($slides as $index => $slide)
            <button 
                @click="activeSlide = {{ $index }}" 
                :class="activeSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 w-3'"
                class="cursor-pointer h-3 rounded-full transition-all duration-300"
            ></button>
        @endforeach
    </div>
</div>
</div>
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Encabezado de la Sección -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Explora por Categorías
            </h2>
            <a href="" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                Ver catálogo completo &rarr;
            </a>
        </div>

        <!-- Rejilla de Categorías -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($categories as $category)
                <a href="{{route('reverb.catalog',['cat'=>$category->id])}}" 
                   class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-md transition duration-300">
                    
                    <!-- Imagen de la Categoría -->
                    <div class="aspect-square w-full overflow-hidden bg-gray-100">
                        <img 
                            src="images/categorias.png" 
                            class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-500"
                        >
                    </div>

                    <!-- Nombre de la Categoría -->
                    <div class="p-3 text-center bg-white">
                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                            {{ $category->name }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
</x-layouts.public>