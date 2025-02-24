<script setup>
import { onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Встановлюємо, що сторінка використовує AuthenticatedLayout
definePageMeta({
  layout: AuthenticatedLayout,
})

// Приймаємо проп "posts" (масив постів)
const props = defineProps({
  posts: {
    type: Array,
    default: () => [],
  },
})

// Функція ініціалізації карти
function initMap() {
  // Створюємо карту з центром на Києві (за прикладом)
  const map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: { lat: 50.438872, lng: 30.572219 },
  })

  // Для кожного поста додаємо маркер
  props.posts.forEach((post) => {
    new google.maps.Marker({
      position: {
        lat: parseFloat(post.latitude),
        lng: parseFloat(post.longitude),
      },
      map: map,
      title: post.name,
    })
  })
}

onMounted(() => {
  // Якщо Google Maps API завантажено, ініціалізуємо карту
  if (typeof google !== 'undefined' && google.maps) {
    initMap()
  } else {
    // Якщо API ще не завантажено, динамічно підключаємо скрипт
    const script = document.createElement('script')
    // Замініть YOUR_API_KEY на ваш реальний API-ключ
    script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMapCallback'
    script.async = true
    window.initMapCallback = initMap
    document.head.appendChild(script)
  }
})
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <Head title="Карта постів" />
    <h1 class="text-2xl font-bold text-red-500 mb-4">Карта постів</h1>
    <!-- Контейнер для карти -->
    <div id="map" class="w-full h-96 rounded shadow"></div>
  </div>
</template>

<style scoped>
#map {
  height: 400px; /* Можна змінити, якщо потрібно */
}
</style>
