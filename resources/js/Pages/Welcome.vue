<script setup>
import { ref, watchEffect } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import CardCheckbox from "@/Components/CardCheckbox.vue";
import Navbar from "@/Components/Navbar.vue";
import AlertComponent from "@/Components/AlertComponent.vue";
import axios from "axios";

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
    juegosIndividual: {
        type: Array,
        default: () => [],
    },
    juegosGrupo: {
        type: Array,
        default: () => [],
    },
    sponsors: {
        type: Array,
        default: () => [],
    },
});

let isAlertVisible = ref(false);
let alertMessage = ref("");

const juegosInscritos = ref(
    JSON.parse(localStorage.getItem("juegosInscritos")) || []
);
const numJuegosSeleccionados = ref(juegosInscritos.value.length);

watchEffect(() => {
    const juegosInscritosLocalStorage =
        JSON.parse(localStorage.getItem("juegosInscritos")) || [];
    juegosInscritos.value = juegosInscritosLocalStorage;
    numJuegosSeleccionados.value = juegosInscritos.value.length;
});

const showAlert = (gameName, gameId) => {
    const juegosInscritos =
        JSON.parse(localStorage.getItem("juegosInscritos")) || [];
    let message = "";

    const index = juegosInscritos.findIndex((juego) => juego.id === gameId);

    if (index > -1) {
        message = `Se agregó el juego ${gameName} al carrito.`;
    } else {
        message = `Se elimino el juego ${gameName} al carrito.`;
    }

    isAlertVisible.value = true;
    alertMessage.value = message;

    setTimeout(() => {
        isAlertVisible.value = false;
        alertMessage.value = "";
    }, 3000);
};

const handleSelectionChange = (selected) => {
    selected ? numJuegosSeleccionados.value++ : numJuegosSeleccionados.value--;
};

const items = [
    {
        position: 0,
        el: document.getElementById("carousel-item-1"),
    },
    {
        position: 1,
        el: document.getElementById("carousel-item-2"),
    },
    {
        position: 2,
        el: document.getElementById("carousel-item-3"),
    },
    {
        position: 3,
        el: document.getElementById("carousel-item-4"),
    },
];

const options = {
    defaultPosition: 1,
    interval: 3000,

    indicators: {
        activeClasses: "bg-white dark:bg-gray-800",
        inactiveClasses:
            "bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800",
        items: [
            {
                position: 0,
                el: document.getElementById("carousel-indicator-1"),
            },
            {
                position: 1,
                el: document.getElementById("carousel-indicator-2"),
            },
            {
                position: 2,
                el: document.getElementById("carousel-indicator-3"),
            },
            {
                position: 3,
                el: document.getElementById("carousel-indicator-4"),
            },
        ],
    },

    // callback functions
    onNext: () => {
        console.log("next slider item is shown");
    },
    onPrev: () => {
        console.log("previous slider item is shown");
    },
    onChange: () => {
        console.log("new slider item has been shown");
    },
};
</script>

