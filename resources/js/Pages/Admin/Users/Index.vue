<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link as InertiaLink } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  // Підключаємо AuthenticatedLayout, щоб бачити панель навігації
  layout: AuthenticatedLayout,

  // Оголошуємо, що будемо використовувати InertiaLink у шаблоні
  components: {
    InertiaLink,
  },

  // Пропси, які отримуємо з контролера (нові заявки, схвалені користувачі)
  props: {
    newUsers: {
      type: Array,
      default: () => [],
    },
    approvedUsers: {
      type: Array,
      default: () => [],
    },
  },

  computed: {
    // Перевіряємо, чи є нові заявки
    hasNewUsers() {
      return this.newUsers.length > 0
    },
    // Перевіряємо, чи є схвалені користувачі
    hasApprovedUsers() {
      return this.approvedUsers.length > 0
    },
  },
}
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Заголовок сторінки -->
    <h1 class="text-2xl font-bold mb-6">Управління користувачами</h1>

    <!-- Секція нових заявок -->
    <h2 class="text-xl font-semibold mb-4">Нові заявки</h2>
    <!-- Якщо немає нових заявок -->
    <div v-if="!hasNewUsers">
      <p class="text-gray-700">Немає нових заявок.</p>
    </div>
    <!-- Якщо є нові заявки -->
    <div v-else>
      <table class="min-w-full bg-white border mb-8 text-sm md:text-base">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Ім'я</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Роль</th>
            <th class="px-4 py-2 border">Дії</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in newUsers" :key="user.id">
            <td class="px-4 py-2 border text-center">{{ user.id }}</td>
            <td class="px-4 py-2 border">{{ user.name }}</td>
            <td class="px-4 py-2 border">{{ user.email }}</td>
            <td class="px-4 py-2 border">
              <span class="text-gray-600">
                {{ user.role ? user.role : 'Не призначена' }}
              </span>
            </td>
            <td class="px-4 py-2 border text-center">
              <!-- Кнопка "Редагувати" -->
              <inertia-link
                :href="route('admin.users.edit', user.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
              >
                Редагувати
              </inertia-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Секція схвалених користувачів -->
    <h2 class="text-xl font-semibold mb-4">Зареєстровані користувачі</h2>
    <!-- Якщо немає схвалених користувачів -->
    <div v-if="!hasApprovedUsers">
      <p class="text-gray-700">Немає зареєстрованих користувачів.</p>
    </div>
    <!-- Якщо є схвалені користувачі -->
    <div v-else>
      <table class="min-w-full bg-white border text-sm md:text-base">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Ім'я</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Роль</th>
            <th class="px-4 py-2 border">Дії</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in approvedUsers" :key="user.id">
            <td class="px-4 py-2 border text-center">{{ user.id }}</td>
            <td class="px-4 py-2 border">{{ user.name }}</td>
            <td class="px-4 py-2 border">{{ user.email }}</td>
            <td class="px-4 py-2 border capitalize">{{ user.role }}</td>
            <td class="px-4 py-2 border text-center">
              <inertia-link
                :href="route('admin.users.edit', user.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
              >
                Редагувати
              </inertia-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
