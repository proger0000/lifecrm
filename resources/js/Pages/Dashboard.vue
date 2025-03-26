<template>
  <Head title="Панель керування" />
  
  <div class="min-h-screen bg-gray-50">
    <!-- Бокова панель навігації -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-red-500 text-white overflow-y-auto">
      <div class="p-4 flex items-center">
        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white text-red-500 mr-3">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="4"></circle>
          </svg>
        </div>
        <h1 class="text-xl font-bold">KLS Cabinet</h1>
      </div>
      
      <nav class="mt-6 px-4">
        <Link :href="route('dashboard')" class="flex items-center p-3 mb-2 rounded-lg bg-red-600 text-white">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span>Панель керування</span>
        </Link>
        
        <Link :href="route('shifts.index')" class="flex items-center p-3 mb-2 rounded-lg hover:bg-red-600 text-white">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <span>Зміни</span>
        </Link>
        
        <Link :href="route('posts.map')" class="flex items-center p-3 mb-2 rounded-lg hover:bg-red-600 text-white">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span>Карта постів</span>
        </Link>
        
        <Link :href="route('lifeguard.dashboard')" v-if="isLifeguard" class="flex items-center p-3 mb-2 rounded-lg hover:bg-red-600 text-white">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span>Особистий кабінет</span>
        </Link>
        
        <Link :href="route('admin.users.index')" v-if="isAdmin" class="flex items-center p-3 mb-2 rounded-lg hover:bg-red-600 text-white">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <span>Керування користувачами</span>
        </Link>
      </nav>
      
      <div class="mt-auto p-4 border-t border-red-600">
        <div class="flex items-center mb-4">
          <div v-if="user" class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-500 mr-3">
              <span class="font-bold uppercase">{{ userInitials }}</span>
            </div>
            <div>
              <div class="font-bold">{{ user.name || 'Користувач' }}</div>
              <div class="text-sm text-red-200">{{ userRoleText }}</div>
            </div>
          </div>
        </div>
        
        <button @click="logout" class="w-full flex items-center justify-center p-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">
          <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
          <span>Вийти</span>
        </button>
      </div>
    </aside>
    
    <!-- Основний контент -->
    <div class="ml-64 p-8">
      <!-- Заголовок сторінки -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Добрий день, {{ userName }}!</h1>
        <p class="text-gray-600">{{ currentDate }}</p>
      </div>
      
      <!-- Картки статистики -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Активні рятувальники -->
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Рятувальників на чергуванні</p>
              <p class="text-2xl font-bold text-gray-800">12</p>
            </div>
          </div>
        </div>
        
        <!-- Активні пости -->
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Активних постів</p>
              <p class="text-2xl font-bold text-gray-800">8</p>
            </div>
          </div>
        </div>
        
        <!-- Надана допомога -->
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-amber-500">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Надано допомоги</p>
              <p class="text-2xl font-bold text-gray-800">5</p>
            </div>
          </div>
        </div>
        
        <!-- Відвідувачів -->
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Відвідувачів сьогодні</p>
              <p class="text-2xl font-bold text-gray-800">1250</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Основний вміст, дві колонки -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Сьогоднішні зміни -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b">
              <h2 class="text-lg font-bold text-gray-800">Сьогоднішні зміни</h2>
              <Link :href="route('shifts.index')" class="text-blue-500 hover:text-blue-700">
                Всі зміни →
              </Link>
            </div>
            
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Пост</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Рятувальник</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Час</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="(shift, index) in shifts" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ shift.post }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ shift.lifeguard }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ shift.time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                            :class="getStatusClass(shift.status)">
                        {{ shift.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        <!-- Права колонка -->
        <div class="space-y-6">
          <!-- Погодні умови -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b">
              <h2 class="text-lg font-bold text-gray-800">Погодні умови</h2>
            </div>
            <div class="p-6">
              <div class="flex items-center">
                <div class="text-yellow-500 mr-4">
                  <svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="5"></circle>
                    <path stroke-linecap="round" stroke-width="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                  </svg>
                </div>
                <div>
                  <div class="font-medium text-gray-800">Сонячно</div>
                  <div class="text-3xl font-bold text-gray-900">28°C</div>
                  <div class="text-sm text-gray-500">Вітер: 5 м/с, Вологість: 65%</div>
                </div>
              </div>
              
              <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="bg-blue-50 p-2 rounded text-center">
                  <div class="text-xs text-gray-500">Хвилі</div>
                  <div class="font-medium">0.5м</div>
                </div>
                <div class="bg-blue-50 p-2 rounded text-center">
                  <div class="text-xs text-gray-500">Вода</div>
                  <div class="font-medium">24°C</div>
                </div>
                <div class="bg-blue-50 p-2 rounded text-center">
                  <div class="text-xs text-gray-500">УФ-індекс</div>
                  <div class="font-medium">Високий</div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Швидкі дії -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b">
              <h2 class="text-lg font-bold text-gray-800">Швидкі дії</h2>
            </div>
            <div class="p-6 space-y-4">
              <Link v-if="isAdmin || isOperative" :href="route('shifts.create')" 
                    class="block w-full text-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Створити зміну
              </Link>
              
              <Link :href="route('posts.map')" 
                    class="block w-full text-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
                Карта постів
              </Link>
              
              <Link :href="route('profile.edit')" 
                    class="block w-full text-center px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md">
                Мій профіль
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

// Тестові дані для відображення
const shifts = ref([
  { post: 'Пост №1', lifeguard: 'Олександр П.', time: '09:00 - 15:00', status: 'Активна' },
  { post: 'Пост №3', lifeguard: 'Марія К.', time: '09:00 - 15:00', status: 'Активна' },
  { post: 'Пост №4', lifeguard: 'Іван С.', time: '15:00 - 21:00', status: 'Заплановано' },
  { post: 'Пост №2', lifeguard: 'Андрій М.', time: '09:00 - 15:00', status: 'Завершена' },
]);

// Отримуємо дані користувача з Inertia
const page = usePage();
const user = computed(() => page.props.auth.user);

// Для відлагодження
onMounted(() => {
  console.log('User data in component:', user.value);
});

// Ім'я користувача
const userName = computed(() => {
  const name = user.value?.name || 'Користувач';
  // Повертаємо тільки ім'я, якщо є прізвище
  const parts = name.split(' ');
  return parts[0];
});

// Обчислення ініціалів для аватара
const userInitials = computed(() => {
  const name = user.value?.name || 'К';
  const parts = name.split(' ');
  if (parts.length > 1) {
    return `${parts[0][0]}${parts[1][0]}`;
  }
  return parts[0][0];
});

// Визначення ролі користувача для відображення
const userRoleText = computed(() => {
  const roleMap = {
    'admin': 'Адміністратор',
    'operative': 'Оперативний',
    'lifeguard': 'Рятувальник',
    '1': 'Адміністратор',
    '2': 'Оперативний',
    '3': 'Рятувальник'
  };
  
  const role = user.value?.role;
  return roleMap[role] || 'Користувач';
});

// Перевірка прав доступу
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

// Поточна дата
const currentDate = computed(() => {
  const date = new Date();
  const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
  return date.toLocaleDateString('uk-UA', options);
});

// Функція для виходу
const logout = () => {
  Inertia.post(route('logout'));
};

// Функція для визначення класу статусу зміни
const getStatusClass = (status) => {
  switch (status) {
    case 'Активна':
      return 'bg-green-100 text-green-800';
    case 'Заплановано':
      return 'bg-blue-100 text-blue-800';
    case 'Завершена':
      return 'bg-gray-100 text-gray-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};
</script>