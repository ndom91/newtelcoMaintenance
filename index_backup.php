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

  <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
  
  <!-- jquery -->
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
    var RELOAD_EVERY = 5;
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
                      </div>
                    <div class="mdl-card__supporting-text">
                      <?php if ($labelID == '0'): ?>
                        <div class="settingsNudge">
                          <br>No <b>label</b> selection made, please visit <a class="hvr-underline-from-left" style="font-weight: 500;text-decoration:none;" href="settings.php">settings</a> and set your preferences.
                          <br><br>
                          <font style="font-weight: 400 !important;">Getting Started</font>:<br>
                          <table  width="100%">
                            <tr>
                              <td width="80px"><b style="color: #67B246">alt+r</b></td> <td>open menu</td>
                            </tr>
                            <tr>
                              <td width="80px"><b style="color: #67B246">alt+h</b></td> <td>home</td>
                            </tr>
                            <tr>
                              <td width="80px"><b style="color: #67B246">alt+i</b></td>  <td>incoming</td>
                            </tr>
                            <tr>
                              <td width="80px"><b style="color: #67B246">alt+o</b></td>  <td>overview</td>
                            </tr>
                          </table>
                          <br>
                        </div>
                      <?php else : ?>
                        <div class="unread">
                          <div class="hvr-bounce-in2 unreadCounter">
                            <?php echo $results3['messagesUnread'] ?>
                          </div>
                          <span class="hvr-grow-rotate mdi mdi-48px mdi-email mdi-green mdi-dark mdi-inactive unreadIcon"></span>
                          <div class="unreadLabel">
                            Unread Maintenances
                          </div>
                        </div>
                        <canvas id="completedChart"></canvas>
                        <canvas id="polar-chart"></canvas>
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
                        History
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
        <script>
          $.ajax({
              url: 'api?completedLine=1',
              success: function (data) {

                // Labels + Dates
                var DateTime = luxon.DateTime;
                var topDay = (data[0]['day']);
                var topDay = DateTime.fromISO(topDay);
                var topDayStr = topDay.toFormat('LLL dd');
                var comp_today = DateTime.local();
                var comp_todayStr = DateTime.local().toFormat('LLL dd');
                var comp_m1 = comp_today.minus({days: 1}).toFormat('LLL dd');
                var comp_m2 = comp_today.minus({days: 2}).toFormat('LLL dd');
                var comp_m3 = comp_today.minus({days: 3}).toFormat('LLL dd');
                var comp_m4 = comp_today.minus({days: 4}).toFormat('LLL dd');
                var comp_m5 = comp_today.minus({days: 5}).toFormat('LLL dd');
                var comp_m6 = comp_today.minus({days: 6}).toFormat('LLL dd');

                // date formats for comparing in array
                var func_m0 = DateTime.local().toISODate();
                var func_m1 = comp_today.minus({days: 1}).toISODate();
                var func_m2 = comp_today.minus({days: 2}).toISODate();
                var func_m3 = comp_today.minus({days: 3}).toISODate();
                var func_m4 = comp_today.minus({days: 4}).toISODate();
                var func_m5 = comp_today.minus({days: 5}).toISODate();
                var func_m6 = comp_today.minus({days: 6}).toISODate();

                // People Counts
                var sst = [];
                var ali = [];
                var fwa = [];

                for ( var i = 0; i < data.length; i++ ) {
                  if (data[i]['bearbeitetvon'] == 'fwaleska') {
                    fwa.push(data[i]['day']);
                  } else if (data[i]['bearbeitetvon'] == 'alissitsin') {
                    ali.push(data[i]['day']);
                  } else if (data[i]['bearbeitetvon'] == 'sstergiou') {
                    sst.push(data[i]['day']);
                  }
                }

                function countDays(arr,day) {
                  var occurences = arr.filter(function(val) {
                    return val === day;
                  }).length;
                  return occurences;
                }

                var ctx = document.getElementById('completedChart').getContext('2d');
                var chart = new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: [comp_m6, comp_m5, comp_m4, comp_m3, comp_m2, comp_m1, comp_todayStr],
                    datasets: [{
                        // FWALESKA
                        label: 'fwaleska',
                        backgroundColor: 'rgba(103,178,70,0.4)',
                        borderColor: 'rgba(103,178,70,0.8)',
                        data: [countDays(fwa,func_m6), countDays(fwa,func_m5), countDays(fwa,func_m4), countDays(fwa,func_m3), countDays(fwa,func_m2), countDays(fwa,func_m1), countDays(fwa,func_m0)]
                    },{
                        // ALISSITSIN
                        label: 'alissitsin',
                        backgroundColor: 'rgba(249,103,103,0.4)',
                        borderColor: 'rgba(249,103,103,0.8)',
                        data: [countDays(ali,func_m6), countDays(ali,func_m5), countDays(ali,func_m4), countDays(ali,func_m3), countDays(ali,func_m2), countDays(ali,func_m1), countDays(ali,func_m0)]
                    },{
                        // SSTERGIOU
                        label: 'sstergiou',
                        backgroundColor: 'rgba(36,122,219,0.4)',
                        borderColor: 'rgba(36,122,219,0.8)',
                        data: [countDays(sst,func_m6), countDays(sst,func_m5), countDays(sst,func_m4), countDays(sst,func_m3), countDays(sst,func_m2), countDays(sst,func_m1), countDays(sst,func_m0)]
                    }
                    ]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              },
                              stacked: true
                          }]
                      },
                      legend: {
                          display: true
                      },
                      title: {
                          display: true,
                          text: 'Completed Maintenances per Day (Last 7 Days)'
                      },
                      tooltips: {
                          mode: 'index'
                      }
                    }
                });

              },
              error: function (err) {
                console.log('Error', err);
              },
              dataType:"json"
            });

            $.ajax({
              url: 'api?completedLine=1',
              success: function (data) {

                var sstCount = 0;
                var aliCount = 0;
                var fwaCount = 0;

                var arrayLength = data.length;
                for (var i = 0; i < arrayLength; i++) {
                    if (data[i]['bearbeitetvon'] == 'sstergiou') {
                      sstCount++;
                    } else if (data[i]['bearbeitetvon'] == 'alissitsin') {
                      aliCount++;
                    } else if (data[i]['bearbeitetvon'] == 'fwaleska') {
                      fwaCount++;
                    }
                }
                var ctx = document.getElementById('polar-chart').getContext('2d');
                new Chart(document.getElementById("polar-chart"), {
                    type: 'polarArea',
                    data: {
                      labels: ["fwaleska", "alissitsin", "sstergiou"],
                      datasets: [
                        {
                          label: "Maintenances Completed (total)",
                          backgroundColor: ["rgba(103,178,70,0.4)", "rgba(249,103,103,0.4)","rgba(36,122,219,0.4)"],
                          borderColor: ['rgba(103,178,70,0.8)','rgba(249,103,103,0.8)','rgba(36,122,219,0.8)'],
                          data: [sstCount,aliCount,fwaCount]
                        }
                      ]
                    },
                    options: {
                      title: {
                        display: true,
                        text: 'Maintenances Completed (total)'
                      }
                    }
                });

              },
              error: function (err) {
                console.log('Error', err);
              },
              dataType:"json"
            });

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

             // big unread counter
              if($('.unreadCounter').text().trim() == '0') {
                $('.unreadCounter').css("color","#4e4e4e");
                $('.unreadCounter').css("font-weight","100");
              } 
            });

        </script>
        <?php echo file_get_contents("views/footer.html"); ?>

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

      </div>
</body>
</html>
