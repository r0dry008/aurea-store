@props(['paths' => []])

<nav class="flex items-center gap-2 py-4 text-sm text-gray-500">
    <a href="/" class="hover:text-gray-900 transition font-medium">Home</a>
    <span>&rsaquo;</span>
    <a href="/catalog" class="hover:text-gray-900 transition font-medium">Catalog</a>

    @foreach($paths as $path)
        <span>&rsaquo;</span>
        @if($loop->last)
            <span class="text-gray-900 font-semibold capitalize">{{ $path['name'] }}</span>
        @else
            <button type="button" wire:click="{{ $path['action'] }}" class="hover:text-gray-900 transition capitalize font-medium cursor-pointer">
                {{ $path['name'] }}
            </button>
        @endif
    @endforeach
</nav>