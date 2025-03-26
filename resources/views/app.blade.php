<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f44336">
    <title>{{ config('app.name', 'KLS Cabinet') }}</title>
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/favicon.ico">
    
    <!-- Preload fonts for better performance -->
    <link rel="preload" href="/fonts/comfortaa-v40-latin_cyrillic-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/comfortaa-v40-latin_cyrillic-700.woff2" as="font" type="font/woff2" crossorigin>
    
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Перевірка онлайн/офлайн статусу
        window.isOnline = navigator.onLine;
        
        window.addEventListener('online', () => {
            window.isOnline = true;
            document.dispatchEvent(new CustomEvent('online'));
        });
        
        window.addEventListener('offline', () => {
            window.isOnline = false;
            document.dispatchEvent(new CustomEvent('offline'));
        });
    </script>
</head>
<body class="antialiased">
    <!-- Індикатор офлайн-режиму -->
    <div id="offline-indicator" style="display: none; position: fixed; top: 0; left: 0; right: 0; background-color: #ff9800; color: white; text-align: center; padding: 0.25rem; z-index: 9999; font-size: 0.875rem;">
        Офлайн режим
    </div>
    
    @inertia
    
    <script>
        // Відображення індикатора офлайн-режиму
        const offlineIndicator = document.getElementById('offline-indicator');
        
        if (!navigator.onLine) {
            offlineIndicator.style.display = 'block';
        }
        
        window.addEventListener('online', () => {
            offlineIndicator.style.display = 'none';
        });
        
        window.addEventListener('offline', () => {
            offlineIndicator.style.display = 'block';
        });
    </script>
</body>
</html>