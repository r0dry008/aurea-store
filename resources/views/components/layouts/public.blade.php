@php
    $links = [
        [
            'name'=> 'Home',
            'icon'=> 'layout-grid',
            'url'=> route('home'),
            'current'=> request()->routeIs('home')
        ],
        // [
        //     'name'=> 'Servicios',
        //     'icon'=> 'layout-grid',
        //     'url'=> route('reverb.servicios.index'),
        //     'current'=> request()->routeIs('reverb.servicios.*')
        // ],
        // [
        //     'name'=> 'Precios',
        //     'icon'=> 'layout-grid',
        //     'url'=> route('reverb.precios.index'),
        //     'current'=> request()->routeIs('reverb.precios.*')
        // ],
        // [
        //     'name'=> 'Contacto',
        //     'icon'=> 'phone',
        //     'url'=> route('reverb.contacto.index'),
        //     'current'=> request()->routeIs('reverb.contacto.*')
        // ],
        [
            'name'=> 'Tienda',
            'icon'=> 'shopping-bag',
            'url'=> route('reverb.catalog'),
            'current'=> request()->routeIs('reverb.catalog')
        ],
        [
            'name'=> 'Carrito',
            'icon'=> 'shopping-cart',
            'url'=> route('reverb.cart'),
            'current'=> request()->routeIs('reverb.cart')
        ]
    ]    
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>

            <div class="flex items-center gap-1">
                <flux:navbar class="-mb-px max-lg:hidden">
                    @foreach ($links as $link)
                    <flux:navbar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>
                        {{ $link['name'] }}
                    </flux:navbar.item>
                    @endforeach
                </flux:navbar>
                <livewire:public.counter-component />
            </div>

            <flux:spacer />
            <livewire:public.header-search-component />
            <flux:spacer />

            <!-- Desktop User Menu -->
            @auth
                
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
                
            @else
            <flux:dropdown position="top" align="end">
                <flux:button
                    class="cursor-pointer"
                    icon="user"
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('login')" icon="cog" wire:navigate>{{ __('Login') }}</flux:menu.item>          
                        <flux:menu.item :href="route('register')" icon="cog" wire:navigate>{{ __('Register') }}</flux:menu.item>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
                
            @endauth

        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    @foreach ($links as $link)
                        
                    <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>
                      {{ $link['name'] }}
                    </flux:navlist.item>
                    @endforeach

                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

    <main class="
        mt-[100px]   /* margin-top: 100px; */
        {{-- mb-[10px]     /* margin-bottom: 0px; */ --}}
        px-6         /* padding horizontal base (similar a 24px/25px) */
        md:px-5     /* Escala en pantallas medianas */
        lg:px-10     /* Escala en pantallas grandes (simulando 12vw) */
        xl:px-20     /* Escala mayor */
        2xl:px-[105px] /* Máximo padding en pantallas muy grandes */
        min-h-screen
    ">
        {{ $slot }}
    </main>

        @fluxScripts
    {{-- cdn de swiperjs --}}
    </body>
