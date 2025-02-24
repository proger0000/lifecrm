<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

// Можна імпортувати додаткові змінні, функції, компоненти
// Тут, наприклад, імпортуємо щось для демонстрації
// import SomeComponent from '@/Components/SomeComponent.vue'
</script>

<template>
  <authenticated-layout>
    <Head title="Dashboard" />

    <div class="container mx-auto px-4 py-6">
      <h1 class="text-3xl font-bold text-red-500 mb-4">Dashboard</h1>
      <p>Основний контент панелі керування.</p>
    </div>
  </authenticated-layout>
</template>
