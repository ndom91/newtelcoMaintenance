<!DOCTYPE html>
<?php
require('authenticate_google.php');
?>
<!--
Credits:
Preloader: https://dribbble.com/shots/4963880-Down-for-Routine-Maintenance
-->
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
  } else {
    setcookie("label", 'Label_2565420896079443395', strtotime('+30 days'));
    setcookie("endlabel", 'Label_2533604283317145521', strtotime('+30 days'));
  }

  ?>
  <title>
    Newtelco Maintenance
  </title>

  <script rel="preload" as="script" src="dist/js/jquery-3.3.1.min.js"></script>

  <?php echo file_get_contents("views/meta.html"); ?>

  <link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou" rel="stylesheet">

  <!-- material design -->
  <script rel="preload" as="script" src="dist/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" src="dist/js/pace.js"></script>

  <!-- chart.js -->
  <script rel="preload" as="script" src="dist/js/chart.js"></script>

  <!-- toastify.js -->
  <script rel="preload" as="script" src="dist/js/toastify.js"></script>

  <!-- comlink.js -->
  <script type="module" rel="preload" as="script" src="dist/js/comlink.js"></script>

  <!-- modalEffects.js -->
  <script rel="preload" as="script" src="dist/js/modalEffects.js"></script>

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
 
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
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
    <script>
      <?php echo file_get_contents("dist/js/rollbarsnippet.js"); ?>
      $(window).on('load', function() {
        $('#loading').css('display','none');
      });
    </script>



        <main style="background-color: #e9e9e9;" class="mdl-layout__content container">
          <div id="loading">
            <img id="loading-image" src="dist/images/Preloader_bobbleHead.gif" alt="Loading..." />
          </div>
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
                      <img width="32px" class="fwaRank"/>
                      <canvas width="20" id="doughnutchart1"></canvas>
                      <div class="fwaCounter"></div>
                      <div class="fwaLineWrapper">
                        <canvas width="10" id="fwaLine"></canvas>
                      </div>
                      <div style="width: 99px;" class="nameLabel">fwaleska</div>
                    </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-5-col mdl-cell--4-col-phone">
                    <div class="aliWrapper">
                      <img width="32px" class="aliRank"/>
                      <canvas width="20" id="doughnutchart2"></canvas>
                      <div class="aliCounter"></div>
                      <div class="aliLineWrapper">
                        <canvas width="10" id="aliLine"></canvas>
                      </div>
                      <div style="width: 97px;" class="nameLabel">alissitsin</div>
                    </div>
                  </div>
                  <div style="margin: 8px 0px 8px 20px;" class="mdl-cell mdl-cell--2-5-col mdl-cell--4-col-phone">
                    <div class="sstWrapper">
                      <img width="32px" class="sstRank"/>
                      <canvas width="21" id="doughnutchart3"></canvas>
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
                      <canvas style="" height="200" id="completedChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
        </main>
      
            
        <div class="md-modal md-effect-10" id="modal-10">
          <div class="md-content">
            <h3><span class='mdi mdi-48px mdi-keyboard'></span>  <span class="helperTitle">Getting Started</span><br></h3>
            <div>
              <div class="">
                <div class="helperText">
                  <table class="helperTable" width="100%">
                    <tr style="font-size: 20px;height:33px;vertical-align:top;">
                      <td style=" text-align: center;" colspan="2">Navigation</td> 
                      <td width="10%"></td> 
                      <td style=" text-align: center;" colspan="2">More</td>
                    <tr>
                      <td width="21%"><b>alt + r</b></td> <td width="21%">open menu</td>
                      <td width="6%"></td> 
                      <td width="21%"><b>shift + c</b></td> <td width="21%">create new</td>
                    </tr>
                    <tr>
                      <td width="21%"><b>alt + h</b></td> <td width="21%">home</td>
                      <td width="6%"></td>
                      <td width="21%"><b>ctrl + shift + x</b></td>  <td width="21%">paste HTML</td>
                    </tr>
                    <tr>
                      <td width="21%"><b>alt + i</b></td>  <td width="21%">incoming</td>
                      <td width="6%"></td> 
                      <td width="21%"><b></b></td> <td width="21%"></td>
                    </tr>
                    <tr>
                      <td width="21%"><b>alt + o</b></td>  <td width="21%">overview</td>
                      <td width="6%"></td> 
                      <td width="21%"><b></b></td> <td width="21%"></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="md-overlay"></div>


        <?php if ($labelID !== '0'): ?>
        <script>
        // COMLINK SW DEMO

        // async function initComlink() {
        //   const {port1, port2} = new MessageChannel();
        //   const msg = {
        //     comlinkInit: true,
        //     port: port1
        //   };
        //   navigator.serviceWorker.controller.postMessage(msg, [port1]);
        //   const swProxy = Comlink.proxy(port2);
        //   console.log(await swProxy.counter);
        //   await swProxy.inc();
        //   console.log(await swProxy.counter);
        // }

        // if (navigator.serviceWorker.controller) {
        //   initComlink();
        // }

        // navigator.serviceWorker.addEventListener('controllerchange', initComlink);

        // END COMLINK SW DEMO 


        var toaster = Toastify({
          text: "Subscribed",
          gravity: "bottom",
          // positionLeft: true,
          close: true,
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        });
        var toaster2 = Toastify({
          text: "Unsubscribed",
          gravity: "bottom",
          // positionLeft: true,
          close: true,
          backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        });

        var fabPushElement = document.querySelector('#notification-toggle');
        //var fabPushElement = fabPushElements[0];

        const urlB64ToUint8Array = base64String => {
          const padding = '='.repeat((4 - (base64String.length % 4)) % 4)
          const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/')
          const rawData = atob(base64)
          const outputArray = new Uint8Array(rawData.length)
          for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i)
          }
          return outputArray
        }
        //This is the "Offline copy of pages" service worker
        if (navigator.serviceWorker.controller) {
          console.log('active service worker found, no need to register')
        } else {
          //Register the ServiceWorker
          navigator.serviceWorker.register('sw4.js', {
            scope: './'
          }).then(function(reg) {
            console.log('Service worker has been registered for scope:'+ reg.scope);
            // initialiseState();
            reg.pushManager.getSubscription()
              .then(function (subscription) {
                //If already access granted, enable push button status
                if (subscription) {
                  changePushStatus(true);
                }
                else {
                  changePushStatus(false);
                }
              })
              .catch(function (error) {
                console.error('Error occurred while enabling push ', error);
              });
          });
          // get notification permission
          // const permission = window.Notification.requestPermission();
          // if(permission !== 'granted'){
          //     throw new Error('Permission not granted for Notification');
          // }
        }
      
        function subscribePush() {
          subscription = navigator.serviceWorker.ready.then(function(registration) {
            if (!registration.pushManager) {
              alert('Your browser doesn\'t support push notification.');
              return false;
            }

            //To subscribe `push notification` from push manager
            const priv = '47EHLIK8B0qEK7stCiGipjURVHZg0XSLRn0c9rqlF5s';
            // const pub = 'BLfTY9BFRjjTBBWsJBaH_T_kQ63PM9iQh5sk2TYA1ht2Qn3CH1jmgIY2IIAh7u2bpA6sEDmIP9m1GhEl1qE9tTQ';
            const pub = 'BOoj1c6teeX075bCUjVA3K0LVrDxSTM2eQKjjV_DDDQohscn7wzzrPKRizkzqI2vlodUuKHOUJGXsibl6A5nCVA';
            const applicationServerKey = urlB64ToUint8Array(pub);
            registration.pushManager.subscribe({
              applicationServerKey,
              userVisibleOnly: true //Always show notification when received
            })
            .then(function (subscription) {
              // toast('Subscribed successfully.');
              const username = $('.menumail').text().trim();
              setCookie("pushSub", username, 30);
              toaster.showToast();
              console.info('Push notification subscribed.');
              console.log(JSON.stringify(subscription));
              //saveSubscriptionID(subscription);
              changePushStatus(true);
              const subscriptionObjectToo = JSON.stringify(subscription);
              $.ajax({
                type: "POST",
                //url: "https://webhook.site/8c9d96b6-03b3-4ab7-96f8-717cc1914002",
                url: "api?addSub&user="+username,
                cache: "false",
                dataType: "json",
                data: subscriptionObjectToo,
                success: function(data) {

                },
                error: function(error) {

                }
            });
            })
            .catch(function (error) {
              changePushStatus(false);
              console.error('Push notification subscription error: ', error);
            });
          })
          //return resolve();
        }

        // Unsubscribe the user from push notifications
        function unsubscribePush() {
          navigator.serviceWorker.ready
          .then(function(registration) {
            //Get `push subscription`
            registration.pushManager.getSubscription()
            .then(function (subscription) {
              //If no `push subscription`, then return
              if(!subscription) {
                alert('Unable to unregister push notification.');
                return;
              }

              //Unsubscribe `push notification`
              subscription.unsubscribe()
                .then(function () {
                  //toast('Unsubscribed successfully.');
                  const username = $('.menumail').text().trim();
                  deleteCookie("pushSub");
                  $.ajax({
                    type: "GET",
                    //url: "https://webhook.site/8c9d96b6-03b3-4ab7-96f8-717cc1914002",
                    url: "api?rmSub&user="+username,
                    cache: "false",
                    success: function(data) {

                    },
                    error: function(error) {

                    }
                  });
                  toaster2.showToast();
                  console.info('Push notification unsubscribed.');
                  // console.log(subscription);
                  //deleteSubscriptionID(subscription);
                  changePushStatus(false);
                })
                .catch(function (error) {
                  console.error(error);
                });
            })
            .catch(function (error) {
              console.error('Failed to unsubscribe push notification.');
            });
          })
        }

        //To change status
        function changePushStatus(status) {
          status = fabPushElement.checked;
          if (status) {
            fabPushElement.checked = true;
          } else {
            fabPushElement.checked = false;
          }
        }

          fabPushElement.addEventListener('click', function () {
          var isSubscribed = (fabPushElement.checked == true);
          if (isSubscribed) {
            subscribePush();
            //console.log('click sub: ' + JSON.stringify(subscription));
            
            // todo send subscription object to backend via api.php
            // https://web-push-book.gauntface.com/chapter-02/01-subscribing-a-user/
          }
          else {
            unsubscribePush();
            // invalidate subscription in backend 
          }
        });


        $('.md-trigger').on('click',function() {
          $('.md-modal').addClass('md-show');
        })

        $('.md-close').on('click',function() {
          $('.md-modal').removeClass('md-show');
        })

        $('.unreadCounter').on('click', function() {
          window.location.href = "https://"+window.location.hostname+"/incoming";
        })

        $(document).ready(function() {

          // console.log('Cookie: ' + getCookie("pushSub"));
          if(getCookie("pushSub") !== '') {
            var fabPushElement = document.querySelector('#notification-toggle');
            fabPushElement.checked = true;
          }
          // military rank 
          setTimeout(function() {
            $('.fwaRank').attr('src',getRank($('.fwaCounter').text()));
            $('.sstRank').attr('src',getRank($('.sstCounter').text()));
            $('.aliRank').attr('src',getRank($('.aliCounter').text()));
          },500);

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

          if($('.unreadCounter').text().trim() == '0') {
  
            // nothing to do? TADA!!11!
            // https://github.com/daneden/animate.css

            //animate in 
            const loginBox1 =  document.querySelector('.unreadCounter');
            $(loginBox1).css('font-weight','100');
            $(loginBox1).css('opacity','1');
            loginBox1.classList.add('animated', 'tada', 'delay-2s');

          } else {

            // Got Mail? Make it big n greeeen

            const loginBox1 =  document.querySelector('.unreadCounter');
            $(loginBox1).css('opacity','1');
            $('.unreadCounter').css("font-family","Roboto");
            $('.unreadCounter').css("color","rgba(103, 178, 70, 0.5)");
            $('.unreadCounter').css("text-shadow","0px 0px 30px #fff");
          } 
   
        });
       
        // source. https://thenounproject.com/smashicons/collection/smashicons-badges-army-md-outline/

        function getRank(count) {
          if (count < 5) {
            return '/dist/images/rank/1_rank.svg';
          } else if (5 <= count && count < 10) {
            return '/dist/images/rank/2_rank.svg';
          } else if (10 <= count && count < 15) {
            return '/dist/images/rank/3_rank.svg';
          } else if (15 <= count && count < 20) {
            return '/dist/images/rank/4_rank.svg';
          } else if (20 <= count && count < 25) {
            return '/dist/images/rank/5_rank.svg';
          } else if (25 <= count && count < 30) {
            return '/dist/images/rank/6_rank.svg';
          } else if (30 <= count && count < 35) {
            return '/dist/images/rank/7_rank.svg';
          } else if (35 <= count && count < 40) {
            return '/dist/images/rank/8_rank.svg';
          } else if (40 <= count && count < 45) {
            return '/dist/images/rank/9_rank.svg';
          } else if (45 <= count && count < 50) {
            return '/dist/images/rank/10_rank.svg';
          } else if (50 <= count && count < 55) {
            return '/dist/images/rank/11_rank.svg';
          } else if (55 <= count && count < 60) {
            return '/dist/images/rank/12_rank.svg';
          } else if (60 <= count && count < 65) {
            return '/dist/images/rank/13_rank.svg';
          }
        }
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

        <!-- toastify css -->
        <link type="text/css" rel="stylesheet" href="dist/css/toastify.css" />

        <!-- chart.js init -->
        <script rel="preload" as="script" src="dist/js/ntchartinit2.js"></script>
      </div>

</body>
</html>
