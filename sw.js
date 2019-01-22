//This is the service worker with the Cache-first network

importScripts('https://cdnjs.cloudflare.com/ajax/libs/cache.adderall/1.0.0/cache.adderall.js');

var STATIC_FILES = [
  "dist/js/material.min.js",
  "dist/js/jquery-3.3.1.min.js",
  "dist/js/pace.js",
  "dist/fonts/fontawesome5.5.0.min.css",
  "dist/css/OverlayScrollbars.css",
  "dist/js/OverlayScrollbars.min.js",
  "dist/js/moment/moment-timezone-with-data.min.js",
  "dist/css/materialdesignicons.min.css",
  "dist/fonts/GFonts_Roboto.css",
  "dist/fonts/materialicons400.css",
  "dist/js/moment/moment.min.js",
  "dist/images/newtelco_black.png",
  "dist/images/google_smiley.png",
  "dist/images/svg/settings.svg",
  "dist/images/svg/work.svg",
  "dist/images/svg/calendar.svg",
  "dist/images/svg/group.svg",
  "dist/images/svg/ballot.svg",
  "dist/images/svg/overview.svg",
  "dist/images/svg/home.svg",
  "dist/fonts/Roboto_Latin500.woff2",
  "dist/fonts/Roboto_Latin700.woff2",
  "dist/fonts/Roboto_Latin400.woff2",
  "dist/fonts/Roboto_Latin100.woff2",
  "dist/fonts/MaterialIcons_400.woff2",
  "dist/fonts/fa-solid-900.woff2",
  "dist/images/favicon/apple-icon-152x152.png",
  "dist/images/nt_square32_2_light2.png",
  "dist/fonts/materialdesignicons-webfont.woff2",
  "dist/fonts/materialdesignicons-webfont.woff2?v=3.0.39",
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
  "dist/images/fav-32x32.png",
  "dist/images/Preloader_4.gif",
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
  "dist/css/handsontable.min.css",
  "dist/css/hover.css",
  "dist/js/moment/luxon.min.js",
  "dist/images/newtelco_full2_lightgray2.png",
  "dist/images/btn_google_signin_light_normal_web.png",
  "dist/images/btn_google_signin_light_focus_web.png",
  "dist/images/newtelco_full2_lightgray2_og.png"
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('nt-mt-v1').then(cache =>
      adderall.addAll(cache, STATIC_FILES)
    )
  );
});


self.addEventListener('fetch', (event) => {
  // Parse the URL:
  const requestURL = new URL(event.request.url);

  // Handle requests to a particular host specifically
  if (requestURL.hostname !== 'maintenance.newtelco.de') {
    //event.respondWith(/* some combination of patterns */);
    var HTTPrequestURL = requestURL.toString();

    if (HTTPrequestURL.startsWith('http://')) {
      var HTTPSrequestURL = HTTPrequestURL.replace("http://","https://");
      event.respondWith(fetch(HTTPSrequestURL, { mode: 'no-cors' }));
    } else {
      event.respondWith(fetch(event.request));
    }
  }

  // Routing for local URLs
  if (requestURL.origin == location.origin) {

    if (/^api\?/.test(requestURL.pathname)) {
      event.respondWith(fetch(event.request));
      return;
    }
    if (/favicon/.test(requestURL.pathname)) {
      event.respondWith(fetch(event.request));
      return;
    }
    if (requestURL.pathname.endsWith('.css')) {
      try {
        event.respondWith(caches.match(event.request));
        return;
      } catch (err) {
        return event.respondWith(fetch(event.request));
      }
    }
    if (requestURL.pathname.endsWith('.gif')) {
      event.respondWith(caches.match(event.request));
      return;
    }
    if (requestURL.pathname.endsWith('.woff2')) {
      event.respondWith(caches.match(event.request));
      return;
    }
    if (requestURL.pathname.endsWith('.js')) {
      try {
        event.respondWith(caches.match(event.request));
        return;
      } catch (err) {
        return event.respondWith(fetch(event.request));
      }
    }
    if (requestURL.pathname.endsWith('.svg')) {
      try {
        event.respondWith(caches.match(event.request));
        return;
      } catch (err) {
        return event.respondWith(fetch(event.request));
      }
    }
    if (requestURL.pathname.endsWith('.png')) {
      try {
        event.respondWith(caches.match(event.request));
        return;
      } catch (err) {
        return event.respondWith(fetch(event.request));
      }
    }
    if (requestURL.pathname.endsWith('.php')) {
      event.respondWith(event.respondWith(async function() {
        try {
          return await fetch(event.request);
        } catch (err) {
          return caches.match(event.request);
        }
      }()));
      return;
    }
  }

  // A sensible default pattern
  // event.respondWith(async function() {
  //   const cachedResponse = await caches.match(event.request);
  //   return cachedResponse || fetch(event.request);
  // }());
});
