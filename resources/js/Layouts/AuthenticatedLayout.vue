<template>
    <div class="min-h-screen flex flex-col md:flex-row bg-gray-100">
      <!-- Бокове меню для десктопу (від md) -->
      <aside class="hidden md:flex md:flex-col w-64 bg-red-500 text-white py-6 px-4">
        <!-- Логотип та назва -->
        <div class="flex items-center mb-8">
          <!-- Рятівне коло (SVG) -->
          <svg
            class="h-8 w-8 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="4"></circle>
            <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
            <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
            <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
            <line x1="9.17" y1="14.83" x2="4.93" y2="19.07"></line>
          </svg>
          <h1 class="text-xl font-bold">KLS Cabinet</h1>
        </div>
  
        <!-- Навігаційне меню залежно від ролі -->
        <nav class="flex-1 space-y-3">
          <!-- Для адміністраторів -->
          <template v-if="isAdmin">
            <inertia-link
              :href="route('dashboard')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M3 12l9-9 9 9"></path>
                <path d="M9 21V9h6v12"></path>
              </svg>
              <span>Адмін панель</span>
            </inertia-link>
  
            <inertia-link
              :href="route('shifts.index')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>Зміни</span>
            </inertia-link>
  
            <inertia-link
              :href="route('posts.map')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <polygon points="1 6 8 3 16 6 23 4 23 17 16 20 8 17 1 20"></polygon>
                <line x1="8" y1="3" x2="8" y2="17"></line>
              </svg>
              <span>Мапа постів</span>
            </inertia-link>
  
            <inertia-link
              :href="route('admin.users.index')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M17 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M7 21v-2a4 4 0 013-3.87"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>Керування користувачами</span>
            </inertia-link>
          </template>
  
          <!-- Для оперативних -->
          <template v-else-if="isOperative">
            <inertia-link
              :href="route('dashboard')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M3 12l9-9 9 9"></path>
                <path d="M9 21V9h6v12"></path>
              </svg>
              <span>Панель</span>
            </inertia-link>
  
            <inertia-link
              :href="route('shifts.index')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>Зміни</span>
            </inertia-link>
  
            <inertia-link
              :href="route('posts.map')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <polygon points="1 6 8 3 16 6 23 4 23 17 16 20 8 17 1 20"></polygon>
                <line x1="8" y1="3" x2="8" y2="17"></line>
              </svg>
              <span>Мапа постів</span>
            </inertia-link>
          </template>
  
          <!-- Для рятувальників (lifeguard) -->
          <template v-else-if="isLifeguard">
            <inertia-link
              :href="route('lifeguard.dashboard')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>Зміни</span>
            </inertia-link>
  
            <inertia-link
              :href="route('profile.edit')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M20 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M4 21v-2a4 4 0 013-3.87"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>Персональний профіль</span>
            </inertia-link>
  
            <inertia-link
              :href="route('posts.map')"
              class="flex items-center px-3 py-2 rounded hover:bg-red-600"
            >
              <svg
                class="h-5 w-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <polygon points="1 6 8 3 16 6 23 4 23 17 16 20 8 17 1 20"></polygon>
                <line x1="8" y1="3" x2="8" y2="17"></line>
              </svg>
              <span>Мапа постів</span>
            </inertia-link>
          </template>
        </nav>
  
        <!-- Нижня частина бокового меню для десктопу: дані користувача та кнопка "Вийти" -->
        <div class="mt-auto border-t border-red-600 pt-4">
          <div class="mb-3 px-3">
            <div class="text-sm font-semibold">{{ userName }}</div>
            <div class="text-xs text-gray-200">{{ userRole }}</div>
          </div>
          <button @click="logout" class="flex items-center px-3 py-2 rounded hover:bg-red-600 w-full">
            <svg
              class="h-5 w-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path d="M10 15l5-5-5-5M19 20v-2a4 4 0 00-4-4H5"></path>
            </svg>
            Вийти
          </button>
        </div>
      </aside>
  
      <!-- Основний контент (праворуч на десктопі, повноекранний на мобільних) -->
      <div class="flex-1 flex flex-col min-h-screen">
        <main class="flex-1 p-4">
          <slot />
        </main>
  
        <!-- Нижня панель навігації для мобільних -->
        <nav class="md:hidden bg-red-500 text-white flex justify-around items-center h-16">
          <inertia-link :href="route('dashboard')" class="flex flex-col items-center focus:outline-none">
            <svg
              class="h-6 w-6 mb-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path d="M3 12l9-9 9 9"></path>
              <path d="M9 21V9h6v12"></path>
            </svg>
            <span class="text-xs">Панель</span>
          </inertia-link>
          <inertia-link :href="route('shifts.index')" class="flex flex-col items-center focus:outline-none">
            <svg
              class="h-6 w-6 mb-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="text-xs">Зміни</span>
          </inertia-link>
          <inertia-link :href="route('posts.map')" class="flex flex-col items-center focus:outline-none">
            <svg
              class="h-6 w-6 mb-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <polygon points="1 6 8 3 16 6 23 4 23 17 16 20 8 17 1 20"></polygon>
              <line x1="8" y1="3" x2="8" y2="17"></line>
            </svg>
            <span class="text-xs">Мапа</span>
          </inertia-link>
          <button @click="logout" class="flex flex-col items-center focus:outline-none">
            <svg
              class="h-6 w-6 mb-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path d="M10 15l5-5-5-5M19 20v-2a4 4 0 00-4-4H5"></path>
            </svg>
            <span class="text-xs">Вийти</span>
          </button>
        </nav>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Inertia } from '@inertiajs/inertia'
  import { route } from 'ziggy-js'
  import { computed } from 'vue'
  
  function logout() {
    Inertia.post(route('logout'))
  }
  
  const user = computed(() => window?.Inertia?.page?.props?.auth?.user || {})
  
  const isAdmin = computed(() => user.value.role === 'admin')
  const isOperative = computed(() => user.value.role === 'operative')
  const isLifeguard = computed(() => user.value.role === 'lifeguard')
  
  const userName = computed(() => user.value.name || 'Невідомий')
  const userRole = computed(() => {
    const r = user.value.role || ''
    return r.charAt(0).toUpperCase() + r.slice(1)
  })
  </script>
  