<template>
    <Head title="Inicio" />

    <div
        class="fixed top-0 left-0 w-full navbar-container animate__animated animate__fadeInDown"
    >
        <Navbar
            :can-login="canLogin"
            :can-register="canRegister"
            :laravel-version="laravelVersion"
            :php-version="phpVersion"
            :num-juegos-seleccionados="numJuegosSeleccionados"
            :juegos-inscritos="juegosInscritos"
        >
        </Navbar>
    </div>

    <div class="mt-20">
        <div class="">
            <div
                class="most-popular animate__animated animate__fadeIn"
                style="
                    margin-top: 140px;
                    background-image: url('/img/fondoGTA.JPG');
                    width: auto;
                    height: auto;
                    background-size: cover;">
                <div id="slide" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="border-radius: 25px;">
                        <div class="carousel-item active" data-interval="1800">
                            <img
                                src="/img/slide-8.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-2.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-3.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-6.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-5.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-6.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-8.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-9.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                        <div class="carousel-item" data-interval="1800">
                            <img
                                src="/img/slide-10.webp"
                                height="450px"
                                class="d-block w-100 img-fluid"
                                alt="..."
                            />
                        </div>
                    </div>
                    <a
                        class="carousel-control-prev"
                        href="#slide"
                        role="button"
                        data-slide="prev"
                    >
                        <span
                            class="carousel-control-prev-icon"
                            aria-hidden="true"
                        ></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a
                        class="carousel-control-next"
                        href="#slide"
                        role="button"
                        data-slide="next"
                    >
                        <span
                            class="carousel-control-next-icon"
                            aria-hidden="true"
                        ></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div
                class="most-popular"
                style="
                    background-image:  url('/img/fondoInd.jpg'); ;
                    margin-top: 40px;
                    width: auto;
                    height: auto;
                    background-size: cover;
                "
            >
                <h2 class="section-title" >Listado Juegos Individuales</h2>
                <div class="help-text">
                    Selecciona los juegos para añadir a tú carrito...
                </div>
                <div class="card_container">
                    <div v-for="juego in juegosIndividual" :key="juego.id">
                        <div class="flex flex-col items-center mb-4">
                            <CardCheckbox
                                :gameId="juego.id"
                                :gameName="juego.nombre"
                                :gamePrice="juego.costo_inscripcion"
                                :imageUrl="`/img/${juego.img_id}.jpg`"
                                :imageId="`${juego.img_id}`"
                                :estaInscrito="juego.estaInscrito"
                                @selectionChange="handleSelectionChange"
                                @showAlert="showAlert"
                            />
                            <a
                                class="text-light mx-auto inline-flex items-center px-3 py-2 text-sm font-medium text-center hover:text-blue-500 rounded transition-colors duration-200 ease-in-out"
                                :href="`/pdf/${juego.img_id}.pdf`"
                                target="_blank"
                            >
                                <i class="fa-solid fa-book mr-2"></i>Reglamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="most-popular"
                style="
                    background-image:  url('/img/fondoGru.jpg');
                    margin-top: 40px;
                    width: auto;
                    height: auto;
                    background-size: cover;
                "
            >
                <h2 class="section-title">Listado Juegos Grupales</h2>
                <div class="help-text">
                    Selecciona algún juego grupal, únicamente es necesario la
                    inscripción del capitan...
                </div>
                <div class="card_container">
                    <div v-for="juego in juegosGrupo" :key="juego.id">
                        <div class="flex flex-col items-center mb-4">
                            <CardCheckbox
                                :gameId="juego.id"
                                :gameName="juego.nombre"
                                :gamePrice="juego.costo_inscripcion"
                                :imageUrl="`/img/${juego.img_id}.jpg`"
                                :imageId="`${juego.img_id}`"
                                :estaInscrito="juego.estaInscrito"
                                @selectionChange="handleSelectionChange"
                                @showAlert="showAlert"
                            />
                            <a
                                class="text-light mx-auto inline-flex items-center px-3 py-2 text-sm font-medium text-center hover:text-blue-500 rounded transition-colors duration-200 ease-in-out"
                                as="button"
                                :href="`/pdf/${juego.img_id}.pdf`"
                                target="_blank"
                            >
                                <i class="fa-solid fa-book mr-2"></i>Reglamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="most-popular location"
                style="
                    background-color: rgba(87, 61, 66, 0.26);
                    margin-top: 40px;
                "
            >
                <h2 class="section-title">Ubicación del evento</h2>
                <div class="embed-responsive embed-responsive-1by1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2120238453513!2d-78.5886726250348!3d-0.998870298991496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d4639e7c398d3f%3A0xc4999bdc40abfc48!2sUniversidad%20De%20Las%20Fuerzas%20Armadas%20ESPE%20Extensi%C3%B3n%20Belisario%20Quevedo!5e0!3m2!1ses-419!2sec!4v1716325420696!5m2!1ses-419!2sec" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div
                class="most-popular sponsors"
                style="
                    background-color: rgba(87, 61, 66, 0.26);
                    margin-top: 40px;
                "
            >
                <h2 class="section-title">Sponsors del Evento</h2>
                <div class="help-text">
                    Un agradecimiento especial para las personas que confiaron
                    en el proyecto
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 justify-center my-3"
                >
                    <div
                        v-for="sponsor in sponsors"
                        class="flex flex-row items-center justify-center mb-4"
                    >
                        <a :href="sponsor.url_pagina" target="_blank">
                            <div class="sponsor-container">
                                <img
                                    :src="`/img/sponsors/${sponsor.url_imagen}.webp`"
                                    :alt="sponsor.nombre"
                                    class="w-full h-auto"
                                />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer
        class="text-white text-center mt-5"
        style="background-color: rgba(67, 61, 66, 0.86)"
    >
        <div class="container p-4">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Justificaciones</h5>
                    <br />
                    <p>
                        Aquellas personas que se inscriban en cualquiera de los
                        juegos disponibles en el evento, recibirán un
                        certificado que podrán usar para justificar sus faltas
                        en las clases que pierdan a causa del evento.
                    </p>
                </div>

                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Redes sociales</h5>
                    <br />
                    <div class="d-flex justify-content-center">
                        <a
                            href="https://www.instagram.com/gamerfest.ec/"
                            class="text-white mx-2"
                            target="_blank"
                        >
                            <img
                                src="img/instagram.png"
                                class="d-block img-fluid"
                                alt="Instagram Logo"
                                style="max-width: 54px"
                            />
                        </a>
                        <a
                            href="https://www.facebook.com/gamerfest.ec"
                            class="text-white mx-2"
                            target="_blank"
                        >
                            <img
                                src="img/facebook.png"
                                class="d-block img-fluid"
                                alt="Facebook Logo"
                                style="max-width: 54px"
                            />
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <div
                        class="d-flex flex-col justify-content-center align-items-center"
                    >
                        <h5 class="text-uppercase">Creado por</h5>
                        <br />
                        <a
                            href="https://espe-el.espe.edu.ec/ingenieria-en-software/"
                            class="text-white mx-2"
                            target="_blank"
                        >
                            <img
                                src="img/software-logo.png"
                                class="logo"
                                alt="Software Logo"
                                style="max-width: 360px"
                            />
                        </a>
                        <div class="creators list-none">
                            <div>
                                <a
                                    href="https://tellxmaster.world/"
                                    target="_blank"
                                    class="text-current no-underline link-hover"
                                    ><span>tellxmaster</span>
                                    <i class="fa-solid fa-dragon"></i
                                ></a>
                            </div>
                            |
                            <div>
                                <a
                                    href="https://github.com/joalasco"
                                    target="_blank"
                                    class="text-current no-underline link-hover"
                                    ><span>joalasco</span>
                                    <i class="fa-solid fa-khanda"></i
                                ></a>
                            </div>
                            |
                            <div>
                                <a
                                    href="https://github.com/DavidClaudio03"
                                    target="_blank"
                                    class="text-current no-underline link-hover"
                                    ><span>DavidClaudio03</span>
                                    <i class="fab fa-github"></i
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: black">
            © 2024 Copyright:
            <a class="text-white">GamerFest</a>
        </div>
    </footer>

    <AlertComponent
        :color="'#4E9F3D'"
        :isAlertVisible="isAlertVisible"
        :title="'Nuevo Juego'"
        :message="alertMessage"
    />
