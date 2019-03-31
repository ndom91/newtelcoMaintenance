/*
 Copyright 2016 Google Inc. All Rights Reserved.
 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at
     http://www.apache.org/licenses/LICENSE-2.0
 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
*/

importScripts('https://cdnjs.cloudflare.com/ajax/libs/cache.adderall/1.0.0/cache.adderall.js');
importScripts("https://cdn.jsdelivr.net/npm/comlinkjs@3/umd/comlink.js");

// Names of the two caches used in this version of the service worker.
// Change to v2, etc. when you update any of the local resources, which will
// in turn trigger the install event again.
var dateObj = new Date();
var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
var date = ('0' + dateObj.getDate()).slice(-2);
var year = dateObj.getFullYear();
var CACHE_VERSION_DAY = date+month+year;

const RUNTIME = 'runtime-v'+CACHE_VERSION_DAY;
const PRECACHE = 'precache-v'+CACHE_VERSION_DAY;

// A list of local resources we always want to be cached.
const PRECACHE_URLS = [
  "dist/js/material.min.js",
  "dist/js/jquery-3.3.1.min.js",
  "dist/js/pace.js",
  "dist/images/newtelco_black.png",
  "dist/images/google_smiley.png",
  "dist/images/svg/settings.svg",
  "dist/images/svg/work.svg",
  "dist/images/svg/calendar.svg",
  "dist/images/svg/group.svg",
  "dist/images/svg/ballot.svg",
  "dist/images/svg/overview.svg",
  "dist/images/svg/home.svg",
  "dist/fonts/Roboto_Latin300.woff2",
  "dist/fonts/Roboto_Latin500.woff2",
  "dist/fonts/Roboto_Latin700.woff2",
  "dist/fonts/Roboto_Latin400.woff2",
  "dist/fonts/Roboto_Latin100.woff2",
  "dist/fonts/MaterialIcons_400.woff2",
  "dist/fonts/materialdesignicons-webfont.woff",
  "dist/fonts/materialdesignicons-webfont.woff2",
  "dist/fonts/fa-solid-900.woff",
  "dist/fonts/fa-solid-900.woff2",
  "dist/images/favicon/apple-icon-152x152.png",
  "dist/images/nt_square32_2_light2.png",
  "dist/images/fav-32x32.png",
  "dist/images/Preloader_bobbleHead.gif",
  "dist/css/mdl-jquery-modal-dialog.css",
  "dist/css/os-theme-minimal-dark.css",
  "dist/css/dataTables/responsive.dataTables.min.css",
  "dist/css/dataTables/select.dataTables.min.css",
  "dist/css/dataTables/dataTables.material.min.css",
  "dist/js/dataTables/jquery.dataTables.min.js",
  "dist/js/dataTables/dataTables.material.min.js",
  "dist/js/dataTables/dataTables.select.min.js",
  "dist/js/dataTables/dataTables.responsive.min.js",
  "dist/js/mdl-jquery-modal-dialog.js",
  "dist/js/moment/datetime-moment.min.js",
  "dist/js/keymaster.js",
  "dist/css/vis-timeline.min.css",
  "dist/js/vis.js",
  "dist/js/materialize.min.js",
  "dist/js/select2_4.0.6-rc1.min.js",
  "dist/js/mdl-selectfield.min.js",
  "dist/js/flatpickr.min.js",
  "dist/js/materialize.min.js",
  "dist/js/xlsx.full.min.js",
  "dist/css/mdl-selectfield.min.css",
  "dist/css/select2.min.css",
  "dist/css/flatpickr.min.css",
  "dist/css/flatpickr_green.css",
  "dist/css/animate.css",
  "dist/css/materialize.min.css",
  "dist/js/handsontable.min.js",
  "dist/js/chart.js",
  "dist/js/ntchartinit2.js",
  "dist/js/favicon.js",
  "dist/js/particle.js",
  "dist/css/handsontable.min.css",
  "dist/css/hover.css",
  "dist/js/moment/luxon.min.js",
  "dist/images/newtelco_full2_lightgray2.png",
  "dist/images/btn_google_signin_light_normal_web.png",
  "dist/images/btn_google_signin_light_focus_web.png",
  "dist/images/newtelco_full2_lightgray2_og.png",
  "dist/fonts/fontawesome5.5.0.min.css",
  "dist/fonts/materialicons400.css",
  "dist/fonts/GFonts_Roboto.css",
  "dist/css/materialdesignicons.min.css",
  "dist/css/OverlayScrollbars.css",
  "dist/css/os-theme-minimal-dark.css",
];

// network / cache race
// https://jakearchibald.com/2014/offline-cookbook/

// The install handler takes care of precaching the resources we always need.
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(PRECACHE)
      .then(cache => adderall.addAll(cache,PRECACHE_URLS))
      .then(self.skipWaiting())
  );
});

