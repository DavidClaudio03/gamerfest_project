<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import Swal from 'sweetalert2';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

import { ref, onMounted, watch, computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import axios from 'axios';

const props = defineProps({
    user_id: {
        type: Number,
    },
    role: {
        type: Boolean,
    },
});

const miembros = ref([]);
const equipos = ref([]);
const showModal = ref(false);

const formEquipo = useForm({
    id_equipo: '',
    id_juego: '',
    user_id: '',
    nombre_equipo: '',
    miembro: '',
    processing: false, // añadir esta propiedad si no existe
});

// Adiciona esta línea al inicio del script
const numeroMaxJugadores = 5;

// Modifica la función addMember así:
const addMember = () => {
    if (formEquipo.miembro && miembros.value.length < numeroMaxJugadores) {
        miembros.value.push(formEquipo.miembro);
        formEquipo.miembro = '';

    } else if (miembros.value.length >= numeroMaxJugadores) {
        // Muestra un mensaje usando sweetalert2 si se alcanza el límite de miembros
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            text: 'Has alcanzado el límite de miembros del equipo',
        });
    }
};


// Agrega la siguiente función para eliminWar miembros
const removeMember = (index) => {
    miembros.value.splice(index, 1);
};


// Función para cerrar el modal
const closeModal = () => {
    showModal.value = false;
};

const updateTeam = async () => {
    event.preventDefault(); 
    const id = formEquipo.id_equipo;
    const nombre_equipo = formEquipo.nombre_equipo;
    const miembros_list = miembros.value;
    const id_juego = formEquipo.id_juego;
    const user_id = formEquipo.user_id = props.user_id ?? null;

    const requestData = {
        id,
        id_juego,
        nombre_equipo,
        user_id,
        miembros: JSON.stringify(miembros_list)
    };

    try {
        // Aquí necesitas cambiar la URL a la que quieres enviar los datos del equipo.
        const pustResponse = await axios.put(`/equipos/${id}`, requestData);

        Swal.fire('Equipo actualizado', 'El equipo fue actualizado con éxito!', 'success')
            .then((result) => {
                // Si el equipo fue creado correctamente, puedes redirigir a otra página o hacer algo más.
                if (result.isConfirmed) {
                    // Limpiamos el formulario y la lista de miembros
                    formEquipo.nombre_equipo = '';
                    formEquipo.miembro = '';
                    formEquipo.reset();
                    miembros.value = [];
                    closeModal();
                    recuperarEquipos();
                }
            });
    } catch (error) {
        Swal.fire('Error', 'Hubo un error al actualizar el equipo', 'error');
    }
};