</template>

<style>
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

.logo {
    display: block;
    margin-left: auto;
    margin-right: auto;
    border-radius: 0.5rem; /* Ajusta según sea necesario */
    filter: brightness(1.2);
    transition: all 200ms ease-in-out;
}

.creators {
    display: flex;
}

.creators a {
    display: flex;
    padding: 0 1em;
    transition: all 200ms ease-in-out;
}

.creators i {
    padding-left: 0.25em;
    transform: translateY(4px);
}

.creators a:hover {
    color: #fff !important;
    text-decoration: none;
    text-shadow: 0.05em 0.05em 1em #fff;
    transition: all 200ms ease-in;
}

.logo:hover {
    filter: brightness(1.2) drop-shadow(0.05em 0.05em 1em #fff);
    transition: all 200ms ease-in;
}

.embed-responsive {
    position: relative;
    width: 100%;

    height: 450px;
    max-height: 450px;
}

.embed-responsive iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 450px;
    max-height: 450px;
    border-radius: 23px;
}

.most-popular.location {
    height: 600px;
    max-height: 600px;
}

.sponsor-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    border-radius: 23px;
    width: 230px;
    height: 230px;
    padding: 1.2em;
    margin: 0.5em;
    overflow: hidden;
    transition: color 200ms ease-in, box-shadow 200ms ease-in,
        border 200ms ease-in;
}

.sponsor-container:hover {
    color: #fff !important;
    text-decoration: none;
    box-shadow: 0.1em 0.1em 1em #fff;
}

.sponsor-container img {
    transition: all 200ms ease-in;
}

.sponsor-container:hover img {
    transform: scale(1.2);
}

.card_container {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 20px;
}

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
        text-shadow: 2px 2px 0px #2c2c2c, 3px 3px 0px #ef5097,
            4px 4px 0px #6868ac;
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
    color: #db005b;
    border: none;
}
</style>
