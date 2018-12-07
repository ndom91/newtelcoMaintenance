<!DOCTYPE html>
<?php
require('authenticate_google.php');

?>

<html>
<head>
  <title>Newtelco Maintenance | Group Maintenance</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/pace.js"></script>

  <style>
    <?php echo file_get_contents("assets/css/style-ndo.min.css"); ?>
    <?php echo file_get_contents("assets/css/material-ndo.min.css"); ?>
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
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--4-col-phone">
                <iframe id="forum_embed"
                  src="javascript:void(0)"
                  scrolling="no"
                  frameborder="0"
                  width="100%"
                  height="800">
                </iframe>
                <script prefetch rel="preload" as="script" type="text/javascript">
                  document.getElementById('forum_embed').src =
                     'https://groups.google.com/a/newtelco.de/forum/embed/?place=forum/maintenance'
                     + '&showsearch=true&showpopout=false&showtabs=true'
                     + '&parenturl=' + encodeURIComponent(window.location.href);
                </script>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
        </main>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">

</body>
</html>
