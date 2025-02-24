<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Використовуємо AuthenticatedLayout для відображення навігації
definePageMeta({
  layout: AuthenticatedLayout,
})
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Заголовок сторінки встановлюється через Head -->
    <Head title="Особистий кабінет рятувальника" />
    <h1 class="text-3xl font-bold text-red-500 mb-4">Особистий кабінет рятувальника</h1>
    <p class="text-gray-700 mb-6">
      Ласкаво просимо! Тут ви можете переглядати свої зміни, заповнювати звіти та стежити за своїми результатами.
    </p>

    <!-- Перевірка, чи передано список змін -->
    <div v-if="$page.props.shifts && $page.props.shifts.length">
      <table class="min-w-full bg-white border mb-8 text-sm md:text-base">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 border">Дата зміни</th>
            <th class="px-4 py-2 border">Початок</th>
            <th class="px-4 py-2 border">Кінець</th>
            <th class="px-4 py-2 border">Звіт</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="shift in $page.props.shifts" :key="shift.id">
            <td class="px-4 py-2 border text-center">{{ shift.shift_date }}</td>
            <td class="px-4 py-2 border text-center">{{ shift.scheduled_start_time }}</td>
            <td class="px-4 py-2 border text-center">{{ shift.scheduled_end_time }}</td>
            <td class="px-4 py-2 border text-center">
              <!-- Якщо звіт заповнено, показуємо "Переглянути звіт", інакше "Заповнити звіт" -->
              <inertia-link
                :href="route('lifeguard.report', shift.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
              >
                {{ shift.visitors ? 'Переглянути звіт' : 'Заповнити звіт' }}
              </inertia-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Якщо змін немає -->
    <div v-else>
      <p class="text-gray-700">Наразі у вас немає змін.</p>
    </div>
  </div>
</template>
