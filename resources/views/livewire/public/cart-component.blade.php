<div>
    <div>
    @if($cartItems)
    
    <h3 class="text-3xl font-bold mb-8 mt-4 text-gray-900">Carrito de compras</h3>
    
    <!-- Contenido Principal del Carrito -->
    <div class="carrito-content mt-8 md:mt-16">
        
        @foreach ($cartItems as $itemId => $item)
        <!-- Lista de Productos (Ul es innecesario, se puede usar un div) -->
        <div class="lista_productos">
            
            <!-- Producto Item -->
            <div class="producto-item flex items-center gap-12 py-6 border-b border-gray-200">
                
                <!-- Imagen -->
                <div class="producto-item__img flex-shrink-0 w-40 h-40 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ asset('images/kaneki.jpg') }}" alt="" 
                         class="w-full h-full object-cover">
                </div>
                
                <!-- Detalles del Producto -->
                <div class="producto-detalles flex-grow space-y-1">
                    <h4 class="text-2xl font-semibold text-gray-800">{{ $item['nombre'] }}</h4>
                    <p class="text-xl font-medium text-gray-600">Bs. {{ $item['precio'] }}</p>
                    <p class="text-lg text-gray-500">{{ $item['descripcion'] }}</p>
                    
                    <!-- Control de Cantidad y Eliminar -->
                    <div class="modal-cantidad flex items-center space-x-8 mt-3">
                        
                        <!-- Etiqueta de Cantidad (Oculta en Mobile, se muestra por defecto) -->
                        <label for="cantidad" class="cantidad text-lg font-medium text-gray-700 hidden md:block">Cantidad:</label>
                        
                        <!-- Botones de Cantidad Agrupados -->
                        <div class="modal-cantidad_buttons flex items-center border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                            <button wire:click="decrement({{ $itemId }})" 
                                    class="cursor-pointer h-10 w-10 text-lg font-medium bg-gray-50 text-gray-700 hover:bg-gray-200 transition duration-150 border-r border-gray-300">
                                -
                            </button>
                            <span class="min-w-[40px] text-center px-4 py-1 text-base font-semibold text-gray-900 bg-white">
                                {{ $item['cantidad']}}
                            </span>
                            <button wire:click="increment({{ $itemId }})" 
                                    class="cursor-pointer h-10 w-10 text-lg font-medium bg-gray-50 text-gray-700 hover:bg-gray-200 transition duration-150 border-l border-gray-300">
                                +
                            </button>
                        </div>
                        
                        <!-- Icono de Eliminar (Papelera) -->
                        <svg wire:click="removeFromCart({{ $itemId }})" xmlns="http://www.w3.org/2000/svg" 
                             class="h-7 w-7 text-red-500 cursor-pointer hover:text-red-700 transition duration-150 flex-shrink-0" 
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Total y Botón de Confirmar -->
        {{-- <div class="total-pedido flex justify-between items-center mt-8 pt-4 border-t border-gray-300"> --}}
        <div class="total-pedido flex justify-between items-center mt-8 pt-4">
            <p class="text-2xl font-bold text-gray-800">Total: Bs. {{ $this->total()}}</p>
            <div x-data="{modalIsOpen: false}">
                <button x-on:click="modalIsOpen = true" type="button" class="cursor-pointer whitespace-nowrap rounded-radius border border-primary dark:border-primary-dark bg-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">Confirmar pedido</button>
                <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                    <!-- Modal Dialog -->     
                    <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 -translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">             
                        <!-- Dialog Header -->
                        <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                            <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">Confirmar pedido</h3>
                            <button x-on:click="modalIsOpen = false" aria-label="close modal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Dialog Body -->
                        <form action="" wire:submit.prevent="saveOrder" method="POST">

                        <div class="px-4"> 
                            <div class="modal-label relative my-6">
                                <div class="modal-label relative my-3">
                                    <input wire:model.live="name_client" required type="text" id="name_client" name="name_client" 
                                           class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-primary-reverb valid:border-primary-reverb">
                                    <label for="name_client" 
                                           class="absolute top-3 left-3 text-sm text-gray-500 bg-gray-50 px-1 transition-all duration-200 pointer-events-none 
                                                 peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-primary-reverb 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-primary-reverb">
                            Nombre:
                        </label>
                        @error('name_client')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Teléfono -->
                    <div class="modal-label relative my-3">
                        <input wire:model.live="phone_client" required type="text" id="phone_client" name="phone_client" 
                               class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-primary-reverb valid:border-primary-reverb">
                        <label for="phone_client" 
                               class="absolute top-3 left-3 text-sm text-gray-500 bg-gray-50 px-1 transition-all duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-primary-reverb 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-primary-reverb">
                            Telefono:
                        </label>
                        @error('phone_client')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Email -->
                    <div class="modal-label relative my-3">
                        <input wire:model.live="email" required type="email" id="email_cliente" name="email_cliente" 
                               class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 focus:border-primary-reverb valid:border-primary-reverb">
                        <label for="email_cliente" 
                               class="absolute top-3 left-3 text-sm text-gray-500 bg-gray-50 px-1 transition-all duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-primary-reverb 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-primary-reverb">
                            Email:
                        </label>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Mensaje (Textarea) -->
                    <div class="modal-label textarea-label relative my-3">
                        <textarea wire:model.live="message" required name="" id="message" rows="4" 
                                  class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 resize-none focus:border-primary-reverb valid:border-primary-reverb"></textarea>
                        <label for="message" 
                               class="absolute top-3 left-3 text-sm text-gray-500 bg-gray-50 px-1 transition-all duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-primary-reverb 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-primary-reverb
                                     ">
                            Mensaje:
                        </label>
                        @error('message')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Vía (Select) -->
                    <div class="modal-label relative my-3">
                        <select wire:model.live="via" required name="via" id="via"
                                class="peer w-full text-sm outline-none p-3 border border-gray-300 rounded-md bg-transparent transition duration-200 appearance-none focus:border-primary-reverb valid:border-primary-reverb">
                            <option value="" disabled>Seleccione una Vía</option>
                            @foreach ($viaOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <label for="via" 
                               class="absolute top-3 left-3 text-sm text-gray-500 bg-gray-50 px-1 transition-all duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-primary-reverb 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-primary-reverb">
                            Seleccione una Via:
                        </label>
                        <!-- Indicador de Desplegable -->
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-md overflow-hidden">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-gray-700 text-left">Producto</th>
                                            <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Precio</th>
                                            <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Cantidad</th>
                                            <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($cartItems as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="table-item-nombre text-xs font-normal text-gray-600 px-3 py-2 text-left">{{ $item['nombre'] }}</td>
                                <td class="text-xs font-light text-gray-600 px-3 py-2 text-center">Bs. {{ $item['precio'] }}</td>
                                <td class="text-xs font-light text-gray-600 px-3 py-2 text-center">{{ $item['cantidad'] }}</td>
                                <td class="text-xs font-light text-gray-600 px-3 py-2 text-center">Bs. {{ $item['precio'] * $item['cantidad'] }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-100 font-medium">
                                <td class="px-3 py-2"></td>
                                <td class="table-total_orden px-3 py-2 text-right font-semibold text-base" colspan="2">Total:</td>
                                <td class="px-3 py-2 text-center text-base font-bold">Bs. {{ $this->total() }}</td>
                            </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <!-- Dialog Footer -->
                        <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                            <button type="submit" class="btn-primary">Confirmar</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- MODAL DE CONFIRMACIÓN DE PEDIDO -->
    {{-- @if($openModal)
    <!-- Fondo del Modal -->
    <div class="fondo-modal fixed inset-0 w-full h-full bg-black/50 flex items-center justify-center z-[1000] p-4">
        
        <!-- Contenido del Modal -->
        <div class="modal-content modal-content--carrito bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg" wire:click.away="$set('openModal', false)">
            
            <h3 class="text-2xl font-bold mb-6 text-gray-900">Confirmar pedido</h3>
            
            <form wire:submit.prevent="saveOrder" method="POST">
                
                <!-- Cuerpo del Modal (Scrollable) -->
                <div class="modal-body max-h-[600px] overflow-y-auto pr-2">

                    <!-- Campo: Nombre -->
                    <div class="modal-label relative my-6">
                        <input type="text" wire:model.live="name_client" required id="nombre_cliente" name="nombre_cliente" 
                               class="peer w-full text-base outline-none p-3 border-2 border-gray-300 rounded-lg bg-transparent transition duration-200 focus:border-blue-600 valid:border-blue-600">
                        <label for="nombre_cliente" 
                               class="absolute top-3 left-3 text-base text-gray-500 bg-white px-1 transition duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-blue-600 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-blue-600">
                            Nombre:
                        </label>
                    </div>

                    <!-- Campo: Teléfono -->
                    <div class="modal-label relative my-6">
                        <input required type="text" wire:model.live="phone_client" id="telefono_cliente" name="telefono_cliente" 
                               class="peer w-full text-base outline-none p-3 border-2 border-gray-300 rounded-lg bg-transparent transition duration-200 focus:border-blue-600 valid:border-blue-600">
                        <label for="telefono_cliente" 
                               class="absolute top-3 left-3 text-base text-gray-500 bg-white px-1 transition duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-blue-600 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-blue-600">
                            Telefono:
                        </label>
                    </div>

                    <!-- Campo: Email -->
                    <div class="modal-label relative my-6">
                        <input required type="email" wire:model.live="email" id="email_cliente" name="email_cliente" 
                               class="peer w-full text-base outline-none p-3 border-2 border-gray-300 rounded-lg bg-transparent transition duration-200 focus:border-blue-600 valid:border-blue-600">
                        <label for="email_cliente" 
                               class="absolute top-3 left-3 text-base text-gray-500 bg-white px-1 transition duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-blue-600 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-blue-600">
                            Email:
                        </label>
                    </div>

                    <!-- Campo: Mensaje (Textarea) -->
                    <div class="modal-label textarea-label relative my-6">
                        <textarea wire:model.live="message" name="" id="mensaje" rows="4" 
                                  class="peer w-full text-base outline-none p-3 border-2 border-gray-300 rounded-lg bg-transparent transition duration-200 resize-none focus:border-blue-600 valid:border-blue-600"></textarea>
                        <label for="mensaje" 
                               class="absolute top-3 left-3 text-base text-gray-500 bg-white px-1 transition duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-blue-600 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-blue-600">
                            Mensaje:
                        </label>
                    </div>

                    <!-- Campo: Vía (Select) -->
                    <div class="modal-label relative my-6">
                        <select wire:model.live="via" required name="via" id="via"
                                class="peer w-full text-base outline-none p-3 border-2 border-gray-300 rounded-lg bg-transparent transition duration-200 appearance-none focus:border-blue-600 valid:border-blue-600">
                            <option value="" disabled>Seleccione una Vía</option>

                        </select>
                        <label for="via" 
                               class="absolute top-3 left-3 text-base text-gray-500 bg-white px-1 transition duration-200 pointer-events-none 
                                     peer-focus:-top-3 peer-focus:left-2 peer-focus:text-sm peer-focus:text-blue-600 
                                     peer-valid:-top-3 peer-valid:left-2 peer-valid:text-sm peer-valid:text-blue-600">
                            Via:
                        </label>
                        <!-- Indicador de Desplegable -->
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </div>

                    <!-- Detalles del Pedido (Tabla) -->
                    <div class="modal-label mt-8 mb-4">
                        <h4 class="text-xl font-semibold text-gray-800">Detalles del pedido:</h4>
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-left">Producto</th>
                                <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Precio</th>
                                <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Cantidad</th>
                                <th class="px-3 py-3 text-xs font-semibold tracking-wider text-gray-700 text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                            </tr>
                            <tr class="bg-gray-100 font-medium">
                                <td class="px-3 py-2"></td>
                                <td class="table-total_orden px-3 py-2 text-right font-semibold text-base" colspan="2">Total:</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Botón de Confirmar Pedido -->
                <div class="modal-confirmar_pedido flex justify-end pt-4 mt-6 border-t border-gray-300">
                    <button type="submit" 
                            class="btn-primary bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-md 
                                   hover:bg-blue-700 transition duration-150">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif --}}
    
    <!-- Carrito Vacío -->
    @else
    <div class="carrito-void flex flex-col items-center justify-center py-20 text-center">
        <h3 class="text-3xl font-semibold text-gray-700 my-6">No hay productos en tu carrito</h3>
        <img src="{{ asset('images/cart_void.png') }}" alt="Carrito Vacío" class="w-full max-w-sm mb-8">
        <a href="{{ route('reverb.catalog') }}" 
           class="btn-tertiary px-6 py-3 text-lg font-medium rounded-lg cursor-pointer 
                  border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition duration-200">
            Ver catalogo
        </a>
    </div>
    @endif
</div>
{{-- @dump($cartItems) --}}
</div>

</div>
