<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Component;

class ProductShow extends Component
{
    public $product;
    public $cantidad = 1;
    public array $selectedAttributes = [];
    public array $cartItems = [];

    /**
     * Monta el componente cargando el producto y sus SKUs con atributos.
     */
    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)
            ->with(['skus.attributeValues.attribute'])
            ->firstOrFail();

        $this->cartItems = session()->get('cartItems', []);
    }

    /**
     * Devuelve los atributos agrupados por attribute_id para la vista.
     *
     * Primero agrupamos por atributo y luego eliminamos valores duplicados dentro
     * de cada grupo. Esto evita purgar datos si dos valores distintos comparten el
     * mismo ID fuera de su atributo.
     */
    public function getGroupedAttributesProperty()
    {
        return $this->product->skus
            ->flatMap(fn ($sku) => $sku->attributeValues)
            ->groupBy(fn ($value) => $value->attribute->id)
            ->mapWithKeys(fn ($values, $attributeId) => [
                $attributeId => [
                    'attribute' => $values->first()->attribute,
                    'values' => $values->unique('id'),
                ],
            ]);
    }

    /**
     * Incrementa la cantidad de producto a agregar al carrito.
     */
    public function increment()
    {
        $this->cantidad++;
    }

    /**
     * Decrementa la cantidad de producto, sin permitir menos de 1.
     */
    public function decrement()
    {
        if ($this->cantidad > 1) {
            $this->cantidad--;
        }
    }

    /**
     * Calcula el SKU seleccionado según los atributos elegidos.
     *
     * Solo devuelve un SKU válido cuando el usuario ha elegido todas las opciones.
     */
    public function getSelectedSkuProperty()
    {
        $selectedValuesIds = array_filter($this->selectedAttributes);

        if (count($selectedValuesIds) < $this->groupedAttributes->count()) {
            return null; // Aún falta seleccionar atributos
        }

        return $this->product->skus->first(function ($sku) use ($selectedValuesIds) {
            $skuValueIds = $sku->attributeValues->pluck('id')->toArray();

            return count($skuValueIds) === count($selectedValuesIds)
                && empty(array_diff($selectedValuesIds, $skuValueIds));
        });
    }

    /**
     * Alterna la selección de un valor de atributo.
     *
     * Si el usuario hace clic de nuevo sobre la misma opción, la deselecciona.
     */
    public function toggleAttributeOption($attributeId, $valueId)
    {
        if (($this->selectedAttributes[$attributeId] ?? null) == $valueId) {
            unset($this->selectedAttributes[$attributeId]);
            return;
        }

        $this->selectedAttributes[$attributeId] = $valueId;
    }

    /**
     * Agrega el SKU seleccionado al carrito persistido en sesión.
     */
    public function addToCart()
    {
        $sku = $this->selectedSku;

        if (! $sku) {
            $this->addError('variant', 'Por favor, selecciona todas las especificaciones del producto');
            return;
        }

        $cartKey = $sku->id;

        if (isset($this->cartItems[$cartKey])) {
            $this->cartItems[$cartKey]['cantidad'] += $this->cantidad;
        } else {
            $detallesVariantes = [];

            foreach ($sku->attributeValues as $av) {
                $detallesVariantes[$av->attribute->name] = $av->value;
            }

            $this->cartItems[$cartKey] = [
                'sku_id' => $sku->id,
                'product_id' => $this->product->id,
                'nombre' => $this->product->name,
                'precio' => $sku->price,
                'cantidad' => $this->cantidad,
                'detalles_variantes' => $detallesVariantes,
            ];
        }

        session()->put('cartItems', $this->cartItems);
        $this->dispatch('cart:Updated');
        $this->reset('cantidad');
        session()->flash('success', 'Producto agregado al carrito');
    }

    /**
     * Determina si una opción de atributo es compatible con la selección actual.
     */
    public function isOptionAvailable($attributeId, $idValorAProbar)
    {
        $simulacionSeleccion = $this->selectedAttributes;
        $simulacionSeleccion[$attributeId] = $idValorAProbar;
        $valoresIdsAProbar = array_filter($simulacionSeleccion);

        foreach ($this->product->skus as $sku) {
            $skuValuesIds = $sku->attributeValues->pluck('id')->toArray();

            if (empty(array_diff($valoresIdsAProbar, $skuValuesIds))) {
                return true;
            }
        }

        return false;
    }

    public function render()
    {
        return view('livewire.public.product-show', [
            'groupedAttributes' => $this->groupedAttributes,
            'selectedSku' => $this->selectedSku,
        ])
            ->layout('components.layouts.public');
    }
}
