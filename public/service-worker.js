// Найпростіший Service Worker для усунення 404 помилок
// Після успішного запуску можна буде його розширити

const CACHE_NAME = 'kls-cabinet-v1';

// Мінімальний набір для кешування
const INITIAL_ASSETS = [
  '/',
  '/manifest.json'
];

// Установка Service Worker і кешування базових ресурсів
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Базовий кеш створено:', CACHE_NAME);
        return cache.addAll(INITIAL_ASSETS);
      })
      .then(() => self.skipWaiting())
  );
});

// Активація Service Worker
self.addEventListener('activate', (event) => {
  event.waitUntil(self.clients.claim());
  console.log('Service Worker активовано');
});

// Найпростіша стратегія обробки запитів:
// 1. Спробувати отримати з мережі
// 2. Якщо не вдалося, спробувати з кешу
self.addEventListener('fetch', (event) => {
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // Успішна відповідь - кешуємо її для майбутнього
        if (response.status === 200 && event.request.method === 'GET') {
          const responseToCache = response.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return response;
      })
      .catch(() => {
        // Якщо мережа недоступна, повертаємо з кешу
        return caches.match(event.request);
      })
  );
});