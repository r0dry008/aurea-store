<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    @stack('js')
    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif
    
    <!-- Script para confirmación de eliminación -->
    <script>
        // Función para registrar el listener
        function registerDeleteListener() {
            Livewire.on('confirm-delete', (event) => {
                Swal.fire({
                    title: '¿Eliminar servicio?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    confirmButtonColor: "#dc2626",
                    cancelButtonColor: "#2563eb",
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-service', { id: event.id })
                    }
                });
            });
        }

        // Registrar cuando Livewire se inicializa
        if (document.readyState === 'loading') {
            document.addEventListener('livewire:init', registerDeleteListener);
        } else {
            // Si Livewire ya está cargado, registrar inmediatamente
            if (window.Livewire) {
                registerDeleteListener();
            } else {
                document.addEventListener('livewire:init', registerDeleteListener);
            }
        }
    </script>
</x-layouts.app.sidebar>
