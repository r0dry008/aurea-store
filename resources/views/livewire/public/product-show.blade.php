<div>
  <div class="max-w-7xl mx-auto px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="relative bg-[#FDFBF2] rounded-xl p-8 flex justify-center">
            <img src="" alt="{{ $product->name }}" class="max-h-96 object-contain">
            @if($this->sumaStockSkus($product->id) == 0)
            <h3 class="absolute top-4 left-4 bg-red-500 text-white font-bold py-1 px-3 rounded-md">Agotado</h3>
            @endif
        </div>

        <div class="space-y-6">
            {{-- $product: instancia del producto con SKUs y atributos cargados --}}
            <h1 class="text-3xl font-bold text-black">{{ $product->name }}</h1>
            {{-- $selectedSku: SKU completo cuando todas las opciones están seleccionadas --}}
            <p class="text-xl font-semibold text-gray-800">
                ${{ number_format($selectedSku?->price ?? $product->skus->first()->price ?? 0, 2) }}
            </p>
            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            {{-- {{ $this->sumaStockSkus($product->id)}} --}}
            {{-- <input type="text" value="{{ $selectedSku?->id ?? $product->skus->first()->id ?? '' }}" >
            <input type="text" value="{{ $selectedSku?->stock ?? $product->skus->first()->stock ?? '' }}" > --}}
            <div class="space-y-6">
                <hr class="border-gray-200">

{{-- 
    //imprimir la cadena de atributos agrupados
    // dump($groupedAttributes) --}}
                {{-- Recorremos cada atributo disponible y mostramos sus valores --}}
                @foreach($groupedAttributes as $attributeId => $group)
                    <div class="space-y-3">
                        <p class="text-sm font-semibold text-gray-700">{{ $group['attribute']->name }}</p>
                        <div class="flex flex-wrap gap-2">

                            @foreach($group['values'] as $value)
                                @php
                                    $isAvailable = $this->isOptionAvailable($attributeId, $value->id);
                                    $isSelected = ($selectedAttributes[$attributeId] ?? null) == $value->id;
                                @endphp
                                <button type="button"
                                    wire:click="toggleAttributeOption({{ $attributeId }}, {{ $value->id }})"
                                    @disabled(!$isAvailable)
                                    class="cursor-pointer px-3 py-1.5 border rounded-md text-xs font-medium transition duration-150
                                        {{ $isSelected 
                                            ? 'border-blue-600 bg-blue-50 text-blue-600 font-bold ring-2 ring-blue-600/20' 
                                            : (!$isAvailable 
                                                ? 'border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed opacity-50 line-through' 
                                                : 'border-gray-200 text-gray-700 hover:border-black cursor-pointer') 
                                        }}">
                                    {{ $value->value }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('variant')
                    <span class="text-red-500 text-xs font-semibold block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center border border-gray-200 rounded-md bg-white">
                    <button wire:click="decrement" type="button" class="cursor-pointer px-3 py-2 text-gray-500 hover:text-black transition">-</button>
                    {{-- $cantidad: cantidad de unidades seleccionadas para agregar al carrito --}}
                    <span class="px-4 font-semibold text-sm select-none">{{ $cantidad }}</span>
                    <button wire:click="increment({{$selectedSku->id??0}})" type="button" class="cursor-pointer px-3 py-2 text-gray-500 hover:text-black transition">+</button>
                </div>
                @if($selectedSku && $selectedSku->stock <= 0 )

                <button type="button" class="flex-1 border bg-white text-black font-semibold py-3 rounded-md transition tracking-wide text-sm" disabled>
                    Producto no disponible
                </button>
                @else
            {{-- {{dd($selectedSku->id??0)}} --}}

                <button wire:click="addToCart" type="button" class="cursor-pointer flex-1 bg-black hover:bg-gray-800 text-white font-semibold py-3 rounded-md transition tracking-wide text-sm">
                    Añadir al Carrito{{$selectedSku->id??0}}
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($similarProducts->isNotEmpty())
        <div class="max-w-7xl mx-auto px-8 pb-12">
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-black mb-6">Productos similares</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($similarProducts as $similarProduct)
                        <div class="bg-[#FFFDF6] border border-gray-100 rounded-xl p-4 flex flex-col justify-between group transition">
                            <div class="relative bg-[#FDFBF2] rounded-lg aspect-square flex items-center justify-center">
                                <img src="" alt="{{ $similarProduct->name }}" class="object-cover transition duration-700 ease-out group-hover:scale-105 cursor-pointer">
                            </div>
                            <div>
                                <a href="{{ route('reverb.product.show', $similarProduct->slug) }}" wire:navigate>
                                    <h3 class="font-bold text-2xl text-black mb-1">{{ $similarProduct->name }}</h3>
                                </a>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="font-bold text-sm text-black">
                                        @if($similarProduct->skus->isNotEmpty())
                                            Bs.{{ number_format($similarProduct->skus->first()->price, 2) }}
                                        @else
                                            Precio no disponible
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
  </div>
</div>
