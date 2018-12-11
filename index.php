<!DOCTYPE html>
<?php
require('authenticate_google.php');

?>
<html lang="en">
<head>
  <?php
  if(isset($_POST['label']) || isset($_SESSION['label'])) {
    if(! empty($_POST['label'])) {
    $labelID = urldecode($_POST['label']);
    $_SESSION['label'] = $labelID;
    } else {
      $labelID = $_SESSION['label'];
    }
  } else {
    if(isset($_COOKIE['label'])) {

      $labelID = urldecode($_COOKIE['label']);
    } else {
      $labelID = '0';
    }
  }

  if ($labelID != '0') {
    $service3 = new Google_Service_Gmail($clientService);
    $results3 = $service3->users_labels->get($user,$labelID);
    $results4 = $service3->users_labels->get($user,'Label_6022158568059110610');
  }

  ?>
<title><?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "♥"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?> | NT Maintenance</title>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" src="assets/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" src="assets/js/pace.js"></script>

  <!-- jquery -->
  <script rel="preload" as="script" src="assets/js/jquery-3.3.1.min.js"></script>

  <script src="assets/css/hamburger_menu.css"></script>
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
  <?php echo file_get_contents("assets/css/style-ndo.min.css"); ?>
  <?php echo file_get_contents("assets/css/material-ndo.min.css"); ?>
  </style>
  <script>
    var RELOAD_EVERY = 10;
    setTimeout(function(){
        location.reload();
    }, RELOAD_EVERY * 60 * 1000);
  </script>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
      <?php
      ob_start();
      include "views/header.php";
      $content_header = ob_get_clean();
      echo $content_header;

      ?>

      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title"><img src="/assets/images/newtelco_black.png"/></span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><span class="ndl-home"></span>  Home</a>
          <!-- <a class="mdl-navigation__link" href="userhome.php"><i class="ndl-face"></i>  <?php echo $token_data['name'] ?></a> -->
          <a class="mdl-navigation__link" href="overview.php"><i class="ndl-overview"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming<div class="material-icons mdl-badge mdl-badge--overlap menuSubLabel2" data-badge="<?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "♥"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?>"></div></a></a>
          <a class="mdl-navigation__link" href="group.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">maintenance</small></a>
          <a class="mdl-navigation__link" href="groupservice.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">service</small></a>
          <a class="mdl-navigation__link" href="calendar.php"><i class="ndl-calendar"></i></i>  Calendar</a>
          <a class="mdl-navigation__link" href="crm_iframe.php"><i class="ndl-work"></i>  CRM</a>
          <a class="mdl-navigation__link" href="settings.php"><i class="ndl-settings"></i>  Settings</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link menu_logout" href="?logout">
            <button id="menuLogout" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
              <span style="margin-left: 5px;" class="mdi mdi-24px mdi-logout mdi-light"></span>
            </button>
            <div class="mdl-tooltip  mdl-tooltip--top" data-mdl-for="menuLogout">
              Logout
            </div>
          </a>
        </nav>
      </div>

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
                      <a href="incoming.php" id="btnIncoming" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Incoming
                      </a>
                      <div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="btnIncoming">
                        View Incoming Maintenance Mails
                      </div>
                      <div style="display: inline !important;" class="mdl-layout-spacer"></div>
                      <a href="overview.php" id="btnOverview" style="float: right;" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Overview
                      </a>
                      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnOverview">
                        View Maintenance History
                      </div>
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

        <!-- material icons -->
        <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
        <link rel="preload stylesheet" as="style" href="assets/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

        <!-- moment -->
        <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment.min.js"></script>
        <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment-timezone-with-data.min.js"></script>

        <!-- material hamburger menu -->

        <script>materialDesignHamburger();</script>
        <script rel="preload" as="script" src="assets/js/hamburger_menu.js"></script>


      </div>
</body>
</html>