// The activate handler takes care of cleaning up old caches.
self.addEventListener('activate', event => {
  const currentCaches = [PRECACHE, RUNTIME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return cacheNames.filter(cacheName => !currentCaches.includes(cacheName));
    }).then(cachesToDelete => {
      return Promise.all(cachesToDelete.map(cacheToDelete => {
        return caches.delete(cacheToDelete);
      }));
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  // if (event.request.url.startsWith(self.location.origin)) {
    // if(event.request.url.indexOf('api') !== -1) {
    //    console.log('api: ' + event.request.url);
    //    return;
    //  } else 
     if ((/js$/.test(event.request.url)) || (/css$/.test(event.request.url)) || (/jpg$/.test(event.request.url)) || (/png$/.test(event.request.url)) || (/svg$/.test(event.request.url)) || (/svg$/.test(event.request.url)) || (/woff2$/.test(event.request.url))) {
      // stale while revalidate
      event.respondWith(
        caches.open(RUNTIME).then(function(cache) {
          return cache.match(event.request).then(function(response) {
            var fetchPromise = fetch(event.request).then(function(networkResponse) {
              cache.put(event.request, networkResponse.clone());
              return networkResponse;
            })
            return response || fetchPromise;
          })
        })
      );
    } 
    else {
      // event.respondWith(fetch(event.request));
      return;
    }

    // if ((/api/.test(urlPathname)) || (/incoming/.test(urlPathname)) || (/overview/.test(urlPathname)) || (/index/.test(urlPathname)) || (/addedit/.test(urlPathname)) || event.request.type === 'POST') {
    //   event.respondWith(fetch(event.request));
    //   return;
    // } else if (/js$/.test(event.request.url)) {
    //   // stale while revalidate
    //   event.respondWith(
    //       caches.open(RUNTIME).then(function(cache) {
    //         return cache.match(event.request).then(function(response) {
    //           var fetchPromise = fetch(event.request).then(function(networkResponse) {
    //             cache.put(event.request, networkResponse.clone());
    //             return networkResponse;
    //           })
    //           return response || fetchPromise;
    //         })
    //       })
    //     );
    // } else {
    //   event.respondWith(async function() {
    //     const cache = await caches.open(RUNTIME);
    //     const cachedResponse = await cache.match(event.request);
    //     const networkResponsePromise = fetch(event.request);

    //     event.waitUntil(async function() {
    //       const networkResponse = await networkResponsePromise;
    //       await cache.put(event.request, networkResponse.clone());
    //     }());

    //   // Returned the cached response if we have one, otherwise return the network response.
    //   return cachedResponse || networkResponsePromise;
    //   }());
    // }


  //}
});

self.addEventListener('push', function(event) {
  if (event.data) {
    console.log('Push Message: ', event.data.text())
  } else {
    console.log('Push event but no data')
  }
  const notificationOptions = {
    icon: 'dist/images/icons/mailNotification.png',
    //badge: 'dist/images/icons/mailNotification.png',
  };

  if (event.data) {
    const dataText = JSON.parse(event.data.text());
    const title = dataText['title'];
    const body = dataText['body'];
    notificationTitle = title;
    notificationOptions.body = body;
  }

  event.waitUntil(
    Promise.all([
      self.registration.showNotification(
        notificationTitle, notificationOptions)
      //self.analytics.trackEvent('push-received'),
    ])
  );
});

self.addEventListener('notificationclick', function(event) {
  event.waitUntil(
    self.clients.matchAll().then(function(clientList) {
      if (clientList.length > 0) {
        return clientList[0].focus();
      }
      return self.clients.openWindow('https://maintenance.newtelco.de/incoming');
    })
  );
});


// surma comlink - service worker example: https://github.com/GoogleChromeLabs/comlink/blob/master/docs/examples/05-service-worker/worker.js#L21
// https://github.com/GoogleChromeLabs/comlink/tree/master/docs/examples
// const obj = {
//   counter: 0,
//   inc() {
//     this.counter++;
//   }
// };

// self.addEventListener("message", event => {
//   if (event.data.comlinkInit) {
//     Comlink.expose(obj, event.data.port);
//     return;
//   }
// });
// end surma comlink example


// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
// firebase.initializeApp({
//   'messagingSenderId': '976818051506'
// });

// // Retrieve an instance of Firebase Messaging so that it can handle background
// // messages.
// const messaging = firebase.messaging();

// messaging.setBackgroundMessageHandler(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   // Customize notification here
//   var notificationTitle = 'Background Message Title';
//   var notificationOptions = {
//     body: 'Background Message body.'
//     // icon: '/firebase-logo.png'
//   };

//   return self.registration.showNotification(notificationTitle,
//     notificationOptions);
// });
