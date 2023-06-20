<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, watch } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { InertiaLink } from '@inertiajs/inertia-vue3';

const props = defineProps({
    role: {
        type: Boolean,
    },
    inscripciones: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Mis Inscripciones" />
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Juegos Inscritos</h2>
        </template>
        <div  v-if="inscripciones.length > 0" class="custom-width mx-auto px-4 sm:px-8">
            <div class="py-12 animate__animated animate__fadeInUp">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                    <div v-for="(inscripcion, index) in inscripciones" :key="index" class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center">
                                <img :src="'/img/' + inscripcion.img_id + '.jpg'" alt="imagen del juego" class="w-14 h-14 rounded-full" />
                                <div class="ml-5">
                                    <h2 class="text-lg leading-7 font-semibold text-gray-900">{{ inscripcion.juego_nombre }}</h2>
                                    <p class="mt-1 text-sm text-gray-500">Modalidad: {{ inscripcion.tipo }}</p>
                                    <p v-if="inscripcion.tipo === 'Grupal'" class="mt-1 text-sm text-gray-500">Equipo: {{ inscripcion.equipo_nombre }}</p>
                                    <p :class="{'text-green-500': inscripcion.estado_pago === 'verificado', 'text-red-500': inscripcion.estado_pago === 'pendiente'}" class="mt-1 text-sm">
                                        <span class="text-gray-500">Verificación pago:</span> {{ (inscripcion.juego_nombre=="Concurso de Videojuego" || inscripcion.juego_nombre=="Concurso de Cosplay") ? "No aplica" : inscripcion.estado_pago }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="custom-width mx-auto py-5 px-4 sm:px-8 text-center">
                    <span class="">No tienes items agregados al carrito aún
                        <InertiaLink href="/" class="text-gray-600">Volver al Inicio</InertiaLink>
                    </span>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.custom-width {
    min-height: calc(80vh - 60px);
    height: calc(100vh - 60px);
}

.message.inscripciones{
    padding: 20px;
    max-width: 20px;
    color: black;
}

</style>
