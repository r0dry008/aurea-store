<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 mt-0">
        <div class="lg:col-span-7">
            <form wire:submit.prevent="saveOrder"
             method="POST">
                @csrf
                <div class="">
                    <h3 class="text-2xl font-medium text-gray-900">Datos del Cliente</h3>
                    <div class="grid grid-cols-2 gap-x-4">
                        <div class="flex flex-col mb-4">
                            <label for="name" class="pb-2 pt-2">Nombre:</label>
                            <input
                            wire:model.live="name"
                            type="text" name="name" value="asd"
                            class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">

                            @error('name')
                                <span class="text-xs text-red-600 font-semibold mt-1 block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="last_name" class="pb-2 pt-2">Apellido:</label>
                            <input 
                            wire:model.live="last_name"
                            type="text" name="last_name" value="asd" class="rounded border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400" >
                            @error('last_name')
                                <span class="text-xs text-red-600 font-semibold mt-1 block">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2">
                        <label for="email" class="pt-2">Email:</label>
                        <input 
                        wire:model.live="email"
                        type="text" name="email" value="" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('email')
                                <span class="text-xs text-red-600 font-semibold mt-1 block">
                                    {{ $message }}
                                </span>
                            @enderror

                        <label for="phone" class="pt-2">Teléfono:</label>
                        <input 
                        wire:model.live="phone"
                        type="text" name="phone" value="" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('phone')
                                <span class="text-xs text-red-600 font-semibold mt-1 block">
                                    {{ $message }}
                                </span>
                            @enderror

                        <label for="shippping_fee" class="pt-2">Costo de envio:</label>
                        <input 
                        wire:model.live="shipping_fee"
                        type="text" name="shipping_fee" value="" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <label for="descount_amount" class="pt-2">Descuento:</label>

                        <input 
                        wire:model.live="descount_amount"
                        type="text" name="descount_amount" value="" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <h3 class="text-2xl font-medium text-gray-900">Metodo de envio</h3>
                        <label for="shipping_address">Dirección de Envío:</label>
                        <input 
                        wire:model.live="address"
                        type="text" name="shipping_address" value="" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('address')
                                <span class="text-xs text-red-600 font-semibold mt-1 block">
                                    {{ $message }}
                                </span>
                            @enderror

                        <h3>Metodo de Envio</h3>
                        <select name="shipping_method" class="rounded-lg border border-gray-300 p-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="standard">Delivery</option>
                            <option value="express">En tienda</option>
                        </select>
                    </div>
                </div>
            <button class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Realizar Pedido</button>

            </form>
        </div>


        <div class="lg:col-span-5 bg-gray-50 p-6 rounded-xl border border-gray-200 h-fit lg:sticky lg:top-6">
            <h3 class="text-2xl font-medium text-gray-900 pb-3">Resumen del Pedido</h3>
            {{-- {{dd($cartItems)}} --}}
            @foreach($cartItems as $item)
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                   <h4 class="text-lg font-medium text-gray-900">{{ $item['nombre'] }}</h4>
                   {{-- <h4 class="text-lg font-medium text-gray-900">{{ $item['id'] }}</h4> --}}
                   <p class="text-lg font-bold text-gray-900">{{ number_format($item['cantidad'] * $item['precio'], 2) }}</p>
                </div>

            @endforeach
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                   <h4 class="text-lg font-medium text-gray-900">Total: </h4>

                    <p class="text-xl font-ligth text-gray-700">${{number_format($this->subTotal(), 2) }}</p>
                </div>
        </div>
        
    </div>    
    




+------------------------------------------+-----------------------+
|  COLUMNA IZQUIERDA (60%)                 | COLUMNA DERECHA (40%) |
|                                          |                       |
|  1. Datos del Cliente (Nombre, Email)    | Resumen del Pedido    |
|  2. Dirección de Envío                   | - Producto A x2  $100 |
|  3. Datos de Facturación (NIT/CI, Nombre)| - Producto B x1   $50 |
|  4. Método de Pago (QR / Transferencia)  |                       |
|                                          | Subtotal:         $150|
|  [ BOTÓN COMPLETO: REALIZAR PEDIDO ]     | Envío:             $10|
|                                          | TOTAL:            $160|
+------------------------------------------+-----------------------+
</div>
