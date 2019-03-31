<!DOCTYPE html>
<?php
require('authenticate_google.php');

?>

<html>
<head>

  <title>Newtelco Maintenance | Calendar</title>

  <!-- jquery -->
  <script rel="preload" as="script" src="dist/js/jquery-3.3.1.min.js"></script>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" src="dist/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/pace.js"></script>

  <!-- OverlayScrollbars -->
  <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>

  <style>
    <?php echo file_get_contents("dist/css/style.min.css"); ?>
    <?php echo file_get_contents("dist/css/material.min.css"); ?>
  </style>
</head>
<body>
  <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
      <?php
      ob_start();
      include "views/header.php";
      $content_header = ob_get_clean();
      echo $content_header;

      ob_start();
      include "views/menu.php";
      $content_menu = ob_get_clean();
      echo $content_menu;
      ?>

        <main class="mdl-layout__content">
          <div id="loading">
            <img id="loading-image" src="dist/images/Preloader_bobbleHead.gif" alt="Loading..." />
          </div>
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--4-col-phone">
                  <div style="width: 1200px;max-width: 1200px;" class="demo-card-wide mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                      <h2 class="mdl-card__title-text">Maintenance Calendar</h2>
                      <div class="mdl-layout-spacer"></div>
                      <button id="goToGCal" onclick="openInNewTab('https://calendar.google.com/calendar?cid=bmV3dGVsY28uZGVfaGtwOThhbWJidmN0Y245NjZnamozYzdkbG9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ')" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                          <span class="mdi mdi-24px mdi-open-in-app mdi-light"></span>
                      </button>
                      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="goToGCal">
                        Open in Google Calendar
                      </div>
                    </div>
                    <div class="mdl-card__supporting-text">
                      <!-- time.ly embeded calendar -->
                      <script src="//dashboard.time.ly/js/embed.js" data-src="https://events.time.ly/2bulc72?view=month" data-max-height="0" id="timely_script" class="timely-script"></script>
                    </div>
                  </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
        </main>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <script>
        function openInNewTab(url) {
          var win = window.open(url, '_blank');
          win.focus();
        };

        $(window).on("load", function() {
           setTimeout(function() {$('#loading').hide()},500);
        });

        document.addEventListener("DOMContentLoaded", function() {
          $(".mdl-layout__content").overlayScrollbars({
            className:"os-theme-minimal-dark",
            overflowBehavior : {
              x: "hidden"
            },
            scrollbars : {
              visibility       : "auto",
              autoHide         : "move",
              autoHideDelay    : 500
            }
          });
        });
      </script>

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">
      
      <!-- hover css -->
      <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

</body>
</html>
