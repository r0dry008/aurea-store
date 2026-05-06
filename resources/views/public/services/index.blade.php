<x-layouts.public>

    <section>
        <!-- .section_presentacion_servicios | padding-top:var(--space-md); padding-bottom:var(--space-md); -->
        <div class="py-16 px-4 md:px-8 max-w-7xl mx-auto">
            <!-- h2 | text-align: center; margin-bottom: var(--space-md); -->
            <h2 class="text-center text-4xl font-extrabold mb-12">Transformamos tus ideas en realidad</h2>
            <!-- p | text-align: center; margin-bottom: var(--space-md); -->
            <p class="text-center text-xl max-w-4xl mx-auto mb-8 text-gray-600">En Glifoo, creemos que cada emprendimiento tiene la capacidad de brillar y destacar en un mundo cada vez más competitivo. Nuestro objetivo es ayudarte a convertir tus ideas en proyectos tangibles y exitosos.</p>
            <p class="text-center text-xl max-w-4xl mx-auto text-gray-600">¡Juntos, podemos hacer que tu negocio se destaque y alcance su máximo potencial!</p>
        </div>
    </section>

    <!-- SECCIÓN DE CATEGORÍAS DE SERVICIOS -->
    <!-- .section_servicios | margin-top: var(--space-lg); -->
    <section class="mt-20 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- .section_servicios_categorias h2 | text-align: center; margin-bottom: var(--space-md); -->
            <h2 class="text-center text-3xl font-bold mb-12">¿Necesitas diferenciarte e impresionar con tu marca o emprendimiento?</h2>
            
            <!-- CONTENEDOR DE CATEGORÍAS -->
            <div class="space-y-20">

                <!-- ITEM 1 (ODD - Img a la Derecha por defecto en Desktop) -->
                <!-- .section_categoria_item | grid-template-columns: 1fr 1fr; gap: var(--space-md, 40px); padding-y: var(--space-lg, 60px); -->
                <!-- En móvil: grid-template-columns: 1fr; gap: 10px; align-items: flex-start; -->
                <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-16 items-start lg:items-center py-16">

                    <!-- Contenido de Texto (ODD - Orden por defecto: 1) -->
                    <div class="mb-4 lg:mb-0">
                        <h3 class="title_category text-3xl font-semibold mb-4 lg:m-0">Sistemas informáticos</h3>
                        <!-- .section_categoria_item_text p | margin-y: var(--space-base); line-height: var(--space-md); -->
                        <div class="text-gray-600">
                            <p class="mt-10 mb-4 leading-8">En la actualidad, tener una presencia sólida en la web es fundamental para cualquier empresa; y no solo eso, también es crucial contar con sistemas digitales eficientes para administrar tu negocio de manera efectiva. Te brindamos la ayuda que necesitas para desarrollar todo lo que tu empresa requiere en este ámbito. ¡TRABAJEMOS JUNTOS PARA IMPULSAR TU NEGOCIO!</p>
                            <a href="#" class="btn-primary">Ver más</a>
                        </div>
                    </div>

                    <!-- Imagen (ODD - Orden por defecto: 2) -->
                    <div class="section_categoria_item_img w-full flex justify-center items-center">
                        <!-- img | max-width:100%; height: 700px; object-fit: cover; border-radius: 8px; margin: auto; -->
                        <img class="max-w-full h-[32rem] object-cover block rounded-lg w-full" 
                             src="{{ asset('images/david.jpg') }}" 
                             onerror="this.onerror=null;this.src='https://placehold.co/800x700/60A5FA/FFFFFF?text=Imagen+Sistemas';" 
                             alt="Imagen de Sistemas informáticos">
                    </div>

                </div>
                
                <!-- ITEM 2 (EVEN - Img a la Izquierda en Desktop, reordenamos) -->
                <!-- .section_categoria_item:nth-child(even) -> grid-template-areas: "img title_category" "img text" -->
                <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-16 items-start lg:items-center py-16">

                    <!-- Imagen (EVEN - Orden por defecto: 1, pero visualmente a la Izquierda) -->
                    <div class="section_categoria_item_img w-full flex justify-center items-center">
                         <img class="max-w-full h-[32rem] object-cover block rounded-lg w-full" 
                             src="{{ asset('images/juger.jpg') }}" 
                             onerror="this.onerror=null;this.src='https://placehold.co/800x700/60A5FA/FFFFFF?text=Imagen+Diseño';" 
                             alt="Imagen de Diseño gráfico">
                    </div>

                    <!-- Contenido de Texto (EVEN - Usamos lg:order-last para forzar el orden 2 en desktop) -->
                    <div class="lg:order-last mt-4 lg:mt-0">
                        <h3 class="title_category text-3xl font-semibold mb-4 lg:m-0">Diseño gráfico</h3>
                         <div class="text-gray-600">
                            <p class="mt-10 mb-4 leading-8">Si deseas destacar y causar una buena impresión en tus clientes con diseños únicos y personalizados que reflejen la esencia de tu marca, ¡ANÍMATE A CONTACTARNOS!! Estamos aquí para ayudarte a crear una identidad visual que te permita diferenciarte en un mercado cada vez más competitivo.</p>
                            <a href="#" class="btn-primary">Ver más</a>
                        </div>
                    </div> 
                </div>

                <!-- ITEM 3 (ODD - Img a la Derecha) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-16 items-start lg:items-center py-16">

                    <!-- Contenido de Texto -->
                    <div class="mb-4 lg:mb-0">
                        <h3 class="title_category text-3xl font-semibold mb-4 lg:m-0">Fotografía</h3>
                        <div class="section_categoria_item_text text-gray-600">
                            <p class="mt-10 mb-4 leading-8">La imagen es crucial para transmitir la calidad de tu emprendimiento, producto o servicio. La fotografía se convierte en una herramienta imprescindible. Con Glifoo, puedes estar seguro de que obtendrás imágenes que no solo te destacarán, sino que también capturarán la esencia y personalidad de tu marca.</p>
                            <a href="#" class="btn-primary">Ver más</a>
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="section_categoria_item_img w-full flex justify-center items-center">
                         <img class="max-w-full h-[32rem] object-cover block rounded-lg w-full" 
                             src="{{ asset('images/kaneki.jpg') }}" 
                             onerror="this.onerror=null;this.src='https://placehold.co/800x700/60A5FA/FFFFFF?text=Imagen+Fotografía';" 
                             alt="Imagen de Fotografía">
                    </div>

                </div>

                <!-- ITEM 4 (EVEN - Img a la Izquierda) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-16 items-start lg:items-center py-16">
                    
                    <!-- Imagen -->
                    <div class="section_categoria_item_img w-full flex justify-center items-center">
                        <img class="max-w-full h-[32rem] object-cover block rounded-lg w-full" 
                             src="{{ asset('images/space.jpg') }}" 
                             onerror="this.onerror=null;this.src='https://placehold.co/800x700/60A5FA/FFFFFF?text=Imagen+Dirección';" 
                             alt="Imagen de Dirección y estilo">
                    </div>

                    <!-- Contenido de Texto (lg:order-last para reordenar en desktop) -->
                    <div class="lg:order-last mt-4 lg:mt-0">
                        <h3 class="title_category text-3xl font-semibold mb-4 lg:m-0">Dirección y estilo</h3>
                        <div class="section_categoria_item_text text-gray-600">
                            <p class="mt-10 mb-4 leading-8">En ocasiones, nuestras ideas más brillantes pueden parecer inalcanzables, y es fácil sentirse abrumado al intentar hacerlas realidad. Pero no te preocupes, estamos aquí para ayudarte. Nuestro equipo de expertos te brindará el asesoramiento necesario para crear las estrategias correctas y convertir tus sueños en una realidad tangible. ¡No esperes más, es hora de dar el primer paso hacia el éxito!</p>
                            <a href="#" class="btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.public>