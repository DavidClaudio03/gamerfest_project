<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive, onMounted, ref, watchEffect} from 'vue';
import Navbar from '@/Components/Navbar.vue'

defineProps({
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

const juegosInscritos = ref(
    JSON.parse(localStorage.getItem('juegosInscritos')) || []
);

const numJuegosSeleccionados = ref(juegosInscritos.value.length);

watchEffect(() => {
    const juegosInscritosLocalStorage = JSON.parse(localStorage.getItem('juegosInscritos')) || [];
    juegosInscritos.value = juegosInscritosLocalStorage;
    numJuegosSeleccionados.value = juegosInscritos.value.length;
});

const state = reactive({ juegos: [], total: 0 });


</script>

<template>
    <Head title="Inicio" />

    <div  class="fixed top-0 left-0 w-full navbar-container animate__animated animate__fadeInDown">
        <Navbar :can-login="canLogin" :can-register="canRegister" :laravel-version="laravelVersion"
            :php-version="phpVersion" :num-juegos-seleccionados="numJuegosSeleccionados"
            :juegos-inscritos="juegosInscritos">
        </Navbar>
    </div>

    <div class="mt-20">
        <div class="max-w-7xl mx-auto">
            <div class="most-popular" style="background-color: rgba(67, 61, 66, 0.86); margin-top: 160px;">
                <div class="text-white w-50 my-5" style="font-size: 16px; font-weight: bold; text-align: center; margin: 0 auto;">
                    <img src="/img/flash.png" alt="flash" style="display: block; margin: 30px auto;">
                    <p class="text-lg">
                        Tranquilo...  no vayas tan rápido, los certificados se podrán generar a partir del 22 de Junio (El día Inauguración del evento)
                    </p>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-white text-center mt-5" style="background-color: rgba(67, 61, 66, 0.86);">
        <div class="container p-4">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Justificaciones</h5>
                    <br>
                    <p>
                        Aquellas personas que se inscriban en cualquiera de los
                        juegos disponibles en el evento, recibirán un certificado que podrán usar
                        para justificar sus faltas en las clases que pierdan a causa del evento.
                    </p>
                </div>

                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Redes sociales</h5>
                    <br>
                    <div class="d-flex justify-content-center">
                    <a href="https://www.instagram.com/gamerfest.ec/" class="text-white mx-2" target="_blank">
                        <img src="img/instagram.png" class="d-block img-fluid" alt="Instagram Logo">
                    </a>
                    <a href="https://www.facebook.com/gamerfest.ec" class="text-white mx-2" target="_blank">
                        <img src="img/facebook.png" class="d-block img-fluid" alt="Facebook Logo">
                    </a>
                </div>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: black;">
            © 2023 Copyright:
            <a class="text-white">GamerFest</a>
        </div>
    </footer>
</template>

<style>

</style>

