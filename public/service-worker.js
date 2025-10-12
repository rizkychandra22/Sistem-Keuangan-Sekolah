self.addEventListener('install', (event) => {
    event.waitUntil(
      caches.open('my-cache').then((cache) => {
        return cache.addAll([
          '/',
          '/login',
          '/manifest.json',
          '/css/app.css',
          '/js/app.js',
          '/images/icons-192x192.png',
          '/images/icons-512x512.png',
          // Add other files that need to be cached
        ]);
      })
    );
  });
  
  self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      })
    );
  });
  