<footer class="footer bg-gray-100 border-t border-gray-300 font-sans">
    <!-- Contenedor principal con padding vertical y horizontal adaptable -->
    <div class="footer_contenido max-w-6xl mx-auto py-16 px-4 md:px-8 lg:px-12 text-gray-800">

        <!-- Filas y Columnas: footer_row -->
        <!-- Responsive Grid: Múltiples columnas automáticas (minmax(180px)), gap-8 (var(--space-md)) -->
        <div class="footer_row grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 items-start text-left md:text-left">

            <!-- Columna 1: Logo -->
            <div class="footer_col footer_logo sm:col-span-2 md:col-span-1 lg:col-span-2 lg:text-left text-center">
                <!-- img | width: 150px; filter: brightness(0.9); transition: filter 0.3s ease; -->
                <a href="#">
                    <!-- Se utiliza group-hover para aplicar efectos de transición y filtro al pasar el ratón por el enlace -->
                    <img src="{{ asset('logos/GlifooComunicacion.png') }}" 
                         class="w-36 h-auto mx-auto lg:mx-0 filter brightness-[0.9] transition duration-300 hover:brightness-100" 
                         alt="Logo de reverb">
                </a>
                <p class="mt-4 text-sm text-gray-600">Transformamos ideas en realidades digitales.</p>
            </div>
            
            <!-- Columna 2: Servicios -->
            <div class="footer_col text-center sm:text-left">
                <!-- h4 | font-size: var(--font-md); color: #0d6efd; margin-bottom: var(--space-sm); -->
                <h4 class="text-lg font-semibold text-blue-600 uppercase tracking-wider mb-3">Servicios</h4>
                <ul class="list-none p-0">
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Sistemas Informáticos</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Diseño Gráfico</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Fotografía</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Dirección y Estilo</a></li>
                </ul>
            </div>

            <!-- Columna 3: Empresa -->
            <div class="footer_col text-center sm:text-left">
                <h4 class="text-lg font-semibold text-blue-600 uppercase tracking-wider mb-3">Empresa</h4>
                <ul class="list-none p-0">
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Acerca de Nosotros</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Contacto</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Política de Privacidad</a></li>
                    <li class="mb-2"><a href="#" class="text-gray-600 text-sm hover:text-blue-600 transition duration-300">Términos y Condiciones</a></li>
                </ul>
            </div>
            
            <!-- Columna 4: Contacto -->
            <div class="footer_col text-center sm:text-left">
                <h4 class="text-lg font-semibold text-blue-600 uppercase tracking-wider mb-3">Contáctanos</h4>
                <ul class="list-none p-0">
                    <li class="mb-2 text-sm text-gray-600">info@glifoo.com</li>
                    <li class="mb-2 text-sm text-gray-600">+591 123-45678</li>
                    <li class="mb-2 text-sm text-gray-600">La Paz, Bolivia</li>
                </ul>
            </div>

        </div>

        <!-- Copyright y Redes Sociales -->
        <!-- footer_copyright | flex, justify-content: space-between, align-items: center, flex-wrap: wrap, gap: var(--space-sm); -->
        <!-- Responsive: flex-direction: column; en móvil (max-width: 768px) -->
        <div class="footer_copyright mt-8 pt-4 border-t border-gray-400 flex justify-between items-center gap-4 flex-wrap flex-col sm:flex-row">
            
            <!-- Texto de Copyright -->
            <p class="text-sm text-gray-600 order-last sm:order-first">
                &copy; {{ date('Y') }} Glifoo. Todos los derechos reservados.
            </p>
            
            <!-- Redes Sociales -->
            <div class="footer_redes_sociales flex space-x-3">
                <!-- a | margin-right: 10px; transition: transform 0.3s ease, filter 0.3s ease; -->
                <!-- img | width: 28px; filter: grayscale(100%); -->
                
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Facebook (ejemplo con SVG/Emoji para ser self-contained) -->
                    <span class="text-2xl" role="img" aria-label="Facebook"><img src="{{ asset('social/facebook.svg') }}" alt="Facebook"></span>
                </a>
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Instagram -->
                    <span class="text-2xl" role="img" aria-label="Instagram"><img src="{{ asset('social/linkedin.svg') }}" alt="Instagram"></span>
                </a>
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Instagram -->
                    <span class="text-2xl" role="img" aria-label="Instagram"><img src="{{ asset('social/instagram.svg') }}" alt="Instagram"></span>
                </a>                
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Instagram -->
                    <span class="text-2xl" role="img" aria-label="Instagram"><img src="{{ asset('social/tiktok.svg') }}" alt="tiktok"></span>
                </a>                
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Instagram -->
                    <span class="text-2xl" role="img" aria-label="Instagram"><img src="{{ asset('social/youtube.svg') }}" alt="youtube"></span>
                </a>                
                <a href="#" class="transition duration-300 transform hover:scale-110">
                    <!-- Icono de Instagram -->
                    <span class="text-2xl" role="img" aria-label="Instagram"><img src="{{ asset('social/x.svg') }}" alt="X"></span>
                </a>
            </div>

        </div>
    </div>
</footer>
</html>
