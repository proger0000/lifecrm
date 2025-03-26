<template>
  <div class="min-h-screen flex flex-col md:flex-row">
    <!-- Бокова панель навігації для десктопу -->
    <aside class="w-full md:w-64 bg-primary text-white flex flex-col">
      <!-- Логотип та заголовок -->
      <div class="p-4 flex items-center">
        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white mr-3">
          <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="4"></circle>
          </svg>
        </div>
        <h1 class="text-xl font-bold">KLS Cabinet</h1>
      </div>

      <!-- Навігаційне меню залежно від ролі -->
      <nav class="flex-1 p-4">
        <ul class="space-y-2">
          <!-- Панель керування (для всіх) -->
          <li>
            <Link :href="route('dashboard')" 
                  class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                  :class="{ 'bg-primary-dark': route().current('dashboard') }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              <span>Панель керування</span>
            </Link>
          </li>

          <!-- Зміни (для всіх) -->
          <li>
            <Link :href="route('shifts.index')" 
                  class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                  :class="{ 'bg-primary-dark': route().current('shifts.index') }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span>Зміни</span>
            </Link>
          </li>

          <!-- Карта постів (для всіх) -->
          <li>
            <Link :href="route('posts.map')" 
                  class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                  :class="{ 'bg-primary-dark': route().current('posts.map') }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
              </svg>
              <span>Карта постів</span>
            </Link>
          </li>

          <!-- Розділи специфічні для адміністратора -->
          <template v-if="isAdmin">
            <li>
              <Link :href="route('admin.users.index')" 
                    class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                    :class="{ 'bg-primary-dark': route().current('admin.users.index') }">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Керування користувачами</span>
              </Link>
            </li>
          </template>

          <!-- Розділи специфічні для оперативного -->
          <template v-if="isOperative">
            <li>
              <Link :href="route('shifts.create')" 
                    class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                    :class="{ 'bg-primary-dark': route().current('shifts.create') }">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Створити зміну</span>
              </Link>
            </li>
          </template>

          <!-- Особистий кабінет для лайфгарда -->
          <template v-if="isLifeguard">
            <li>
              <Link :href="route('lifeguard.dashboard')" 
                    class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                    :class="{ 'bg-primary-dark': route().current('lifeguard.dashboard') }">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Особистий кабінет</span>
              </Link>
            </li>
          </template>
        </ul>
      </nav>

      <!-- Інформація про користувача та кнопка виходу -->
      <div class="p-4 border-t border-primary-dark mt-auto">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary mr-3">
            <span class="font-bold">{{ userInitials }}</span>
          </div>
          <div>
            <p class="font-bold">{{ userName }}</p>
            <p class="text-sm opacity-80">{{ userRoleDisplay }}</p>
          </div>
        </div>
        <button @click="logout" class="w-full flex items-center justify-center p-2 rounded-lg bg-primary-dark hover:bg-opacity-80 transition-colors">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
          <span>Вийти</span>
        </button>
      </div>
    </aside>

    <!-- Основний контент -->
    <main class="flex-1">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth.user);

// Ім'я користувача
const userName = computed(() => {
  console.log('User data:', user.value); // Для діагностики
  return user.value?.name || 'Невідомий';
});

// Роль користувача для відображення
const userRoleDisplay = computed(() => {
  const roleMap = {
    '1': 'Адміністратор',
    '2': 'Оперативний',
    '3': 'Рятувальник',
    'admin': 'Адміністратор',
    'operative': 'Оперативний',
    'lifeguard': 'Рятувальник'
  };
  
  const role = user.value?.role;
  return roleMap[role] || 'Користувач';
});

// Перевірка ролей користувача
const isAdmin = computed(() => {
  const role = user.value?.role;
  return role === 'admin' || role === 1;
});

const isOperative = computed(() => {
  const role = user.value?.role;
  return role === 'operative' || role === 2;
});

const isLifeguard = computed(() => {
  const role = user.value?.role;
  return role === 'lifeguard' || role === 3;
});

// Ініціали для аватара
const userInitials = computed(() => {
  if (!user.value?.name) return '?';
  
  const parts = user.value.name.split(' ');
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return parts[0][0].toUpperCase();
});

// Функція для виходу
const logout = () => {
  Inertia.post(route('logout'));
};
</script>

<style scoped>
.bg-primary {
  background-color: #f44336;
}
.bg-primary-dark {
  background-color: #d32f2f;
}
.text-primary {
  color: #f44336;
}
</style>