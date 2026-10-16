@if ($paginator->hasPages())
    <nav aria-label="pagination">
        <ul class="flex shrink-0 items-center gap-2 text-sm font-medium">
            {{-- Botón Anterior (Previous) --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center rounded-radius p-1 text-outline cursor-not-allowed dark:text-outline-dark opacity-50" aria-disabled="true" aria-label="previous page">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <button type="button" wire:click="previousPage" wire:loading.attr="disabled" class="flex items-center rounded-radius p-1 text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark cursor-pointer" aria-label="previous page">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Previous
                    </button>
                </li>
            @endif

            {{-- Elementos de las Páginas --}}
            @foreach ($elements as $element)
                {{-- Separador de Omisión "..." --}}
                @if (is_string($element))
                    <li>
                        <span class="flex size-6 items-center justify-center p-1 text-on-surface/50 dark:text-on-surface-dark/50">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array de Enlaces de Páginas --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <button type="button" class="flex size-6 items-center justify-center rounded-radius bg-primary p-1 font-bold text-on-primary dark:bg-primary-dark dark:text-on-primary-dark cursor-default" aria-current="page" aria-label="page {{ $page }}">
                                    {{ $page }}
                                </button>
                            </li>
                        @else
                            <li>
                                <button type="button" wire:click="gotoPage({{ $page }})" class="flex size-6 items-center justify-center rounded-radius p-1 text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark cursor-pointer" aria-label="page {{ $page }}">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón Siguiente (Next) --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" wire:click="nextPage" wire:loading.attr="disabled" class="flex items-center rounded-radius p-1 text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark cursor-pointer" aria-label="next page">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </li>
            @else
                <li>
                    <span class="flex items-center rounded-radius p-1 text-outline cursor-not-allowed dark:text-outline-dark opacity-50" aria-disabled="true" aria-label="next page">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif