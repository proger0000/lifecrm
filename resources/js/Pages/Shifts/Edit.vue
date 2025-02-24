<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

// Встановлюємо, що цей компонент використовує AuthenticatedLayout
definePageMeta({
  layout: AuthenticatedLayout,
})

// Приймаємо пропс "shift" з даними конкретної зміни
const props = defineProps({
  shift: {
    type: Object,
    required: true,
  },
})

// Створюємо форму для редагування зміни, ініціалізовану поточними даними
const form = useForm({
  shift_date: props.shift.shift_date,
  scheduled_start_time: props.shift.scheduled_start_time,
  scheduled_end_time: props.shift.scheduled_end_time,
  // За бажанням можна додати інші поля (наприклад, коментарі)
})

// Метод для надсилання форми (оновлення даних зміни)
function submit() {
  // Використовуємо метод PUT (або POST, залежно від вашого маршруту)
  form.put(route('shifts.update', props.shift.id))
}
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <Head title="Редагувати зміну" />
    <h1 class="text-2xl font-bold text-red-500 mb-6">Редагувати зміну</h1>
    
    <!-- Форма редагування зміни -->
    <form @submit.prevent="submit" class="bg-white p-6 rounded shadow max-w-md mx-auto">
      <div class="mb-4">
        <label for="shift_date" class="block text-gray-700 font-semibold mb-1">Дата зміни</label>
        <input 
          id="shift_date" 
          type="date" 
          v-model="form.shift_date" 
          required 
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" 
        />
      </div>
      <div class="mb-4">
        <label for="scheduled_start_time" class="block text-gray-700 font-semibold mb-1">Плановий початок</label>
        <input 
          id="scheduled_start_time" 
          type="time" 
          v-model="form.scheduled_start_time" 
          required 
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" 
        />
      </div>
      <div class="mb-4">
        <label for="scheduled_end_time" class="block text-gray-700 font-semibold mb-1">Плановий кінець</label>
        <input 
          id="scheduled_end_time" 
          type="time" 
          v-model="form.scheduled_end_time" 
          required 
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500" 
        />
      </div>
      <button 
        type="submit" 
        class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded"
      >
        Зберегти зміни
      </button>
    </form>
  </div>
</template>
