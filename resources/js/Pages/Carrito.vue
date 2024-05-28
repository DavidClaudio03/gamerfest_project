<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive, onMounted, ref, watchEffect } from 'vue';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Navbar from '@/Components/Navbar.vue';
import Modal from '@/Components/Modal.vue';
import axios from 'axios';

defineProps({
    role: {
        type: Boolean,
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    }
});

const user_id = ref(null);
const equipos = ref([]);

const juegosInscritos = ref(
    JSON.parse(localStorage.getItem('juegosInscritos')) || []
);

const numJuegosSeleccionados = ref(juegosInscritos.value.length);

watchEffect(() => {
    const juegosInscritosLocalStorage = JSON.parse(localStorage.getItem('juegosInscritos')) || [];
    juegosInscritos.value = juegosInscritosLocalStorage;
    numJuegosSeleccionados.value = juegosInscritos.value.length;
});

const state = reactive({ juegos: [], total: 0, loading: false });

const form = useForm({
    user_id,
    juegos: [],
    estado: '',
    nro_comprobante: '',
    valor_comprobante: 0.00,
    comprobante_pago: null,
    loading: false,
});

const formEquipo = useForm({
    id_equipo: '',
    id_juego: '',
    user_id: '',
    nombre_equipo: '',
    miembro: '',
});


const { props } = usePage();

const showModal = ref(false);
const miembros = ref([]);
const uploadedFileName = ref(null);
const isFileUploaded = ref(false);

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


// Función para crear equipo
const createTeam = async () => {
    const nombre_equipo = formEquipo.nombre_equipo;
    const miembros_list = miembros.value;
    const id_juego = formEquipo.id_juego;
    const user_id = formEquipo.user_id = props.auth.user ? props.auth.user.id : null;
    let formData = new FormData();

    formData.append('nombre_equipo', nombre_equipo);
    formData.append('user_id', user_id);
    formData.append('id_juego', id_juego);
    formData.append('miembros', JSON.stringify(miembros_list));

    try {
        // Aquí necesitas cambiar la URL a la que quieres enviar los datos del equipo.
        const postResponse = await axios.post('/equipos', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        Swal.fire('Equipo creado', 'El equipo fue creado con éxito!', 'success')
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
        Swal.fire('Error', 'Hubo un error al crear el equipo', 'error');
    }
};

const updateTeam = async () => {
    const id = formEquipo.id_equipo;
    const nombre_equipo = formEquipo.nombre_equipo;
    const miembros_list = miembros.value;
    const id_juego = formEquipo.id_juego;
    const user_id = formEquipo.user_id = props.auth.user ? props.auth.user.id : null;

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
    const user_id = props.auth.user ? props.auth.user.id : null;
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

// Función para abrir el modal
const openModal = (juegoId) => {

    const equipo = equipos.value.find(equipo => equipo.id_juego === juegoId);

    if (equipo) {
        formEquipo.id_equipo = equipo.id;
        formEquipo.id_juego = juegoId;
        formEquipo.user_id = props.auth.user ? props.auth.user.id : null;
        formEquipo.nombre_equipo = equipo.nombre_equipo;
        miembros.value = JSON.parse(equipo.miembros);
    } else {
        // Si no se encuentra el equipo, limpiar el formulario y los miembros
        formEquipo.id_juego = juegoId;
        formEquipo.user_id = props.auth.user ? props.auth.user.id : null;
        formEquipo.nombre_equipo = '';
        miembros.value = [];
    }

    showModal.value = true;
};


const getTotal = async () => {
    state.loading = true; 
    const juegosInscritos = JSON.parse(localStorage.getItem('juegosInscritos'));
    const response = await axios.post('/api/juegos/cargar-carrito', { juegosInscritos });

    state.juegos = response.data.juegos;
    state.total = response.data.total;

    
    form.juegos = state.juegos;
    state.loading = false;
}


onMounted(async () => {
    form.user_id = props.auth.user ? props.auth.user.id : null;
    recuperarEquipos();

    getTotal();

});

const updateFileName = () => {
    const maxLength = 12;
    if (form.comprobante) {
        let filename = form.comprobante.name;
        uploadedFileName.value = (filename.length >= maxLength) ? filename.slice(0, maxLength) + "..." : filename;
        isFileUploaded.value = true;
    } else {
        uploadedFileName.value = null;
        isFileUploaded.value = false;
    }
};


const removeJuego = (index) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el juego.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            state.juegos.splice(index, 1);
            localStorage.setItem('juegosInscritos', JSON.stringify(state.juegos));
            Swal.fire('Eliminado', 'El juego ha sido eliminado.', 'success');
            getTotal();
        }
    });
};



