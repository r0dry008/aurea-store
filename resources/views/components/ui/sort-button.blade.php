@props([
    'label' => '',
    'field' => '',
    'sortBy' => '',
    'sortDirection' => '',
])

<div class="flex items-center space-x-1 cursor-pointer">
    <span>
        {{ $label }}
    </span>
    @if($sortBy !== $field)
        <span>↕</span>
    @elseif($sortDirection === 'asc')
        <span>↑</span>
    @else
        <span>↓</span>
    @endif
</div>