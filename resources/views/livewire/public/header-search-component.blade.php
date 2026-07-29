<div>
    <div class="w-full max-w-md">
    <form wire:submit="searchProducts" class="relative flex items-center">
        <input 
        wire:model="search"
        type="text" 
        placeholder="Buscar productos..." 
        class="w-full text-sm bg-gray-100 text-gray-800 placeholder-gray-400 pl-4 pr-10 py-2 rounded-lg border border-transparent outline-hidden transition duration-200 focus:bg-white focus:border-gray-300 focus:ring-2 focus:ring-gray-100"
        >
        <button 
            type="submit" 
            class="absolute right-2 p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-200/50 transition duration-150 cursor-pointer"
            aria-label="Buscar"
        > 
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        </button>
       </form>   
            
    </div>
</div>
