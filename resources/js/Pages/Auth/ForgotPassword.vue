<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
})

function submit() {
  form.post('/password.email')
}


</script>

<template>
  <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded">
    <Head title="Відновлення пароля" />
    <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Відновлення пароля</h1>
    <p class="mb-4 text-gray-700">
      Введіть свою електронну адресу, щоб отримати посилання для відновлення пароля.
    </p>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="email" class="block text-gray-700">Електронна адреса</label>
        <input id="email" type="email" v-model="form.email" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
        Надіслати посилання
      </button>
    </form>
    <div class="mt-4 text-center">
      <Link href="/login" class="text-red-500 hover:underline">
        Повернутися до входу
      </Link>
    </div>
  </div>
</template>
