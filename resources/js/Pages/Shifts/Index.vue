<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link as InertiaLink } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  // Встановлюємо лейаут, щоб на сторінці відображалася навігація
  layout: AuthenticatedLayout,
  // Приймаємо дані змін з контролера
  props: {
    shifts: {
      type: Array,
      default: () => [],
    },
  },
  computed: {
    // Перевіряємо, чи є зміни
    hasShifts() {
      return this.shifts.length > 0;
    },
  },
}
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Заголовок сторінки -->
    <h1 class="text-3xl font-bold text-red-500 mb-6">Ваші зміни</h1>
    
    <!-- Кнопка для створення нової зміни -->
    <div class="mb-6">
      <inertia-link 
        :href="route('shifts.create')" 
        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded inline-block"
      >
        Створити зміну
      </inertia-link>
    </div>

    <!-- Якщо є зміни, відображаємо таблицю -->
    <div v-if="hasShifts">
      <table class="min-w-full bg-white border text-sm md:text-base">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 border">Дата</th>
            <th class="px-4 py-2 border">План. початок</th>
            <th class="px-4 py-2 border">План. кінець</th>
            <th class="px-4 py-2 border">Чек-ін</th>
            <th class="px-4 py-2 border">Чек-аут</th>
            <th class="px-4 py-2 border">Дії</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="shift in shifts" :key="shift.id">
            <td class="px-4 py-2 border text-center">{{ shift.shift_date }}</td>
            <td class="px-4 py-2 border text-center">{{ shift.scheduled_start_time }}</td>
            <td class="px-4 py-2 border text-center">{{ shift.scheduled_end_time }}</td>
            <td class="px-4 py-2 border text-center">
              {{ shift.check_in_time ? shift.check_in_time : '-' }}
            </td>
            <td class="px-4 py-2 border text-center">
              {{ shift.check_out_time ? shift.check_out_time : '-' }}
            </td>
            <td class="px-4 py-2 border text-center">
              <!-- Кнопка для редагування конкретної зміни -->
              <inertia-link 
                :href="route('shifts.edit', shift.id)" 
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
              >
                Редагувати
              </inertia-link>
              <!-- Можна додати інші кнопки, наприклад, для чек-іну/чек-аут -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Якщо змін немає -->
    <div v-else>
      <p class="text-gray-700">На даний момент у вас немає змін.</p>
    </div>
  </div>
</template>
