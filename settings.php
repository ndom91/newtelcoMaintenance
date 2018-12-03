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

  <style>
    <?php echo file_get_contents("assets/css/style.031218.min.css"); ?>
    <?php echo file_get_contents("assets/css/material.031218.min.css"); ?>
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
                <li class="mdl-menu__item">Some Action</li>
                <li class="mdl-menu__item">Another Action</li>
                <li disabled class="mdl-menu__item">Disabled Action</li>
                <a class="usermenuhref" href="?logout">
                  <li class="mdl-menu__item">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="#4e4e4e" d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z" />
                    </svg>
                    Logout
                  </li></a>
              </ul>
          </div>

        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a id="emailsTab" href="#emailsTab" class="mdl-layout__tab is-active">Emails</a>
          <a id="firmenTab" href="#firmenTab" class="mdl-layout__tab">Firmen</a>
          <a id="lieferantenTab" href="#lieferantenTab" class="mdl-layout__tab">Lieferanten CIDs</a>
          <a id="kundenTab" href="#kundenTab" class="mdl-layout__tab">Kunden CIDs</a>
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
                  width: 575px;
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
                        <div class="mdl-cell mdl-cell--9-col mdl-cell--3-col-phone" style="line-height: 60px;">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which label contains the maintenance emails?</font>
                        </div>
                        <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-phone">
                          <button id="showdialog2" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectLabelSettings">
                            <i class="material-icons">mail</i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mdl-card__actions mdl-card--border">
                    <!-- <a href="index.php" class="mdl-button mdl-button--colored mdl-color-text--light-green-nt mdl-js-button mdl-js-ripple-effect">
                      Home
                    </a> -->
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
                  <h4 class="selectGoogleLabel">Lieferanten Details</h4>
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
                  <h4 class="selectGoogleLabel">Kunden Details</h4>
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

              // Print the labels in the user's account.
              $user = 'ndomino@newtelco.de';
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
                  echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getName() . '"><i class="material-icons">check</i></button></div>';
                }
                echo '</form></div>';
              }

              ?>
            </p>
          </div>
        </dialog>
        <script>


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
             height: 400,
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
            colWidths: [100, 100, 100, 320],
            columnSorting: true,
            colHeaders: ['Lieferanten CID', 'Kunden CID', 'Company'],
            columns: [
             {data: 'derenCID'},
             {data: 'kundenCID'},
             {data: 'name'}
            ],
            stretchH: 'all',
            manualColumnResize: true,
            manualRowResize: true,
            comments: true,
            autoWrapRows: true,
            height: 400,
            filters: true,
            dropdownMenu: true,
            renderAllRows: true,
            search: true,
            search: {
              searchResultClass: 'searchResultClass'
            }
         });

         hot3.addHook('afterChange', function(change,source) {
               $.ajax('save?kunden=1', 'GET', JSON.stringify({changes: change}), function (res3) {
                 var response = JSON.parse(res3.response);

                 if (response.result === 'ok') {
                    console.log("Data saved");
                 }
                 else {
                    console.log("Saving error");
                 }
            });
         });

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
             colWidths: [85, 85, 100],
             columnSorting: true,
             colHeaders: ['Name', 'Deren CID'],
             columns: [
              {data: 'name'},
              {data: 'derenCID'}
             ],
             stretchH: 'all',
             manualColumnResize: true,
             manualRowResize: true,
             height: 400,
             comments: true,
             autoWrapRows: true,
             filters: true,
             renderAllRows: true,
             dropdownMenu: true,
             search: true,
             search: {
               searchResultClass: 'searchResultClass'
             },
             afterChange: function (change, source) {
                 $.ajax('save?lieferant=1', 'GET', JSON.stringify({data: this.getData()}), function (res2) {
                   var response = JSON.parse(res2.response);

                   if (response.result === 'ok') {
                      console.log("Data saved");
                   }
                   else {
                      console.log("Saving error");
                   }
              });
            }
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
              },
              'error': function () {
                console.log("Loading error");
              }
            })
          });
        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- handsontable -->
      <link href="assets/css/handsontable.min.css" rel="preload stylesheet" as="style" media="screen" onload="this.rel='stylesheet'">
</body>
</html>
