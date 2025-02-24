<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { route } from 'ziggy-js'

export default {
  // Використовуємо AuthenticatedLayout для панелі навігації
  layout: AuthenticatedLayout,

  // Приймаємо користувача з контролера
  props: {
    user: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      // Створюємо форму з початковими даними користувача
      form: {
        name: this.user.name || '',
        email: this.user.email || '',
        role: this.user.role || 'lifeguard',
      },
      // Помилки з сервера (валідації)
      errors: {},
    }
  },

  methods: {
    // Метод submit відправляє POST-запит на маршрут оновлення користувача
    submit() {
      this.$inertia.post(
        route('admin.users.update', this.user.id), // Якщо Ziggy, інакше /admin/users/${user.id}/update
        this.form,
        {
          onError: (errors) => {
            this.errors = errors
          },
          onSuccess: () => {
            // За потреби можна додати повідомлення або редирект
          },
        }
      )
    },
  },
}
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Редагувати користувача</h1>

    <!-- Якщо є помилки валідації -->
    <div v-if="Object.keys(errors).length" class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      <ul>
        <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
      </ul>
    </div>

    <!-- Форма редагування -->
    <form @submit.prevent="submit" class="bg-white p-4 shadow rounded max-w-md">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold mb-1">Ім'я</label>
        <input
          id="name"
          type="text"
          v-model="form.name"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500"
        />
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500"
        />
      </div>

      <div class="mb-4">
        <label for="role" class="block text-gray-700 font-semibold mb-1">Роль</label>
        <select
          id="role"
          v-model="form.role"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-red-500"
        >
          <option value="lifeguard">Лайфгард</option>
          <option value="operative">Оперативний</option>
          <option value="admin">Адміністратор</option>
        </select>
      </div>

      <div class="text-right">
        <button
          type="submit"
          class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
        >
          Зберегти
        </button>
      </div>
    </form>
  </div>
</template>
