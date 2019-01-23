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

  if (isset($_SESSION['endlabel'])) {
    $gmailLabelAdd = $_SESSION['endlabel'];
  } else if(isset($_COOKIE['endlabel'])){
    $gmailLabelAdd = $_COOKIE['endlabel'];
  } else {
    $gmailLabelAdd = 'Choose \"complete\" label in settings!';
  }

  if ($labelID != '0') {
    $service3 = new Google_Service_Gmail($clientService);
    $results3 = $service3->users_labels->get($user,$labelID);
    $results4 = $service3->users_labels->get($user,$gmailLabelAdd);
  }

  ?>
  <title>
    Newtelco Maintenance
  </title>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!--  <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou" rel="stylesheet">

  <script rel="preload" as="script" src="dist/js/jquery-3.3.1.min.js"></script>

  <!-- material design -->
  <script rel="preload" as="script" src="dist/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" src="dist/js/pace.js"></script>

  <!-- chart.js -->
  <script rel="preload" as="script" src="dist/js/chart.js"></script>

  <!-- luxon -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/luxon.min.js"></script>

  <!-- OverlayScrollbars -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>


  <script>
    var RELOAD_EVERY = 8;
    setTimeout(function(){
        location.reload();
    }, RELOAD_EVERY * 60 * 1000);
  </script>

  <style>
    <?php echo file_get_contents("dist/css/style.min.css"); ?>
    <?php echo file_get_contents("dist/css/material.min.css"); ?>
  </style>

  <script>
  //This is the "Offline copy of pages" service worker

  //Add this below content to your HTML page, or add the js file to your page at the very top to register service worker
  if (navigator.serviceWorker.controller) {
    console.log('active service worker found, no need to register')
  } else {
    //Register the ServiceWorker
    navigator.serviceWorker.register('sw.js', {
      scope: './'
    }).then(function(reg) {
      console.log('Service worker has been registered for scope:'+ reg.scope);
    });
  }


  </script>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header ">
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

        <main style="background-color: #e9e9e9;" class="mdl-layout__content">

            <div style="height:calc(100vh - 100px);" class="mdl-grid">
              <div class="mdl-cell--stretch mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                <div class="mdl-grid">
                  <div class="mdl-cell mdl-cell--4-5-col mdl-cell--4-col-phone">
                      <?php if ($labelID == '0'): ?>
                        <div class="settingsNudge">
                          <br>No <b>label</b> <span class="mdi mdi-email-mark-as-unread mdi-green"></span> selection made<br><br>Please visit the <a class="hvr-underline-from-left" style="font-weight: 500;text-decoration:none;" href="settings.php">settings</a> <br>and set your preferences.
                          <br><br>
                          <br>
                        </div>
                      <?php else : ?>
                        <div class="card">
                          <div class="card-body">
                            <div class="unread">
                              <!-- <span class="hvr-grow-rotate mdi mdi-48px mdi-email mdi-green unreadIcon"></span> -->
                              <div class="unreadLabel1">
                                Maintenance 
                              </div>
                              <div class="unreadLabel2">
                                Unread 
                              </div>
                              <div class="hvr-bounce-in2 unreadCounter">
                                <?php echo $results3['messagesUnread'] ?>
                              </div>
                            </div>
                            </div>
                            <div class="chart-wrapper">
                              <canvas height="120" class="chart" id="line-chart"></canvas>
                            </div>
                        </div>
                      <?php endif; ?>
                  </div>
                  <div class="mdl-cell mdl-cell--2-5-col mdl-cell--4-col-phone">
                    <div class="fwaWrapper">
                      <canvas width="15" id="doughnutchart1"></canvas>
                      <div class="fwaCounter"></div>
                      <div class="fwaLineWrapper">
                        <canvas width="10" id="fwaLine"></canvas>
                      </div>
                      <div style="width: 99px;" class="nameLabel">fwaleska</div>
                    </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-5-col mdl-cell--4-col-phone">
                    <div class="aliWrapper">
                      <canvas width="15" id="doughnutchart2"></canvas>
                      <div class="aliCounter"></div>
                      <div class="aliLineWrapper">
                        <canvas width="10" id="aliLine"></canvas>
                      </div>
                      <div style="width: 97px;" class="nameLabel">alissitsin</div>
                    </div>
                  </div>
                  <div style="margin: 8px 0px 8px 20px;" class="mdl-cell mdl-cell--2-5-col mdl-cell--4-col-phone">
                    <div class="sstWrapper">
                      <canvas width="15" id="doughnutchart3"></canvas>
                      <div class="sstCounter"></div>
                      <div class="sstLineWrapper">
                        <canvas width="10" id="sstLine"></canvas>
                      </div>
                      <div style="width: 104px;" class="nameLabel">sstergiou</div>
                    </div>
                  </div>
                </div>
                <div class="mdl-grid mdl-cell--stretch">
                  <div class="h100 mdl-cell mdl-cell--12-col mdl-cell--4-col-phone mdl-cell--bottom">
                    <div class="h100 bottomChartWrapper">
                      <div class="bottomChartLabel">Maintenances Completed per Day</div>
                      <canvas height="200" id="completedChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
        </main>
        <?php if ($labelID !== '0'): ?>
        <script>

          $('.unreadCounter').on('click', function() {
            window.location.href = "https://maintenance.newtelco.de/incoming";
          })

        
        $(document).ready(function() {

          // Pretty Scrollbars
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

          // hide menu opener on index page with fixed drawer
          $('.col').css("display","none");
          $('.menuSubLabel2').css("display","none");

          if($('.unreadCounter').text() == '0') {
  
            // nothing to do? TADA!!11!
            // https://github.com/daneden/animate.css

            //animate in 
            const loginBox1 =  document.querySelector('.unreadCounter');
            $(loginBox1).css('opacity','1');
            loginBox1.classList.add('animated', 'tada');

          } else {

            // Got Mail? Make it big n greeeen

            const loginBox1 =  document.querySelector('.unreadCounter');
            $(loginBox1).css('opacity','1');
            $('.unreadCounter').css("font-family","Roboto");
            $('.unreadCounter').css("color","rgba(103, 178, 70, 0.5)");
            $('.unreadCounter').css("text-shadow","0px 0px 30px #fff");
          } 
        });

        </script>
        <?php endif; ?>
        <?php  /*echo file_get_contents("views/footer.html");*/ ?>

        <!-- font awesome -->
        <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

        <!-- material design -->
        <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
        <link rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

        <!-- material icons -->
        <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
        <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

        <!-- hover css -->
        <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

        <!-- Overlay Scrollbars -->
        <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
        <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">

        <!-- moment -->
        <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment.min.js"></script>
        <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment-timezone-with-data.min.js"></script>

        <!-- animate css -->
        <link type="text/css" rel="stylesheet" href="dist/css/animate.css" />

        <!-- chart.js init -->
        <script rel="preload" as="script" src="dist/js/ntchartinit2.js"></script>
      </div>
</body>
</html>
