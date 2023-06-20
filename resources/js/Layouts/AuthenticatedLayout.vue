<script setup>
import { ref, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(window.innerWidth > 768);

const handleResize = () => {
    sidebarOpen.value = window.innerWidth > 768;
};

window.addEventListener('resize', handleResize);

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>

<template>
    <div class="min-h-screen bg-gray-900 flex">
        <!-- Sidebar -->
        <div :class="{ 'w-64': sidebarOpen, 'w-0': !sidebarOpen }"
            class="fixed overflow-auto h-screen transition-all duration-500 sidebar z-50">
    
            <div class="px-6 py-4">
                <div class="shrink-0 flex items-center justify-center h-full">
                    <Link :href="route('dashboard')">
                    <ApplicationLogo class="block h-20 w-auto fill-current text-gray-100 fa-beat-fade" />
                    </Link>
                </div>
            </div>
            <nav class="px-6 space-y-2">
                <Link v-if="$page.props.auth.user && $page.props.role" :href="route('dashboard')"
                    :active="route().current('dashboard')" class="flex items-center text-white justify-center sidebar-item">
                <i class="fas fa-chart-bar mr-2"></i>
                <span>Dashboard</span>
                </Link>
                <Link v-if="$page.props.auth.user && $page.props.role" :href="route('dashboard')"
                    :active="route().current('dashboard')" class="flex items-center text-white justify-center sidebar-item">
                <i class="fas fa-chart-bar mr-2"></i>
                <span>Sponsors</span>
                </Link>
                <Link v-if="$page.props.auth.user && $page.props.role" :href="route('participantes')"
                    :active="route().current('participantes')"
                    class="flex items-center text-white justify-center sidebar-item">
                <i class="fas fa-users mr-2"></i>
                <span>Participantes</span>
                </Link>
                <Link v-if="$page.props.auth.user" :href="route('profile.edit')" :active="route().current('profile.edit')"
                    class="flex items-center text-white justify-center sidebar-item">
                <i class="fas fa-users mr-2"></i>
                <span>Perfil</span>
                </Link>
                <Link v-if="$page.props.auth.user" :href="route('inscripciones')" :active="route().current('inscripciones')"
                    class="flex items-center text-white justify-center sidebar-item">
                <i class="fas fa-users mr-2"></i>
                <span>Mis Inscripciones</span>
                </Link>
                <Link v-if="$page.props.auth.user" :href="route('mis_equipos')" :active="route().current('mis_equipos')"
                    class="flex items-center text-white justify-center sidebar-item">
                <i class="fa-solid fa-khanda mr-2"></i>
                <span>Mis Equipos</span>
                </Link>
                <a v-if="$page.props.auth.user" href="/pdf/horarios_gamerfest.pdf" target="_blank" class="flex items-center text-white justify-center sidebar-item" as="button">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Horarios</span>
                </a>
            </nav>
        </div>
        <!-- End of Sidebar -->

        <!-- Rest of the application -->
        <div :class="{ 'pl-64': sidebarOpen, 'pl-0': !sidebarOpen }" class="w-full transition-all duration-500">
            <nav class=" border-b border-purple-700 sidebar">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="flex justify-between h-16">
                        <div class="flex justify-between" style="width: 100%;">
                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center">
                                <button @click="sidebarOpen = !sidebarOpen"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-purple-700 focus:outline-none focus:bg-purple-700 focus:text-gray-300 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-bars fa-fade" style="color: #ffffff;"></i>
                                </button>
                            </div>

                            <!-- Profile Dropdown -->
                            <div class="sm:hidden py-3" style="transform: translateX(10px);">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-purple-700 hover:text-gray-100 hover:bg-purple-600 focus:outline-none transition ease-in-out duration-150">
                                                <!-- Adjusted Font Awesome Icon in the button -->
                                                <i class="fas fa-user fa-md p-1"></i>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- User name moved to dropdown content -->
                                        <DropdownLink :href="route('profile.edit')">{{ $page.props.auth.user.name }}
                                        </DropdownLink>
                                        <!-- Add new dropdown item -->
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Salir
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>


                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1  text-sm leading-4 font-medium rounded-md text-gray-200 hover:text-gray-100  focus:outline-none transition ease-in-out duration-150" style="width: 230px; text-align: right;">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Salir
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>


                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-gray-300 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="bg-white">
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
.sidebar {
    z-index: 2;
    background: linear-gradient(-45deg, #6a057f, #8b008b, #483d8b);
    background-size: 500% 500%;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}

.sidebar-item:hover {
    text-decoration: none;
    color: #F6FA70 !important;
    text-shadow: 2px 2px #000000;
    cursor: pointer;
    background-color: #424242;
    transform: scale(1.20);
    animation: transform 300ms ease-in;
    animation: background-image 200ms ease-in;
}


.sidebar-item {
    font-size: 15px;
    padding: 1em 0;
    transform: scale(0);
    animation: transform 300ms ease-in;
    transform: skew(0deg) scale(1.15);
    animation: all 200ms ease-in-out;
}

.sidebar-item.active {
    background-color: #6f04a1;
    animation: all 200ms ease-in-out;
}
</style>