<script setup>
import { onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useForm } from '@inertiajs/vue3'

// Встановлюємо, що сторінка використовує AuthenticatedLayout
definePageMeta({
  layout: AuthenticatedLayout,
})

// Приймаємо пропс "shift" з даними зміни
const props = defineProps({
  shift: {
    type: Object,
    default: () => ({}),
  },
})

// Створюємо форму, ініціалізовану даними зміни
const form = useForm({
  visitors: props.shift.visitors || '',
  incidents: props.shift.incidents || '',
  first_aid: props.shift.first_aid || '',
  violations: props.shift.violations || '',
})

// Метод для надсилання форми (відправляємо дані на маршрут звітування)
function submit() {
  form.post(route('lifeguard.report.store', props.shift.id))
}

onMounted(() => {
  // За потреби можна додати додаткову логіку після монтування
})
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <Head title="Звіт за зміну" />
    <h1 class="text-2xl font-bold text-red-500 mb-4">Заповнити звіт за зміну</h1>
    <form @submit.prevent="submit" class="bg-white p-4 shadow rounded max-w-md">
      <div class="mb-4">
        <label for="visitors" class="block text-gray-700 font-semibold mb-1">Кількість відвідувачів</label>
        <input id="visitors" type="number" v-model="form.visitors" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" />
      </div>
      <div class="mb-4">
        <label for="incidents" class="block text-gray-700 font-semibold mb-1">Інциденти</label>
        <input id="incidents" type="number" v-model="form.incidents" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" />
      </div>
      <div class="mb-4">
        <label for="first_aid" class="block text-gray-700 font-semibold mb-1">Надана перша допомога</label>
        <input id="first_aid" type="number" v-model="form.first_aid" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" />
      </div>
      <div class="mb-4">
        <label for="violations" class="block text-gray-700 font-semibold mb-1">Порушення</label>
        <input id="violations" type="number" v-model="form.violations" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" />
      </div>
      <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded">
        Зберегти звіт
      </button>
    </form>
  </div>
</template>
