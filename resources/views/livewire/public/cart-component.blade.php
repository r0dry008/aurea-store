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
            <div class="total-pedido flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                <p class="text-2xl font-bold text-gray-800">Total: Bs. {{ number_format($this->total(), 2) }}</p>
                
                    <a href="{{ route('reverb.checkout') }}" class="cursor-pointer whitespace-nowrap rounded-md bg-black text-white px-6 py-3 text-center text-sm font-semibold tracking-wide hover:bg-gray-800 transition shadow-sm">
                        Confirmar pedido
                    </a>
                <div x-data="{ modalIsOpen: false }">
                    <button x-on:click="modalIsOpen = true" type="button" 
                            class="cursor-pointer whitespace-nowrap rounded-md bg-black text-white px-6 py-3 text-center text-sm font-semibold tracking-wide hover:bg-gray-800 transition shadow-sm">
                        Confirmar pedido
                    </button>
                    
                    <div x-cloak x-show="modalIsOpen" 
                         x-transition.opacity.duration.200ms 
                         x-trap.inert.noscroll="modalIsOpen" 
                         x-on:keydown.esc.window="modalIsOpen = false" 
                         x-on:click.self="modalIsOpen = false" 
                         class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8" 
                         role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                        
                        <div x-show="modalIsOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                             class="flex w-full max-w-xl flex-col h-auto max-h-[90vh] overflow-y-auto rounded-xl border border-gray-200 bg-white text-gray-800 shadow-xl">     
                            
                            <div class="flex items-center justify-between border-b border-gray-150 bg-gray-50 p-4">
                                <h3 id="defaultModalTitle" class="font-bold text-lg text-gray-900 tracking-wide">Confirmar pedido</h3>
                                <button x-on:click="modalIsOpen = false" aria-label="close modal" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <form wire:submit.prevent="saveOrder" method="POST" class="flex flex-col flex-grow">
                                <div class="p-6 space-y-4"> 
                                    
                                    <div class="relative">
                                        <input wire:model.live="name_client" required type="text" id="name_client" name="name_client" placeholder=" "
                                               class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-black focus:ring-1 focus:ring-black">
                                        <label for="name_client" 
                                               class="absolute text-sm text-gray-500 bg-white px-1 transition-all duration-200 pointer-events-none left-3 top-3 
                                                      peer-focus:-top-2.5 peer-focus:left-2 peer-focus:text-xs peer-focus:text-black
                                                      peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-2 peer-[:not(:placeholder-shown)]:text-xs">
                                            Nombre Completo:
                                        </label>
                                        @error('name_client') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative">
                                        <input wire:model.live="phone_client" required type="text" id="phone_client" name="phone_client" placeholder=" "
                                               class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-black focus:ring-1 focus:ring-black">
                                        <label for="phone_client" 
                                               class="absolute text-sm text-gray-500 bg-white px-1 transition-all duration-200 pointer-events-none left-3 top-3 
                                                      peer-focus:-top-2.5 peer-focus:left-2 peer-focus:text-xs peer-focus:text-black
                                                      peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-2 peer-[:not(:placeholder-shown)]:text-xs">
                                            Teléfono:
                                        </label>
                                        @error('phone_client') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative">
                                        <input wire:model.live="email" required type="email" id="email_cliente" name="email_cliente" placeholder=" "
                                               class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-black focus:ring-1 focus:ring-black">
                                        <label for="email_cliente" 
                                               class="absolute text-sm text-gray-500 bg-white px-1 transition-all duration-200 pointer-events-none left-3 top-3 
                                                      peer-focus:-top-2.5 peer-focus:left-2 peer-focus:text-xs peer-focus:text-black
                                                      peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-2 peer-[:not(:placeholder-shown)]:text-xs">
                                            Correo Electrónico:
                                        </label>
                                        @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative">
                                        <textarea wire:model.live="message" required id="message" rows="3" placeholder=" "
                                                  class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 resize-none focus:border-black focus:ring-1 focus:ring-black"></textarea>
                                        <label for="message" 
                                               class="absolute text-sm text-gray-500 bg-white px-1 transition-all duration-200 pointer-events-none left-3 top-3 
                                                      peer-focus:-top-2.5 peer-focus:left-2 peer-focus:text-xs peer-focus:text-black
                                                      peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-2 peer-[:not(:placeholder-shown)]:text-xs">
                                            Detalles de Entrega / Dirección:
                                        </label>
                                        @error('message') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative">
                                        <select wire:model.live="via" required id="via"
                                                class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-white transition duration-200 appearance-none focus:border-black focus:ring-1 focus:ring-black">
                                            <option value="" disabled selected>Seleccione una Vía</option>
                                            @foreach ($viaOptions as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <label for="via" class="absolute text-xs text-gray-500 bg-white px-1 -top-2.5 left-2 font-medium">
                                            Método de Envío/Pago:
                                        </label>
                                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                        @error('via') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="overflow-x-auto rounded-lg border border-gray-200 mt-4">
                                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                                            <thead class="bg-gray-50 font-semibold text-gray-700">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Producto</th>
                                                    <th class="px-3 py-2 text-center">Precio</th>
                                                    <th class="px-3 py-2 text-center">Cant.</th>
                                                    <th class="px-3 py-2 text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 text-gray-600 bg-white">
                                                @foreach ($cartItems as $item)
                                                    <tr class="hover:bg-gray-50/50">
                                                        <td class="px-3 py-2 text-left font-medium text-gray-900">
                                                            {{ $item['nombre'] }}
                                                            @if(!empty($item['detalles_variantes']))
                                                                <span class="block text-[10px] text-gray-400 font-normal">
                                                                    ({{ implode(', ', $item['detalles_variantes']) }})
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 text-center">Bs. {{ number_format($item['precio'], 2) }}</td>
                                                        <td class="px-3 py-2 text-center font-semibold">{{ $item['cantidad'] }}</td>
                                                        <td class="px-3 py-2 text-right font-medium text-gray-900">Bs. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr class="bg-gray-50 font-bold text-gray-900 text-sm">
                                                    <td class="px-3 py-2.5 text-right" colspan="3">Total Orden:</td>
                                                    <td class="px-3 py-2.5 text-right text-black">Bs. {{ number_format($this->total(), 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="flex items-center justify-end gap-3 border-t border-gray-150 bg-gray-50 p-4 mt-auto">
                                    <button x-on:click="modalIsOpen = false" type="button" 
                                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition cursor-pointer">
                                        Cancelar
                                    </button>
                                    <button type="submit" 
                                            class="rounded-md bg-black text-white px-5 py-2 text-sm font-semibold hover:bg-gray-800 transition shadow-xs cursor-pointer">
                                        Confirmar Pedido
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        @endif
        
    </div>
</div>