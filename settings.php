<!DOCTYPE html>
<?php
require('authenticate_google.php');

if(isset($_POST['label']) || isset($_SESSION['label'])) {
  if(isset($_POST['label'])) {
    $labelID2 = $_POST['label'];
  } else {
    $labelID2 = $_SESSION['label'];
  }
  setcookie("label", $labelID2, strtotime( '+30 days' ));
}

if(isset($_POST['endlabel'])) {
  $labelID3 = $_POST['endlabel'];
  $_SESSION['endlabel'] = $labelID3;
  setcookie("endlabel", $labelID3, strtotime( '+30 days' ));
}

?>

<html>
<head>
  <title>Newtelco Maintenance | Settings</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- handsontable -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/handsontable.min.js"></script>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/material.min.js"></script>

  <!-- jquery -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>

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
      <header class="mdl-layout__header mdl-color--light-green-nt">
        <div class="mdl-layout__header-row">
          <a href="index.php"><img style="margin-right: 10px" src="assets/images/nt_square32_2_light2.png"/></a>
          <span class="mdl-layout-title">Maintenance</span>
          <div class="mdl-layout-spacer"></div>
          <div class="menu_userdetails">
            <button id="user-profile-menu" class="mdl-button mdl-js-button mdl-userprofile-button">
              <img class="menu_userphoto" src="<?php echo $token_data['picture'] ?>"/>
              <span class="mdl-layout-subtitle menumail"> <?php echo $token_data['email'] ?></span>
              <i class="fas fa-angle-down menuangle"></i>
            </button>
              <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                  for="user-profile-menu">
                <a class="usermenuhref" href="calendar">
                  <li class="mdl-menu__item">
                    Calendar
                    <span class="mdi mdi-24px mdi-calendar-text mdi-dark mdi-inactive"></span>
                  </li>
                </a>
                <a class="usermenuhref" href="settings">
                  <li class="mdl-menu__item">
                    Settings
                    <span class="mdi mdi-24px mdi-settings-outline mdi-dark mdi-inactive"></span>
                  </li>
                </a>
                <li>
                  <div class="mailcHR3"></div>
                </li>
                <a class="usermenuhref" href="?logout">
                  <li class="mdl-menu__item">
                    Logout
                    <span class="mdi mdi-24px mdi-logout mdi-dark mdi-inactive"></span>
                  </li>
                </a>
              </ul>
          </div>

        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a id="emailsTab" href="#emailsTab" class="mdl-layout__tab is-active">Emails</a>
          <a id="firmenTab" href="#firmenTab" class="mdl-layout__tab">Firmen</a>
          <a id="lieferantenTab" href="#lieferantenTab" class="mdl-layout__tab">Lieferanten</a>
          <a id="kundenTab" href="#kundenTab" class="mdl-layout__tab">Kunden</a>
        </div>
      </header>
      <?php
        ob_start();
        include "views/menu.php";
        $content_menu = ob_get_clean();
        echo $content_menu;
      ?>
      <main class="mdl-layout__content">
        <section class="mdl-layout__tab-panel is-active" id="emailsTab">
          <div class="page-content">

            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--2-col mdl-cell--4-col-phone"></div>
              <div class="mdl-cell mdl-cell--8-col mdl-cell--4-col-phone">
                <!-- Square card -->
                <style>
                .demo-card-square.mdl-card {
                  width: 775px;
                  height: auto;
                  margin-left: auto;
                  margin-right: auto;
                }
                .demo-card-square > .mdl-card__title {
                  color: #fff;
                  max-height: 70px;
                  background:
                  url('') bottom right 15% no-repeat #4d4d4d;
                }
                </style>
                <div class="demo-card-square mdl-card mdl-shadow--2dp">
                  <div class="mdl-card__title mdl-card--expand">
                    <h2 class="mdl-card__title-text">Settings</h2>
                  </div>
                  <div class="mdl-card__supporting-text">
                    <div class="mdl-grid">
                      <div class="settingWrapper">
                        <div class="mdl-cell mdl-cell--10-col mdl-cell--3-col-phone" style="line-height: 60px;">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which label contains the <b>incoming maintenance</b> emails?</font>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone">
                          <button id="showdialog2" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectLabelSettings" style="margin-right:5px">
                            <i class="material-icons">mail</i>
                          </button>
                          <div class="mdl-tooltip mdl-tooltip--left" for="showdialog2">
                          Select your Maintenance Label
                          </div>
                        </div>
                      </div>
                      <div class="settingWrapper">
                        <div class="mdl-cell mdl-cell--10-col mdl-cell--3-col-phone" style="line-height: 60px;">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which label should <b>completed maintenances be moved to</b>?</font>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone">
                          <button id="showdialog22" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectLabelSettings" style="margin-right:5px">
                            <i class="material-icons">mail</i>
                          </button>
                          <div class="mdl-tooltip mdl-tooltip--left" for="showdialog22">
                          Select your Maintenance Label
                          </div>
                        </div>
                      </div>
                      <div class="settingWrapper">
                        <div class="mdl-cell mdl-cell--7-col mdl-cell--3-col-phone" style="margin-top:4%">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which user should the incoming mail be based on?</font>
                          <br>
                          <font class="mdl-dialog__subtitle" style="font-size:10px;">This will determine much backend functionality like available labels, etc.</font>
                        </div>
                        <div class="mdl-cell mdl-cell--5-col mdl-cell--1-col-phone" style="margin-top:2%">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                              <input class="mdl-textfield__input userEmail" type="text" placeholder="@newtelco.de" id="userEmail">
                              <label class="mdl-textfield__label" for="userEmail">Email Address</label>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="mdl-card__actions mdl-card--border">
                    <div></div>
                    <div class="mdl-layout-spacer"></div>
                    <button id="settingSave" type="button" style="float: right;margin:5px;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                      <i class="material-icons">save</i>
                    </button>
                    <div class="mdl-tooltip mdl-tooltip--left" for="settingSave">
                    Save Settings
                    </div>
                  </div>
                </div>

              </div>
              <div class="mdl-cell mdl-cell--2-col mdl-cell--4-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="firmenTab">
          <div class="page-content">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Firmen Details</h4>
                </div>
                <div class="tableWrapper1">
                  <div class="searchWrapper">
                    Search: <input type="text" id="firmenSearch"/>
                  </div><br><br>
                  <div id="firmenTable"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="lieferantenTab">
          <div class="page-content">
            <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Lieferanten Details</h4><br><br>
                  <h6>Connection between companies and their connection ID's</h6>
                </div>
                <div class="tableWrapper1">
                  <div class="searchWrapper">
                    Search: <input type="text" id="lieferantenSearch"/>
                  </div><br><br>
                  <div id="lieferantenTable"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="kundenTab">
          <div class="page-content">
            <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Kunden Details</h4><br><br>
                  <h6>Connection between companies and our CID's</h6>
                </div>
                <div class="tableWrapper1">
                  <div class="searchWrapper">
                    Search: <input type="text" id="kundenSearch"/>
                  </div><br><br>
                  <div id="kundenTable"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
      </main>
      <div id="settingsOutput" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text" style="text-align:center;width:100%"></div>
        <button type="button" style="display:none" class="mdl-snackbar__action"></button>
      </div>

      <dialog style="width: 900px;" id="dialog3" class="mdl-dialog">
        <div class="labelSelectHeader">
          <h6 class="mdl-dialog__title labelSelectLabel">Which label are your maintenance emails in?</h6>
        </div>
        <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
          <i class="material-icons">close</i>
        </button>
        <div class="mdl-dialog__content">
          <p>

            <?php
              $service = new Google_Service_Gmail($clientService);

              $results = $service->users_labels->listUsersLabels($user);

              if (count($results->getLabels()) == 0) {
               print "No labels found.\n";
              } else {

                echo '<form action="settings" method="post">';
                echo '<div class="mdl-grid">';
                foreach ($results->getLabels() as $label) {
                  $labelColor = $label->getColor();
                  if ($labelColor['backgroundColor'] != '') {
                    echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="">' . $label->getName() . '</div>';
                  } else {
                  echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . ';">' . $label->getName() . '</div>';
                  }
                  echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" data-value="' . $label->getId() . '" value="' . $label->getId() . '"><i class="material-icons">check</i></button></div>';
                }
                echo '</form></div>';
              }

              ?>
            </p>
          </div>
        </dialog>

        <dialog style="width: 900px;" id="dialog32" class="mdl-dialog">
          <div class="labelSelectHeader">
            <h6 class="mdl-dialog__title labelSelectLabel">Which label should <b>completed maintenances be moved to</b>?</h6>
          </div>
          <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close2 labelSelectClose">
            <i class="material-icons">close</i>
          </button>
          <div class="mdl-dialog__content">
            <p>

              <?php
                $service = new Google_Service_Gmail($clientService);

                $results = $service->users_labels->listUsersLabels($user);

                if (count($results->getLabels()) == 0) {
                 print "No labels found.\n";
                } else {

                  echo '<form action="settings" method="post">';
                  echo '<div class="mdl-grid">';
                  foreach ($results->getLabels() as $label) {
                    $labelColor = $label->getColor();
                    if ($labelColor['backgroundColor'] != '') {
                      echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="">' . $label->getName() . '</div>';
                    } else {
                    echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . ';">' . $label->getName() . '</div>';
                    }
                    echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="endlabel" data-value="' . $label->getId() . '" value="' . $label->getId() . '"><i class="material-icons">check</i></button></div>';
                  }
                  echo '</form></div>';
                }

                ?>
              </p>
            </div>
          </dialog>

        <script>

          $('#settingSave').on('click', function(e) {
            var selectedUser = $('#userEmail').val();
            $.ajax({
              type: "GET",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              'url':'api?userMails=' + selectedUser,
              'success': function(result2){
                var obj = JSON.stringify(result2);
                var snackbarContainer = document.querySelector('#settingsOutput');

                if (result2.updated === 1) {
                  var settingsOutput = {
                    message: 'Successfully Saved',
                    timeout: 4000
                  };
                } else if (result2.same === 1) {
                  var settingsOutput = {
                    message: 'User already selected',
                    timeout: 4000
                  };
                } else if (result2.empty === 1) {
                  var settingsOutput = {
                    message: 'Please enter Email Address',
                    timeout: 4000
                  };
                }
                snackbarContainer.MaterialSnackbar.showSnackbar(settingsOutput);
              }
            });
          });

          var dialog = document.querySelector('#dialog3');
          var showDialogButton = document.querySelector('#showdialog2');
          if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
          }
          showDialogButton.addEventListener('click', function() {
            dialog.showModal();
          });
          dialog.querySelector('.close1').addEventListener('click', function() {
            dialog.close();
          });

          var dialog2 = document.querySelector('#dialog32');
          var showDialogButton2 = document.querySelector('#showdialog22');
          if (! dialog2.showModal) {
            dialogPolyfill.registerDialog(dialog2);
          }
          showDialogButton2.addEventListener('click', function() {
            dialog2.showModal();
          });
          dialog2.querySelector('.close2').addEventListener('click', function() {
            dialog2.close();
          });

         $('#firmenTab').click(function(){

         /*****************
          *
          *  FIRMEN Table
          *
          ******************/

          var container = document.getElementById('firmenTable');
          var hot = new Handsontable(container, {
             rowHeaders: true,
             colHeaders: true,
             contextMenu: true,
             colWidths: [100, 100, 320],
             columnSorting: true,
             colHeaders: ['Name', 'Mail Domain', 'Maintenance Recipient'],
             columns: [
              {data: 'name'},
              {data: 'mailDomain'},
              {data: 'maintenanceRecipient'}
             ],
             stretchH: 'all',
             manualColumnResize: true,
             manualRowResize: true,
             comments: true,
             autoWrapRows: true,
             preventOverflow: 'horizontal',
             filters: true,
             dropdownMenu: true,
             renderAllRows: true,
             search: true,
             search: {
               searchResultClass: 'searchResultClass'
             }
          });

          hot.addHook('afterChange', function(change,source) {
          const commentsPlugin = hot.getPlugin('comments');
            commentsPlugin.setRange({from: {row: 0, col: 1}});
            commentsPlugin.setComment('Multiple recipients should be separated by semicolon (";")');
            commentsPlugin.show();
                $.ajax('save?firmen=1', 'GET', JSON.stringify({changes: change}), function (res) {
                  var response = JSON.parse(res.response);
                  if (response.result === 'ok') {
                     console.log("Data saved");
                  }
                  else {
                     console.log("Saving error");
                  }
             });
          });

          searchField = document.getElementById('firmenSearch');

          Handsontable.dom.addEvent(searchField, 'keyup', function (event) {
            var search = hot.getPlugin('search');
            var queryResult = search.query(this.value);

            console.log(queryResult);
            hot.render();
          });

          // For Loading
          $.ajax({
            type: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            'url':'api?firmen=1',
            'success': function (res) {
              hot.loadData(res);
              hot.render();
              var firmenHeight = $('#firmenTable > .ht_master > .wtHolder > .wtHider').css( "height" );
              $('.tableWrapper1').css("height",firmenHeight);
              $('#firmenTable').css("height",firmenHeight);
              $('#firmenTable > .ht_master').css("height",firmenHeight);
              $('#firmenTable > .ht_master > .wtHolder').css("height",firmenHeight);
              $('#firmenTable > .ht_clone_left').css("height",firmenHeight);
              $('#firmenTable > .ht_clone_left > .wtHolder').css("height",firmenHeight);
              $('footer').css("min-height","76px");
              $('footer').css("max-height","76px");
            },
            'error': function () {
              console.log("Loading error");
            }
          })
        });

        $('#kundenTab').click(function(){

        /*****************
         *
         *  KUNDEN Table
         *
         ******************/

         var container3 = document.getElementById('kundenTable');
         var hot3 = new Handsontable(container3, {
            rowHeaders: true,
            colHeaders: true,
            contextMenu: true,
            colWidths: [35, 120],
            columnSorting: true,
            colHeaders: ['Kunde', 'Kunden CID'],
            columns: [
              {data: 'name'},
              {data: 'kundenCID'}
            ],
            stretchH: 'all',
            manualColumnResize: true,
            manualRowResize: true,
            comments: true,
            autoWrapRows: true,
            preventOverflow: 'horizontal',
            filters: true,
            dropdownMenu: true,
            renderAllRows: true,
            search: true,
            search: {
              searchResultClass: 'searchResultClass'
            }
         });

         // hot3.addHook('afterChange', function(change,source) {
         //       $.ajax('save?kunden=1', 'GET', JSON.stringify({changes: change}), function (res3) {
         //         var response = JSON.parse(res3.response);
         //
         //         if (response.result === 'ok') {
         //            console.log("Data saved");
         //         }
         //         else {
         //            console.log("Saving error");
         //         }
         //    });
         // });

         searchField3 = document.getElementById('kundenSearch');

         Handsontable.dom.addEvent(searchField3, 'keyup', function (event) {
           var search = hot3.getPlugin('search');
           var queryResult = search.query(this.value);

           console.log(queryResult);
           hot3.render();
         });

         // For Loading
         $.ajax({
           type: "GET",
           headers: {
             'Accept': 'application/json',
             'Content-Type': 'application/json'
           },
           'url':'api?kunden=1',
           'success': function (res3) {
             hot3.loadData(res3);
             hot3.render();
             var kundenHeight = $('#kundenTable > .ht_master > .wtHolder > .wtHider').css( "height" );
             console.log('kundenHeight: ' + kundenHeight);
             $('.tableWrapper1').css("height",kundenHeight);
             $('#kundenTable').css("height",kundenHeight);
             $('#kundenTable > .ht_master').css("height",kundenHeight);
             $('#kundenTable > .ht_master > .wtHolder').css("height",kundenHeight);
             $('#kundenTable > .ht_clone_left').css("height",kundenHeight);
             $('#kundenTable > .ht_clone_left > .wtHolder').css("height",kundenHeight);
             $('footer').css("min-height","76px");
             $('footer').css("max-height","76px");
           },
           'error': function () {
             console.log("Loading error");
           }
         })
        });

         $('#lieferantenTab').click(function(){

         /*****************
          *
          *  LIEFERANT Table
          *
          ******************/

          var container2 = document.getElementById('lieferantenTable');
          var hot2 = new Handsontable(container2, {
             rowHeaders: true,
             colHeaders: true,
             contextMenu: true,
             colWidths: [35, 120],
             columnSorting: true,
             colHeaders: ['Lieferant', 'Deren CID'],
             columns: [
              {data: 'name'},
              {data: 'derenCID'}
             ],
             stretchH: 'all',
             manualColumnResize: true,
             manualRowResize: true,
             comments: true,
             autoWrapRows: true,
             height: 'auto',
             filters: true,
             renderAllRows: true,
             dropdownMenu: true,
             search: true,
             search: {
               searchResultClass: 'searchResultClass'
             },
            //  afterChange: function (change, source) {
            //      $.ajax('save?lieferant=1', 'GET', JSON.stringify({data: this.getData()}), function (res2) {
            //        var response = JSON.parse(res2.response);
            //
            //        if (response.result === 'ok') {
            //           console.log("Data saved");
            //        }
            //        else {
            //           console.log("Saving error");
            //        }
            //   });
            // }
          });

          searchField2 = document.getElementById('lieferantenSearch');

          Handsontable.dom.addEvent(searchField2, 'keyup', function (event) {
            var search2 = hot2.getPlugin('search');
            var queryResult2 = search2.query(this.value);

            console.log(queryResult2);
            hot2.render();
          });

            // For Loading
            $.ajax({
              type: "GET",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              'url':'api?lieferanten=1',
              'success': function (res2) {
                hot2.loadData(res2);
                hot2.render();
                var lieferantenHeight = $('#lieferantenTable > .ht_master > .wtHolder > .wtHider').css( "height" );
                console.log('lieferantenHeight: ' + lieferantenHeight);
                $('.tableWrapper1').css("height",lieferantenHeight);
                $('#lieferantenTable').css("height",lieferantenHeight);
                $('#lieferantenTable > .ht_master').css("height",lieferantenHeight);
                $('#lieferantenTable > .ht_master > .wtHolder').css("height",lieferantenHeight);
                $('#lieferantenTable > .ht_clone_left').css("height",lieferantenHeight);
                $('#lieferantenTable > .ht_clone_left > .wtHolder').css("height",lieferantenHeight);
                $('footer').css("min-height","76px");
                $('footer').css("max-height","76px");
              },
              'error': function () {
                console.log("Loading error");
              }
            })
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
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="assets/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- handsontable -->
      <link href="assets/css/handsontable.min.css" rel="preload stylesheet" as="style" media="screen" onload="this.rel='stylesheet'">
</body>
</html>
