<!DOCTYPE html>
<?php
require('authenticate_google.php');

?>

<html>
<head>
  <title>Newtelco Maintenance | CRM</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- jquery -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/pace.js"></script>

  <!-- OverlayScrollbars -->
  <link type="text/css" href="assets/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <link type="text/css" href="assets/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <script rel="preload" as="script" type="text/javascript" src="assets/js/OverlayScrollbars.min.js"></script>

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
          <div id="loading">
            <img id="loading-image" src="assets/images/Preloader_3.gif" alt="Loading..." />
          </div>
          <div style="margin: 0; padding: 0; height: 100%; overflow: hidden;">
            <div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px; ">
              <iframe id="crmFrame" frameBorder="0" width="100%" height="100%" src="https://crm.newtelco.de">Browser not compatible.</iframe>
            </div>
          </div>
        </main>
        <script>
        // $(document).ready(function() {
        //    setTimeout(function() {$('#loading').hide()},500);
        // });
        $(window).on("load", function(){
           $.ready.then(function(){
              setTimeout(function() {$('#loading').hide()},500);
           });
        })

        // document.addEventListener("DOMContentLoaded", function() {
        //   $(".mdl-layout__content").overlayScrollbars({
        //     className:"os-theme-minimal-dark",
        //     overflowBehavior : {
        //       x: "hidden"
        //     },
        //     scrollbars : {
        //       visibility       : "auto",
        //       autoHide         : "move",
        //       autoHideDelay    : 500
        //     }
        //   });
        // });
        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="assets/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">
</body>
</html>
