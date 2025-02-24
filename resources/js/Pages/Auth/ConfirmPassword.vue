<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  password: '',
})

function submit() {
  form.post(route('password.confirm'))
}


</script>

<template>
  <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded">
    <Head title="Підтвердження пароля" />
    <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Підтвердіть свій пароль</h1>
    <p class="mb-4 text-gray-700">
      Для продовження, будь ласка, підтвердіть свій пароль.
    </p>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Пароль</label>
        <input id="password" type="password" v-model="form.password" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
        Підтвердити
      </button>
    </form>
    <div class="mt-4 text-center">
      <Link href="{{ route('dashboard') }}" class="text-red-500 hover:underline">
        Повернутися до панелі керування
      </Link>
    </div>
  </div>
</template>
