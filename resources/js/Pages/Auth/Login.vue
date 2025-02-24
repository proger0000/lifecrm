<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post('/login')
}


</script>

<template>
  <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded">
    <Head title="Увійти" />
    <h1 class="text-2xl font-bold text-center text-red-500 mb-4">Увійти</h1>
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
        <label for="password" class="block text-gray-700">Пароль</label>
        <input id="password" type="password" v-model="form.password" required
          class="mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500"/>
      </div>
      <div class="mb-4 flex items-center">
        <input id="remember" type="checkbox" v-model="form.remember"
          class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-500 focus:ring-red-500"/>
        <label for="remember" class="ml-2 text-sm text-gray-700">Запам'ятати мене</label>
      </div>
      <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
        Увійти
      </button>
    </form>
    <div class="mt-4 text-center text-sm">
      <Link href="/forgot-password" class="text-red-500 hover:underline">
        Забули пароль?
      </Link>
      <span class="mx-2">|</span>
      <Link href="/register" class="text-red-500 hover:underline">
        Зареєструватися
      </Link>
    </div>
  </div>
</template>
