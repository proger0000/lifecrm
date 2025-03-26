<template>
    <div class="flex flex-col md:flex-row min-h-screen bg-gray-100">
      <!-- Бокова панель навігації для десктопу -->
      <aside class="w-full md:w-64 bg-primary text-white flex flex-col">
        <!-- Логотип та заголовок -->
        <div class="p-4 flex items-center">
          <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white mr-3">
            <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="12" cy="12" r="10"></circle>
              <circle cx="12" cy="12" r="4"></circle>
              <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
              <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
              <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
              <line x1="9.17" y1="14.83" x2="4.93" y2="19.07"></line>
            </svg>
          </div>
          <h1 class="text-xl font-bold">KLS Cabinet</h1>
        </div>
  
        <!-- Навігаційне меню -->
        <nav class="flex-1 p-4">
          <ul class="space-y-2">
            <!-- Панель керування -->
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
  
            <!-- Зміни -->
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
  
            <!-- Карта постів -->
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
  
            <!-- Профіль -->
            <li>
              <Link :href="route('profile.edit')" 
                    class="flex items-center p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                    :class="{ 'bg-primary-dark': route().current('profile.edit') }">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Профіль</span>
              </Link>
            </li>
          </ul>
        </nav>
  
        <!-- Інформація про користувача та кнопка виходу -->
        <div class="p-4 border-t border-primary-dark">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary mr-3">
              <span class="font-bold">{{ userInitials }}</span>
            </div>
            <div>
              <p class="font-bold">{{ userName }}</p>
              <p class="text-sm opacity-80">{{ userRole }}</p>
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
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  
  // Отримуємо дані користувача з Inertia
  const user = computed(() => usePage().props.auth.user);
  
  // Форматування імені користувача
  const userName = computed(() => {
    return user.value?.name || 'Невідомий';
  });
  
  // Переклад ролі
  const userRole = computed(() => {
    const roles = {
      'admin': 'Адміністратор',
      'operative': 'Оперативний',
      'lifeguard': 'Рятувальник'
    };
    return roles[user.value?.role] || '';
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
  /* Додаткові стилі, якщо потрібно */
  </style>