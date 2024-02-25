<script setup>
import { ref, watch } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    recaptcha: '',
});

watch(() => form.name, (val) => {
  const hasSpecialCharacters = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi.test(val);

  if (!val || val.trim().split(' ').length < 2 || hasSpecialCharacters) {
    form.errors.name = 'Debes ingresar tu nombre y apellido sin caracteres especiales';
  } else {
    form.errors.name = null;
  }
});

const recaptchaToken = ref(null);

const submit = () => {
    grecaptcha.ready(() => {
    grecaptcha.execute('6LfoaJ4mAAAAAMF5GJVoCoEh6RjlO1muGhS4b0hG', {action: 'submit'}).then((token) => {
        recaptchaToken.value = token;
        form.recaptcha = recaptchaToken.value;
        form.post(route('register'), {
            name: form.name,
            email: form.email,
            phone: form.phone,
            password: form.password,
            password_confirmation: form.password_confirmation,
         //   recaptcha: recaptchaToken.value,
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    });
});

};

</script>

<template>
    <GuestLayout>
        <Head title="Registro" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre y Apellido" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Correo Electrónico" />

                <TextInput
                    id="email"
                    type="text"
                    max="10"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Telf. Celular" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>


            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    ¿Ya tienes cuenta, ingresa?
                </Link>

                <PrimaryButton class="ml-4 btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <span>Registrar</span>
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
