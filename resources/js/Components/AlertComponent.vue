<script setup>
import { ref } from 'vue';
const props = defineProps({
    color: {
        type: String,
    },
    title:{ 
        type: String,
    },
    message:{
        type: String,
    },
    isAlertVisible:{
        type: Boolean,
        default: false,
    },
});

let clickClose = ref(false);

const closeAlert = () =>
{
    clickClose = true;
}

</script>


<template>
    <transition name="fade">
        <div v-if="(props.title && props.message) && props.isAlertVisible && clickClose===false" class="fixed inset-x-0 bottom-0 flex justify-end p-6">
            <div class="text-white px-6 py-4 rounded-lg shadow-md flex items-center justify-between alerta">
                <div class="py-4 px-4 flex items-center justify-center">
                    <i class="fa-solid fa-gamepad fa-xl" style="color: #ffffff;"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">{{ title }}</h3>
                    <p class="mt-2">{{ message }}</p>
                </div>
                <button class="ml-4 text-gray-400 hover:text-gray-500 flex items-center" @click="closeAlert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.alerta{
    z-index: 5 !important;
    background-color: rgba(46, 40, 40,0.50);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}
</style>