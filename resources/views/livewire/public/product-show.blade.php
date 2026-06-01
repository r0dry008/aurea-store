<div>
  <div class="max-w-7xl mx-auto px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="bg-[#FDFBF2] rounded-xl p-8 flex justify-center">
            <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=500" alt="{{ $product->name }}" class="max-h-96 object-contain">
        </div>

        <div class="space-y-6">
            {{-- $product: instancia del producto con SKUs y atributos cargados --}}
            <h1 class="text-3xl font-bold text-black">{{ $product->name }}</h1>
            {{-- $selectedSku: SKU completo cuando todas las opciones están seleccionadas --}}
            <p class="text-xl font-semibold text-gray-800">
                ${{ number_format($selectedSku?->price ?? $product->skus->first()->price ?? 0, 2) }}
            </p>
            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>

            <div class="space-y-6">
                <hr class="border-gray-200">

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
                                    class="px-3 py-1.5 border rounded-md text-xs font-medium transition duration-150
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
                    <button wire:click="increment" type="button" class="cursor-pointer px-3 py-2 text-gray-500 hover:text-black transition">+</button>
                </div>

                <button wire:click="addToCart" type="button" class="cursor-pointer flex-1 bg-black hover:bg-gray-800 text-white font-semibold py-3 rounded-md transition tracking-wide text-sm">
                    Añadir al Carrito
                </button>
            </div>
        </div>
    </div>
  </div>
</div>