const submitForm = async () => {
    form.loading = true; // Comienza la petición

    const juegos = form.juegos;
const valor_comprobante = parseFloat(state.total).toFixed(2);
let nro_comprobante = null;
let comprobante_pago = null;

if (valor_comprobante === '0.00') {
  nro_comprobante = 'no aplica';
} else {
  nro_comprobante = document.getElementById('nro_comprobante').value;
  comprobante_pago = document.getElementById('comprobante_pago').files[0];

  if (!nro_comprobante || nro_comprobante.trim() === '') {
    Swal.fire('Error', 'Es necesario el número de comprobante', 'error');
    form.loading = false;
    return;
  }

  if (valor_comprobante !== '0.00' && (!comprobante_pago || !comprobante_pago.name)) {
    Swal.fire('Error', 'Es necesario subir la foto del comprobante', 'error');
    form.loading = false;
    return;
  }
}


    let formData = new FormData();
    formData.append('user_id', form.user_id);
    formData.append('juegos', JSON.stringify(juegos));
    formData.append('estado', form.estado);
    formData.append('nro_comprobante', nro_comprobante);
    formData.append('valor_comprobante', valor_comprobante);

    if (comprobante_pago) {
        formData.append('comprobante_pago', comprobante_pago, comprobante_pago.name);
    }


    // Check the number of juegos
    if (juegos.length > 3) {
        const confirmation = await Swal.fire({
            title: 'Confirmación',
            text: 'Tienes más de 3 juegos inscritos. Algunos juegos pueden llevarse a cabo simultáneamente (con el mismo horario). ¿Estás seguro de continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Soy consciente y no importa',
            cancelButtonText: 'Modificar Carrito',
        });

        if (!confirmation.isConfirmed) {
            return; // Stop the execution of the function
        }
    }

    try {
        const postResponse = await axios.post('/guardar_all_inscripciones', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        Swal.fire('Inscripcion creada', 'La inscripción fue creada con éxito!', 'success')
            .then((result) => {
                // Si la inscripción fue creada correctamente, redirigir a la página de inicio
                if (result.isConfirmed) {
                    localStorage.removeItem('juegosInscritos');
                    window.location.href = '/';
                }
            });
    } catch (error) {
        let errorMessage = 'Hubo un error al crear la inscripción';

        if (error.response) {
            // Si el servidor respondió con un status code fuera del rango de 2xx
            // Aquí puedes capturar la respuesta del error.
            // Por ejemplo, puedes acceder a los errores de validación devueltos por Laravel con error.response.data.errors
            errorMessage = error.response.data.message;
        } else if (error.request) {
            // Si se hizo la solicitud pero no se recibió una respuesta
            errorMessage = 'No se recibió respuesta del servidor';
        } else {
            // Algo sucedió al configurar la solicitud
            errorMessage = error.message;
        }

        Swal.fire('Error', errorMessage, 'error');
    } finally {
        form.loading = false; // Finaliza la petición
    }
};

</script>

<template>
    <Head title="Carrito de Compras" />

    <div class="fixed top-0 left-0 w-full navbar-container animate__animated animate__fadeInDown">
        <Navbar :can-login="canLogin" :can-register="canRegister" :laravel-version="laravelVersion"
            :php-version="phpVersion" :num-juegos-seleccionados="numJuegosSeleccionados"
            :juegos-inscritos="juegosInscritos">
        </Navbar>

    </div>
    <div class="mt-20">
        <div class="max-w-4xl mx-auto">
            <div v-if="!state.loading || juegosInscritos.length == 0" class="most-popular animate__animated animate__fadeInDown"
                style="background-color: rgba(67, 61, 66, 0.86); margin-top: 140px;">
                <h2 class="section-title">Carrito de Compras</h2>
                <div v-if="state.juegos.length > 0">

                    <ul v-for="(juego, index) in state.juegos" :key="juego.id" role="list"
                        class="divide-y divide-gray-200 dark:divide-gray-700 animate__animated animate__fadeIn">


                        <li class="pt-3 pb-0 sm:pt-4 animate__animated animate__fadeInDown">
                            <div class="flex flex-col sm:flex-row items-center space-x-4 sm:space-x-4 justify-between">
                                <!-- Contenido a la izquierda -->
                                <div
                                    class="flex justify-between items-center space-x-4 sm:space-x-0 sm:space-y-4 mb-4 sm:mb-0 part-1">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full img-cart" :src="'/img/' + juego.img_id + '.jpg'"
                                            alt="Game image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white truncate">
                                            {{ juego.nombre }}
                                        </p>
                                        <p class="text-sm text-gray-400 truncate">
                                            {{ juego.genero }}/{{ juego.modalidad }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Contenido a la derecha -->
                                <div class="flex flex-row items-center space-x-4 sm:space-x-4 part-2">
                                    <div v-if="juego.modalidad == 'grupo'">
                                        <button
                                            v-if="equipos.length && equipos.find(equipo => equipo.id_juego === juego.id)"
                                            @click="openModal(juego.id)" class="ml-2 info">Editar equipo</button>
                                        <button v-else @click="openModal(juego.id)" class="ml-2 info">Crear equipo</button>
                                    </div>

                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white ">
                                        <span class="money">$ {{ juego.costo_inscripcion }}</span>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white ">
                                        <button @click="removeJuego(index)" class="text-sm font-medium delete-button">
                                            <div class="delete-wrapper">
                                                <i class="fa-solid fa-trash delete-icon"></i>
                                                <span class="delete-message">Eliminar</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>


                    </ul>
                    <Modal :show="showModal" @close="closeModal">
                        <div class="p-6">
                            <h3 class="modal-title">Nuevo equipo</h3>
                            <form @submit.prevent="createTeam">
                                <div>
                                    <InputLabel for="nombre_equipo" value="Nombre del equipo" />
                                    <TextInput id="nombre_equipo" type="text" class="mt-1 block w-full"
                                        v-model="formEquipo.nombre_equipo" required />
                                    <InputError class="mt-2" :message="formEquipo.errors.nombre_equipo" />
                                </div>

                                <form class="mt-4" @submit.prevent="addMember">
                                    <InputLabel for="miembro" value="Miembro" />
                                    <TextInput id="miembro" type="text" class="mt-1 block w-full"
                                        v-model="formEquipo.miembro" />
                                    <span class="text-sm text-gray-400">(Ingresa el nombre real de cada integrante uno a la
                                        vez, da click a añadir miembro. Ej. John Doe)</span>
                                    <InputError class="mt-2" :message="formEquipo.errors.miembro" />
                                    <button type="submit" :disabled="!formEquipo.miembro"
                                        class="flex justify-center items-center space-x-1 mt-2 bg-transparent hover:text-blue-600 text-gray-700 disabled:text-gray-400 disabled:cursor-not-allowed px-2 py-1 rounded">
                                        <span>Añadir miembro</span>
                                        <i class="fa-solid fa-plus fa-xs flex items-center"></i>
                                    </button>

                                </form>

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
                                    <template v-if="formEquipo.id_equipo !== '' && formEquipo.id_equipo !== null">
                                        <PrimaryButton class="ml-4 btn" :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing" @click.prevent="updateTeam">
                                            <span>Actualizar equipo</span>
                                        </PrimaryButton>
                                    </template>
                                    <template v-else>
                                        <PrimaryButton class="ml-4 btn" :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing" @click.prevent="createTeam">
                                            <span>Crear equipo</span>
                                        </PrimaryButton>
                                    </template>
                                </div>

                            </form>
                        </div>
                    </Modal>
                    <div class="total-container">
                        <strong>Total: </strong> ${{ parseFloat(state.total).toFixed(2) }}
                    </div>
                    <form class="btn-container form-container animate__animated animate__fadeIn" @submit.prevent="submitForm">
                        <input v-if="state.total !== 0" placeholder="Número de comprobante" class="cart-input"
                            style="width: 100%;" type="text" name="nro_comprobante" id="nro_comprobante">
                        <div v-if="state.total !== 0">
                            <input type="file" id="comprobante_pago" name="comprobante_pago"
                                @change="form.comprobante = $event.target.files[0]; updateFileName()"
                                accept="image/jpg, image/jpeg, image/png, image/gif" style="display: none;" />
                            <label for="comprobante_pago" class="file-label" id="file-label-id">
                                <div v-if="isFileUploaded">
                                    <i class="fa fa-check" style="padding-right: 5px;"></i>
                                    <span class="text-sm">{{ uploadedFileName }}</span>
                                </div>
                                <div v-else>
                                    <i class="fa-regular fa-folder" style="padding-right: 5px;"></i>
                                    <span class="text-sm">SUBIR ARCHIVO</span>
                                </div>
                            </label>
                        </div>
                        <PrimaryButton class="md:ml-1 btn" :class="{ 'opacity-25': form.processing || form.loading }"
                            :disabled="form.processing || form.loading" @click="submitForm">
                            <span v-if="!form.loading">{{ state.total === 0 ? 'Realizar Inscripción' : 'Procesar Pago'
                            }}</span>
                            <span v-else>Cargando...</span>
                        </PrimaryButton>
                        <div v-if="state.total !== 0" class="text-white text-bold">
                            <span class="text-xs float-left">Es necesario realizar el deposito a la cuenta: 2207885275
                                Titular: Mayuri Jhomayra Plasencia Velasco - Banco Pichincha - CI: 0504661406</span>
                        </div>
                    </form>


                </div>
                <div v-else class="py-4 text-center">
                    <span class="message">No tienes items agregados al carrito aún
                        <Link href="/" class="link">Volver al Inicio</Link>
                    </span>
                </div>

            </div>

        </div>

    </div>
</template>

<style>
body {
    background: linear-gradient(-45deg, #6a057f, #8b008b, #483d8b, #4169e1, #1e90ff);
    background-size: 500% 500%;
    animation: gradient 10s ease infinite;
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    z-index: -1;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: url('/img/bright-squares.png');
    background-size: contain;
    background-repeat: repeat;
    opacity: .2;
    pointer-events: none;
}


@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }

    25% {
        background-position: 50% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    75% {
        background-position: 50% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.cart-input {
    border-radius: 5px;
    height: 50px;
}

.form-container {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    grid-gap: 10px;
}

.file-label {
    width: 200px;
    border: 1px solid #fff;
    letter-spacing: 2px;
    font-size: 12px;
    height: 50px;
    padding: 10px;
    overflow: hidden;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

.file-label span {
    font-size: 12px;
    max-width: 200px;
    text-transform: uppercase;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.file-label:hover {
    background-color: #55aa59;
}

.img-cart {
    width: 40px;
    height: 40px;
    margin-right: 15px;
}


@media screen and (max-width: 640px) {
    .part-1 {
        flex-direction: column;
        margin: 0 auto;
        text-align: center;
    }

    .img-cart {
        width: 60px;
        height: 60px;
        transform: translateX(20px);
        margin-bottom: 10px;
    }


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
    }

    .file-label {
        width: 100%;
        margin: 0;
    }


}</style>