<!DOCTYPE html>
<?php
require('authenticate_google.php');

?>
<html lang="en">
<head>
<title>Newtelco Maintenance | Welcome</title>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" src="assets/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" src="assets/js/pace.js"></script>

  <!-- jquery -->
  <script rel="preload" as="script" src="assets/js/jquery-3.3.1.min.js"></script>

  <script>
  // Check that service workers are registered
  // if ('serviceWorker' in navigator) {
  //   // Use the window load event to keep the page load performant
  //   window.addEventListener('load', () => {
  //     navigator.serviceWorker.register('/sw.js');
  //   });
  // }

  </script>
  <style>
  <?php echo file_get_contents("assets/css/style.031218.min.css"); ?>
  <?php echo file_get_contents("assets/css/material.031218.min.css"); ?>
  </style>
</head>
<body>
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
              <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">

                  <div class="demo-card-wide index_card_wide mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                      <h2 class="mdl-card__title-text">Maintenance Management System</h2>

                      <div class="mdl-layout-spacer"></div>
                      <a style="color: #fff !important;" href="incoming">
                      <div class="material-icons mdl-badge mdl-badge--overlap" data-badge="<?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "♥"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?>">email</div></a>
                    </div>
                    <div class="mdl-card__supporting-text">
                      <div class="headerWelcome">
                        <h6 style="display:inline;"><?php echo $token_data['name'] ?></h6>
                        <font style="float:right;display:inline;" class="welcomeTime"></font>
                      </div>

                      <script>
                        $(document).ready(function() {
                          var now = moment();
                          var homeNow = moment(now).format("DD MMM YYYY");

                          $('.welcomeTime').html(homeNow);
                        });
                      </script>

                      <?php if ($labelID == '0'): ?>
                        <br>If this is your first visit, <b>please set your prefered Maintenance Mail label</b> in the <a href="settings.php">settings</a><br><br>
                      <?php else : ?>
                        <br>You have <b><?php echo $results3['messagesUnread'] ?></b> maintenance mails open.</h6>
                        <br><br>And <b><?php echo $results4['messagesTotal'] ?></b> maintenances completed!
                        <br><br>Good luck <img style="height:16px;width:16px;" src="assets/images/google_smiley.png"/>
                        <br><br>
                      <?php endif; ?>

                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <a href="incoming.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Incoming
                      </a>
                      <div style="display: inline !important;" class="mdl-layout-spacer"></div>
                      <a href="overview.php" style="float: right;" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Overview
                      </a>
                    </div>
                  </div>
              </div>
              <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
            </div>
        </main>
        <?php echo file_get_contents("views/footer.html"); ?>

        <!-- font awesome -->
        <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

        <!-- material design -->
        <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
        <link rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

        <!-- moment -->
        <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment.min.js"></script>
        <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment-timezone-with-data.min.js"></script>

      </div>
</body>
</html>
