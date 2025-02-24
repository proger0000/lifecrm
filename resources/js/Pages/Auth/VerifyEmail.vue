<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

function resendVerification() {
  Inertia.post(route('verification.send'))
}


</script>

<template>
  <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-md rounded text-center">
    <Head title="Перевірка електронної адреси" />
    <h1 class="text-2xl font-bold text-red-500 mb-4">Перевірте свою електронну адресу</h1>
    <p class="mb-4 text-gray-700">
      На вашу електронну адресу надіслано посилання для підтвердження. Якщо ви не отримали листа, натисніть кнопку нижче.
    </p>
    <button @click="resendVerification" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
      Надіслати лист повторно
    </button>
    <div class="mt-4 text-sm">
      <Link href="/dashboard" class="text-red-500 hover:underline">
        Повернутися до панелі керування
      </Link>
    </div>
  </div>
</template>
