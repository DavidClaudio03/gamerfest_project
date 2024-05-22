<script setup>
import { ref, watchEffect } from 'vue';
import Swal from 'sweetalert2';
import { Head, Link } from '@inertiajs/vue3';

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
    },
    numJuegosSeleccionados: {
        type: Number,
        required: true,
    },
    juegosInscritos: {
        type: Array,
        required: true,
    }
});


const toggleMenu = () => {
    isActive.value = !isActive.value;
}

const showAlert = () => {
    Swal.fire({
        title: 'Inscripciones cerradas',
        text: 'Por el momento, no se aceptan más inscripciones. Lamentamos los inconvenientes.',
        icon: 'info',
        confirmButtonText: 'Entendido'
    });
}

const isActive = ref(false);


</script>

<template>
    <nav class="flex items-center justify-between" style="background-color: transparent;">
    <div class="flex items-center">
        <Link href="/">
            <img src="/img/logoGTA.png" alt="Logo" class="w-54 h-28">
        </Link>
    </div>
        <div class="mobile-menu" :class="{ 'active': isActive }">
            <div class="mobile-menu-head">
                <span class="menu-label">Menú</span>
                <span class="close" @click="toggleMenu">&times;</span>
            </div>
            <hr style="color: white; background-color: white;">
            <Link v-if="$page.props.auth.user && $page.props.role" :href="route('dashboard')"
                @click="toggleMenu"
                class="py-4 px-3 font-semibold text-white  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
            Dashboard
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('inscripciones')"
            class="py-4 px-3 font-semibold text-white  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
            Mis Incripciones
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('certificado')" @click="toggleMenu"
            class="py-4 px-3 font-semibold text-white  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
            Generar Certificado
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('profile.edit')" @click="toggleMenu"
                class="py-4 px-3 font-semibold text-white  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
            {{ $page.props.auth.user.name }}
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('logout')" method="post" @click="toggleMenu"
                class="py-4 px-3 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
            Salir
            </Link>

            <template v-else>
                <a href="/pdf/horarios_gamerfest.pdf" target="_blank" class="py-4 px-3 font-semibold text-white dark:text-white-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile" as="button">
                    <i class="fas fa-clock"></i>
                    <span>Horarios</span>
                </a>
                <Link :href="route('login')" @click="toggleMenu"
                    class="py-4 px-3 font-semibold text-white dark:text-white-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
                Ingreso
                </Link>

                <Link v-if="canRegister" :href="route('register')" @click="toggleMenu"
                    class="py-4 px-3 font-semibold text-white dark:text-white-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch-mobile">
                Registro
                </Link>
            </template>
        </div>
        <div class="flex items-center space-x-4">
            <Link v-if="$page.props.auth.user && $page.props.role" :href="route('dashboard')"
                class="ml-4 mr-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
            Dashboard
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('certificado')"
                class="ml-4 mr-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
            Generar Certificado
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('inscripciones')"
                class="ml-4 mr-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
            Mis Incripciones
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('profile.edit')"
                class="ml-4 mr-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
            {{ $page.props.auth.user.name }}
            </Link>
            <Link v-if="$page.props.auth.user" :href="route('logout')" method="post"
                class="ml-4 mr-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
            Salir
            </Link>

            <template v-else>
                <a href="/pdf/horarios_gamerfest.pdf" target="_blank" class="mr-4 md:ml-0 md:mr-0 md:mt-2 font-semibold text-white dark:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch" as="button">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Horarios</span>
                </a>
                <!-- <Link :href="route('login')"
                    class="mr-4 md:ml-0 md:mr-0 md:mt-2 font-semibold text-white dark:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
                Ingreso
                </Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 mr-4 pr-2 md:ml-0 md:mr-0 md:mt-2  font-semibold text-white dark:text-white-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 glitch">
                Registro
                </Link> -->
            </template>

            <Link :href="route('carrito')"
                class="ml-4 mr-4 pr-2 pl-2 md:ml-0 md:mr-0 md:mt-2 text-white  dark:text-white-400 glitch" id="cart">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28" viewBox="0 0 256 256">
                    <path fill="currentColor"
                        d="M225.21 56.31A12 12 0 0 0 216 52H58l-4.27-23.58A20 20 0 0 0 34.05 12H16a12 12 0 0 0 0 24h14.71l24.91 137a28 28 0 0 0 4.07 10.21A32 32 0 1 0 115 196h34a32 32 0 1 0 31-24H83.17a4 4 0 0 1-3.93-3.28L76.92 156H188.1a28 28 0 0 0 27.55-23l12.16-66.86a12 12 0 0 0-2.6-9.83ZM92 204a8 8 0 1 1-8-8a8 8 0 0 1 8 8Zm88 8a8 8 0 1 1 8-8a8 8 0 0 1-8 8Zm12-83.28a4 4 0 0 1-3.9 3.28H72.56L62.38 76h139.24Z" />
                </svg>
            </svg>
            <span class="cart-item-number">{{ numJuegosSeleccionados }}</span>
            </Link>
            <button data-collapse-toggle="navbar-default" type="button" @click="toggleMenu"
                class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 mobile-button"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </nav>
</template>

<style>
@media (max-width: 600px) {
    .most-popular {
        margin: 10px;
        /* Ajusta estos valores segun tus necesidades */
        padding: 18px;
        border-radius: 10px;
    }



    .carousel-inner {
        border-radius: 10px !important;
    }

    .section-title {

        font-size: 1.9rem;
        margin: 1rem;
        text-shadow: 2px 2px 0px #2c2c2c,
            3px 3px 0px #EF5097,
            4px 4px 0px #6868AC;

    }


    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        margin: 1em;
        background-color: #1e1e1e;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
        cursor: pointer;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .mobile-button {
        display: block !important;
    }

    .glitch:not(#cart) {
        display: none;
    }
}

@media (max-width: 576px) {
    .carousel-item img {
        max-height: 300px;
        /* Ajusta este valor según sea necesario */
        object-fit: cover;
        /* Asegura que la imagen cubra el área disponible sin deformarse */
    }

}

.mobile-button {
    display: none;
}

.close {
    color: white;
    cursor: pointer;
    width: 20%;
}

.close:hover {
    color: #DB005B;
    border: none;
}

.cart-item-number {
    position: absolute;
    font-size: 10px;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
    padding: .25em .35em;
    text-align: center;
    border-radius: 5px;
    background-color: #DB005B;
    transform: translate(18px, -35px);
    min-width: 10px;
}
</style>
