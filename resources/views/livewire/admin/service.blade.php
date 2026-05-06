
<div>
<div class="flex items-center justify-between mb-4">
    <nav class="text-sm font-medium text-on-surface dark:text-on-surface-dark" aria-label="breadcrumb">
	<ol class="flex flex-wrap items-center gap-1">
		<li class="flex items-center gap-1">
			<a href="{{ route('dashboard') }}" class="hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong">{{ __('Dashboard') }}</a>
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
				<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
			</svg>
		</li>
		<li class="flex items-center text-on-surface-strong gap-1 font-bold dark:text-on-surface-dark-strong" aria-current="page">{{ __('Servicios') }}</li>
	</ol>
    </nav>
    <div x-data="{modalIsOpen: true}">
        <button x-on:click="modalIsOpen = true" type="button" class="whitespace-nowrap rounded-radius bg-success border border-success px-4 py-2 text-sm font-medium tracking-wide text-onSuccess transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-onSuccess dark:focus-visible:outline-success">Nuevo servicio</button>
        <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
            <!-- Modal Dialog -->     
            <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 -translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="flex max-w-2xl flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">             
                <!-- Dialog Header -->
                <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                    <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">Crear nuevo servicio</h3>
                    <button x-on:click="modalIsOpen = false" aria-label="close modal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <!-- Dialog Body -->
                <div class="px-4 py-4"> 
                <p class="text-sm text-on-surface-variant dark:text-on-surface-dark-variant">
                    Introduzca el nombre y una descripción concisa para el nuevo servicio. Esta información será visible para los usuarios en la página principal del catálogo.
                </p>
                </div>
                <form action="" wire:submit.prevent="save" method="POST">
                <div class="px-4 py-4 flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Nombre</label>
                    <input wire:model.live="name" id="textInputDefault" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="name" placeholder="Ingresa el nombre del servicio"/>
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    
                    <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Descripción</label>
                    <input wire:model.live="description" id="textInputDefault" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="description" placeholder="Ingresa una descripción concisa del servicio"/>
                    @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror

                    {{-- <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Imagen</label>
                    <input accept="image/*" wire:model.live="image" id="textInputDefault" type="file" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="image" placeholder="Ingresa la URL de la imagen del servicio"/>
                    @error('image')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror --}}
                </div>
                <!-- Dialog Footer -->
                <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                    <button x-on:click="modalIsOpen = false" type="button" class="cursor-pointer whitespace-nowrap rounded-radius px-4 py-2 text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark">Cancelar</button>
                    <button type="submit" class="cursor-pointer whitespace-nowrap rounded-radius bg-primary border border-primary dark:border-primary-dark px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">Guardar</button>
                </div>
            </form>
            </div>
        </div>
    </div>

</div>



    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
    <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
        <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
            <tr>
                <th scope="col" class="p-4">CustomerID</th>
                <th scope="col" class="p-4">Name</th>
                <th scope="col" class="p-4">Email</th>
                <th scope="col" class="p-4">Membership</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                <tr>
                    <td class="p-4">2335</td>
                    <td class="p-4">Alice Brown</td>
                    <td class="p-4">alice.brown@gmail.com</td>
                    <td class="p-4">Silver</td>
                </tr>
                <tr>
                    <td class="p-4">2338</td>
                    <td class="p-4">Bob Johnson</td>
                    <td class="p-4">johnson.bob@outlook.com</td>
                    <td class="p-4">Gold</td>
                </tr>
                <tr>
                    <td class="p-4">2342</td>
                    <td class="p-4">Sarah Adams</td>
                    <td class="p-4">s.adams@gmail.com</td>
                    <td class="p-4">Gold</td>
                </tr>
        </tbody>
    </table>
</div>






</div>

