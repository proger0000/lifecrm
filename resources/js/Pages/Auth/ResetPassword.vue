<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

// Отримуємо токен із URL або з props
const { token, email } = usePage().props.value

const form = useForm({
  token: token,
  email: email || '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post(route('password.store'))
}


</script>

<template>
  <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded">
    <Head title="Скидання пароля" />
    <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Скидання пароля</h1>
    <div v-if="form.errors" class="mb-4 text-red-600">
      <ul>
        <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
      </ul>
    </div>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="email" class="block text-gray-700">Електронна адреса</label>
        <input id="email" type="email" v-model="form.email" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Новий пароль</label>
        <input id="password" type="password" v-model="form.password" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700">Підтвердіть пароль</label>
        <input id="password_confirmation" type="password" v-model="form.password_confirmation" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
        Змінити пароль
      </button>
    </form>
  </div>
</template>
