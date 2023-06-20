<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
  role: {
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
  inscripciones_data: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="custom-width p-6 text-gray-900">

            <!-- Responsive cards -->
            <h4 class="mb-4 text-lg font-semibold text-gray-600 ">
              Datos Inscripciones
            </h4>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div class="flex items-center p-4 bg-gray-200 rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-purple-600 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-base font-bold text-gray-700 font-bold">
                    Incripciones Totales
                  </p>
                  <p class="text-lg font-semibold text-cyan-600">
                    {{ inscripciones_data.numero_inscripciones_totales }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-gray-200 rounded-lg shadow-xs">
                <div
                  class="p-3 mr-4 text-magenta-600 bg-magenta-100 rounded-full dark:text-magenta-100 dark:bg-magenta-500">
                  <div class="card-icon">
                    <i class="fa-solid fa-money-bill-1-wave fa-lg" style="color: #4d8c36;"></i>
                  </div>
                </div>
                <div>
                  <p class="mb-2 text-base font-bold text-gray-700">
                    Ingresos Generados
                  </p>
                  <p class="text-lg font-semibold text-cyan-600">
                    ${{ parseFloat(inscripciones_data.ingresos_totales).toFixed(2) }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-gray-200 rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-blue-600 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                    </path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-base font-bold text-gray-700 font-bold">
                    Inscripciones Individuales
                  </p>
                  <p class="text-lg font-semibold text-cyan-600">
                    {{ inscripciones_data.numero_inscripciones_individuales }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-gray-200 rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-teal-600 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-base font-bold text-gray-700 font-bold">
                    Inscripciones Grupales
                  </p>
                  <p class="text-lg font-semibold text-cyan-600">
                    {{ inscripciones_data.numero_inscripciones_grupales }}
                  </p>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.custom-width {
    min-height: calc(80vh - 60px);
    height: calc(100vh - 60px);
}
</style>
