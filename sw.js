
//This is the "Offline copy of pages" service worker

//Install stage sets up the index page (home page) in the cache and opens a new cache
self.addEventListener('install', function(event) {
  var indexPage = new Request('index.php');
  event.waitUntil(
    fetch(indexPage).then(function(response) {
      return caches.open('pwabuilder-offline').then(function(cache) {
        console.log('[PWA Builder] Cached index page during Install: '+ response.url);
        return cache.put(indexPage, response);
      });
  }));
});

//If any fetch fails, it will look for the request in the cache and serve it from there first
self.addEventListener('fetch', function(event) {
  var updateCache = function(request){
    return caches.open('pwabuilder-offline').then(function (cache) {
      return fetch(request).then(function (response) {
        console.log('[PWA Builder] add page to offline: '+response.url)
        return cache.put(request, response);
      });
    });
  };

  event.waitUntil(updateCache(event.request));

  event.respondWith(
    fetch(event.request).catch(function(error) {
      console.log( '[PWA Builder] Network request Failed. Serving content from cache: ' + error );

      //Check to see if you have it in the cache
      //Return response
      //If not in the cache, then return error page
      return caches.open('pwabuilder-offline').then(function (cache) {
        return cache.match(event.request).then(function (matching) {
          var report =  !matching || matching.status == 404?Promise.reject('no-match'): matching;
          return report
        });
      });
    })
  );
})

//
//
// importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.6.1/workbox-sw.js');
//
// if (workbox) {
//   console.log(`Yay! Workbox is loaded 🎉`);
// } else {
//   console.log(`Boo! Workbox didn't load 😬`);
// }
//
// console.log('Hello from sw.js');
//
// workbox.routing.registerRoute(
//   new RegExp('.*\.js'),
//   workbox.strategies.networkFirst()
// );
//
// workbox.routing.registerRoute(
//   // Cache CSS files
//   /.*\.css/,
//   // Use cache but update in the background ASAP
//   workbox.strategies.staleWhileRevalidate({
//     // Use a custom cache name
//     cacheName: 'css-cache',
//   })
// );
//
// workbox.routing.registerRoute(
//   // Cache image files
//   /.*\.(?:png|jpg|jpeg|svg|gif)/,
//   // Use the cache if it's available
//   workbox.strategies.cacheFirst({
//     // Use a custom cache name
//     cacheName: 'image-cache',
//     plugins: [
//       new workbox.expiration.Plugin({
//         // Cache only 20 images
//         maxEntries: 20,
//         // Cache for a maximum of a week
//         maxAgeSeconds: 7 * 24 * 60 * 60,
//       })
//     ],
//   })
// );
//
// //This is the service worker with the Cache-first network
//
// var CACHE = 'pwabuilder-precache';
// var precacheFiles = [
//       "index.php",
//       "incoming.php",
//       "overview.php",
//       "settings.php",
//       "*.woff*"
//     ];
//
// //Install stage sets up the cache-array to configure pre-cache content
// self.addEventListener('install', function(evt) {
//   console.log('[PWA Builder] The service worker is being installed.');
//   evt.waitUntil(precache().then(function() {
//     console.log('[PWA Builder] Skip waiting on install');
//     return self.skipWaiting();
//   }));
// });
//
//
// //allow sw to control of current page
// self.addEventListener('activate', function(event) {
//   console.log('[PWA Builder] Claiming clients for current page');
//   return self.clients.claim();
// });
//
// self.addEventListener('fetch', function(evt) {
//   console.log('[PWA Builder] The service worker is serving the asset.'+ evt.request.url);
//   evt.respondWith(fromCache(evt.request).catch(fromServer(evt.request)));
//   evt.waitUntil(update(evt.request));
// });
//
//
// function precache() {
//   return caches.open(CACHE).then(function (cache) {
//     return cache.addAll(precacheFiles);
//   });
// }
//
// function fromCache(request) {
//   //we pull files from the cache first thing so we can show them fast
//   return caches.open(CACHE).then(function (cache) {
//     return cache.match(request).then(function (matching) {
//       return matching || Promise.reject('no-match');
//     });
//   });
// }
//
// function update(request) {
//   //this is where we call the server to get the newest version of the
//   //file to use the next time we show view
//   return caches.open(CACHE).then(function (cache) {
//     return fetch(request).then(function (response) {
//       return cache.put(request, response);
//     });
//   });
// }
//
// function fromServer(request){
//   //this is the fallback if it is not in the cache to go to the server and get it
//   return fetch(request).then(function(response){ return response});
// }
