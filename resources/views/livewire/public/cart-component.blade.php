<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Tu Carrito de Compras</h2>

        <div class="divide-y divide-gray-100 bg-white px-4 rounded-xl shadow-xs">
            @forelse ($cartItems as $itemId => $item)
                <div class="flex items-center gap-4 sm:gap-6 py-5 transition duration-150 hover:bg-gray-50/50 rounded-lg px-2">
                    <div class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden bg-gray-50 border border-gray-150">
                        <img src="{{ asset('images/kaneki.jpg') }}" alt="{{ $item['nombre'] }}" class="w-full h-full object-cover">
                    </div>
                    {{-- {{dd($cartItems)}} --}}
                    <div class="flex-grow flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <h4 class="text-base sm:text-lg font-bold text-gray-900 leading-snug">{{ $item['nombre'] }}</h4>
                            @if(!empty($item['detalles_variantes']))
                                <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs text-gray-400 font-medium">
                                    @foreach($item['detalles_variantes'] as $propiedad => $valor)
                                        <span>{{ $propiedad }}: <strong class="text-gray-600 font-semibold">{{ $valor }}</strong></span>
                                    @endforeach
                                </div>
                            @endif
                            <p class="text-sm sm:text-base font-semibold text-gray-800 pt-0.5">Bs. {{ number_format($item['precio'], 2) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between sm:justify-end gap-6 sm:gap-8 mt-1 sm:mt-0">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center border border-gray-200 bg-white rounded-lg overflow-hidden shadow-xs h-9">
                                    <button wire:click="decrement({{ $itemId }})" type="button" class="w-9 h-full flex items-center justify-center text-sm font-bold bg-gray-50 text-gray-500 hover:bg-gray-100 transition border-r border-gray-200 cursor-pointer">&minus;</button>
                                    <span class="min-w-[36px] text-center text-sm font-bold text-gray-800 px-2 select-none">{{ $item['cantidad'] }}</span>
                                    <button wire:click="increment({{ $itemId }})" type="button" class="w-9 h-full flex items-center justify-center text-sm font-bold bg-gray-50 text-gray-500 hover:bg-gray-100 transition border-l border-gray-200 cursor-pointer">&plus;</button>
                                </div>
                            </div>
                            
                            <button wire:click="removeFromCart({{ $itemId }})" type="button" class="p-1.5 rounded-md text-red-400 hover:text-red-600 hover:bg-red-50 transition cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center space-y-3">
                    <p class="text-gray-500 font-medium text-sm">Tu carrito de compras está vacío.</p>
                </div>
            @endforelse
        </div>

        @if(count($cartItems) > 0)
            <div class="total-pedido flex justify-between items-center mt-8 pt-6">
                <p class="text-2xl font-bold text-gray-800">Total: Bs. {{ number_format($this->total(), 2) }}</p>
                
                    <a href="{{ route('reverb.checkout') }}" class="cursor-pointer whitespace-nowrap rounded-md bg-black text-white px-6 py-3 text-center text-sm font-semibold tracking-wide hover:bg-gray-800 transition shadow-sm">
                        Confirmar pedido
                    </a>

            </div>
        @endif
        
    </div>
</div>