const CACHE_NAME = "lifecrm-cache-v1";
const urlsToCache = [
  '/',
  '/css/app.css',
  '/js/app.js'
  // Добавь другие файлы, которые хочешь кэшировать
];

// Установка Service Worker и кэширование файлов
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Cache opened');
        return cache.addAll(urlsToCache);
      })
  );
});

// Обработка запросов: сначала пытаемся получить данные из кэша
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        return response || fetch(event.request);
      })
  );
});
