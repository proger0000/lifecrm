<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

// Визначаємо прийняті пропси (можуть використовуватись, якщо потрібно)
defineProps({
  canLogin: {
    type: Boolean,
    default: false,
  },
  canRegister: {
    type: Boolean,
    default: false,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <guest-layout>
    <!-- Мета-тег, якщо хочете встановити заголовок сторінки -->
    <Head title="KLS Cabinet" />

    <div class="text-center">
      <h1 class="text-4xl font-bold text-red-500 mb-4">
        Ласкаво просимо до KLS Cabinet
      </h1>
      <p class="text-gray-700">
        Це персональний помічник для рятувальників.
      </p>
      <div class="mt-6">
        <!-- Посилання на сторінку входу -->
        <Link href="/login" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mr-2">
          Увійти
        </Link>
        <!-- Посилання на сторінку реєстрації -->
        <Link href="/register" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
          Зареєструватися
        </Link>
      </div>
    </div>
  </guest-layout>
</template>