const recuperarEquipos = async () => {
    const user_id = props.user_id ? props.user_id : null;
    let formData = new FormData();

    formData.append('user_id', user_id);

    try {
        let response = await axios.post(`/equipo_por_juego`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        if (response.data) {
            equipos.value = response.data;
            return true;
        }

        // Si no hay equipo, retornamos false
        delete equipos.value[juegoId];
        return false;
    } catch (error) {
        console.error(error);
    }
}

const handleMiembroKeyDown = (event) => {
    if (event.key === 'Enter') {
        addMember();
        event.preventDefault(); 
    }
};


const openModal = (juegoId) => {

    const equipo = equipos.value.find(equipo => equipo.id_juego === juegoId);

    if (equipo) {
        formEquipo.id_equipo = equipo.id;
        formEquipo.id_juego = juegoId;
        formEquipo.user_id = props.user_id ?? null;
        formEquipo.nombre_equipo = equipo.nombre_equipo;
        miembros.value = JSON.parse(equipo.miembros);
    } else {
        // Si no se encuentra el equipo, limpiar el formulario y los miembros
        formEquipo.id_juego = juegoId;
        formEquipo.user_id = props.user_id ?? null;
        formEquipo.nombre_equipo = '';
        miembros.value = [];
    }

    showModal.value = true;
};


onMounted(async () => {
    await recuperarEquipos(); // Llama a la función recuperarEquipos al montar el componente
});

</script>

<template>
    <Head title="Mis Equipos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipos Registrados</h2>
        </template>

        <div class="py-12 animate__animated animate__fadeInUp">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <Modal :show="showModal" @close="closeModal">
                        <div class="p-6">
                            <h3 class="modal-title">Nuevo equipo</h3>
                            <form @submit="updateTeam">
                                <div>
                                    <InputLabel for="nombre_equipo" value="Nombre del equipo" />
                                    <TextInput id="nombre_equipo" type="text" class="mt-1 block w-full"
                                        v-model="formEquipo.nombre_equipo" required />
                                    <InputError class="mt-2" :message="formEquipo.errors.nombre_equipo" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="miembro" value="Miembro" />
                                    <TextInput id="miembro" type="text" class="mt-1 block w-full" ref="miembroInput" 
                                        v-model="formEquipo.miembro" @keydown="handleMiembroKeyDown"/>
                                    <span class="text-sm text-gray-400">(Ingresa el nombre real de cada integrante uno a la
                                        vez, da click a añadir miembro. Ej. John Doe)</span>
                                    <InputError class="mt-2" :message="formEquipo.errors.miembro" />
                                    <button type="button" :disabled="!formEquipo.miembro"
                                        class="flex justify-center items-center space-x-1 mt-2 bg-transparent hover:text-blue-600 text-gray-700 disabled:text-gray-400 disabled:cursor-not-allowed px-2 py-1 rounded"
                                        @click="addMember">
                                        <span>Añadir miembro</span>
                                        <i class="fa-solid fa-plus fa-xs flex items-center"></i>
                                    </button>
                                </div>

                                <div v-if="miembros.length" class="mt-4">
                                    <InputLabel value="Miembros del equipo" />
                                    <ul class="list-miembros">
                                        <li class="miembro-item" v-for="(miembro, index) in miembros" :key="index">
                                            {{ miembro }}
                                            <button style="text-align: right;"
                                                @click.prevent="removeMember(index)">&times;</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <button class="ml-4 btn" :disabled="formEquipo.processing" type="submit">
                                        <span style="padding: 10px;">Actualizar equipo</span>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </Modal>
                    <div v-if="equipos.length > 0" class="custom-width mx-auto px-4 sm:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="card" v-for="(equipo, index) in equipos" :key="index">
                                <div class="card-header text-center">
                                    <i class="fa-solid fa-khanda"></i> {{ equipo.nombre_equipo }}
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title font-bold"><i class="fas fa-users mr-2"></i>Miembros:</h5>
                                    <ul>
                                        <li class="ml-1" v-for="(miembro, index2) in JSON.parse(equipo.miembros)"
                                            :key="index2">
                                            - {{ miembro }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="action-container">
                                    <button @click="openModal(equipo.id_juego)" class="button-editar-equipo">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="custom-width mx-auto py-5 px-4 sm:px-8 text-center">
                        <span class="">No tienes equipos creados aún registrate en juegos grupales
                            <InertiaLink href="/" class="text-gray-600">Volver al Inicio</InertiaLink>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<!-- Estilos -->
<style>
.action-container {
    width: 100%;
    padding: 1em;
}

.button-editar-equipo {
    width: 100%;
    padding: .5em;
    border-radius: 5px;
    background-color: #30A2FF;
    color: white;
}

.custom-width {
    min-height: calc(80vh - 60px);
    height: calc(100vh - 60px);
}

.list-miembros {
    display: flex;
}

.miembro-item {
    min-width: 50px;
    border-radius: 5px;
    margin-right: .5em;
    padding: .25em .5em;
    color: #fff;
    background-color: #393646;
}

@media screen and (max-width: 850px) {
    .form-container {
        grid-template-columns: 1fr;
    }

    .btn {
        width: 100%;
        margin: 0;
        padding-top: 0 !important;
    }

    .file-label {
        width: 100%;
        margin: 0;
    }


}
</style>
