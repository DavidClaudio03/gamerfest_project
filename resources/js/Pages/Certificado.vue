<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive, onMounted, ref, watchEffect} from 'vue';
import Swal from 'sweetalert2';
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

const form = useForm({
    tipo_certificado: "ninguno",
})

const numJuegosSeleccionados = ref(juegosInscritos.value.length);

watchEffect(() => {
    const juegosInscritosLocalStorage = JSON.parse(localStorage.getItem('juegosInscritos')) || [];
    juegosInscritos.value = juegosInscritosLocalStorage;
    numJuegosSeleccionados.value = juegosInscritos.value.length;
});

const state = reactive({ juegos: [], total: 0 });

const generateCertificado = async () => {
    if (form.tipo_certificado !== 'ninguno') {
        try {
            const response = await axios.post('/generar_certificado', { tipo_certificado: form.tipo_certificado }, { responseType: 'blob' });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            const contentDisposition = response.headers['content-disposition'];
            let fileName = 'report.pdf';
            if (contentDisposition) {
                const fileNameMatch = contentDisposition.match(/filename="(.+)"/);
                if (fileNameMatch.length === 2)
                    fileName = fileNameMatch[1];
            }
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
            link.remove();
        } catch (error) {
            if (error.response) {
                Swal.fire({
                    title: 'Fallo al generar',
                    text: "Parece que no te has inscrito en ningun juego :( ",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: "Ha ocurrido un error inesperado",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    }
}


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

            <!-- Información del Evento -->
            <div class="event-info text-white w-75 my-5 mx-auto text-center">
                <h1 style="font-size: 28px; font-weight: bold;">Gamerfest 2023</h1>
                <p style="font-size: 16px; margin-top: 20px;">Descubre más sobre el evento, los participantes y los juegos que hicieron historia este año.</p>
            </div>

            <!-- Galería -->
            <div class="slider">
                <div class="slide-track">
                    <div class="slide">
                        <img src="img/clash_royale.jpg" alt="Imagen 1">
                    </div>
                    <div class="slide">
                        <img src="img/fifa.jpg" alt="Imagen 2">
                    </div>
                    <div class="slide">
                        <img src="img/mario_kart.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/just_dance.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/free_fire.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/mortal_kombat.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/valorant.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/lol.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/dragon_ball.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/dota2.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/clash_royale.jpg" alt="Imagen 1">
                    </div>
                    <div class="slide">
                        <img src="img/fifa.jpg" alt="Imagen 2">
                    </div>
                    <div class="slide">
                        <img src="img/mario_kart.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/just_dance.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/free_fire.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/mortal_kombat.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/valorant.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/lol.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/dragon_ball.jpg" alt="Imagen 3">
                    </div>
                    <div class="slide">
                        <img src="img/dota2.jpg" alt="Imagen 3">
                    </div>
                </div>
            </div>


            <!-- Botón de Certificado -->
            <div class="text-white w-100 my-5 flex flex-col items-center" style="font-size: 16px; font-weight: bold;">                    
                <select name="tipo_certificado" id="tipo_certificado" class="text-black font-thin rounded" v-model="form.tipo_certificado">
                    <option value="ninguno">-- Selecciona un tipo de Certificado -- </option>
                    <option value="diploma" class="Asistencia">Diploma</option>
                    <option value="formal" class="Formal">Formal</option>
                </select>

                <button 
                    class="mt-4 flex justify-center items-center px-4 py-2 bg-purple-800 hover:bg-purple-700 text-white rounded"
                    @click.prevent="generateCertificado">
                    Obtener mi Certificado
                </button>
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

.slider {
    overflow: hidden;
    height: 250px; /* Asegúrate de que esta sea la altura correcta para tu slider */
    position: relative;
}
.slider::before, .slider::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0; /* Agrega esta propiedad para asegurar que el pseudo-elemento tenga la altura completa */
    width: 50px;
    z-index: 2; /* Asegura que los pseudo-elementos queden por encima de las imágenes */
    background: linear-gradient(to right, rgba(46, 40, 40,0.50) 0%, transparent 100%);
}
.slider::after {
    right: 0;
    transform: rotate(180deg);
}

.slide-track {
    display: flex;
    width: calc(250px * 20); /* Ajuste de acuerdo con el número total de imágenes y su ancho */
    animation: scroll 30s linear infinite; /* Ajuste la duración para que la velocidad de desplazamiento sea la misma */
}

.slide {
    width: 250px; /* Este debería ser el ancho de tu imagen */
    height: 250px; /* Ajusta esto al tamaño que quieras */
    overflow: hidden; /* Esconde cualquier parte de la imagen que sobrepase los límites */
    display: flex; /* Centra la imagen en el contenedor */
    justify-content: center;
    align-items: center;
    flex: 0 0 auto;
    scroll-snap-align: start;
    scroll-padding: 0 10px;
    scroll-margin: 0 10px;
}

.slide img {
    object-fit: cover;
    min-width: 100%;
    min-height: 100%;
    z-index: 1;
}


@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-250px * 10)); } /* Aquí se mueve la totalidad de las imágenes antes de reiniciar */
}

</style>
