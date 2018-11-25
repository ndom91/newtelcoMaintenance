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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="application-name" content="Newtelco Maintenance">
  <title>Newtelco Maintenance | Settings</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
  <meta name="msapplication-TileColor" content="#67B246">
  <meta name="msapplication-TileImage" content="assets/images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#67B246">
  <link rel="manifest" href="manifest.json"></link>
  <link rel='stylesheet' href='assets/css/style.css'>

  <!-- handsontable -->
  <script src="assets/js/handsontable.js"></script>
  <link href="assets/css/handsontable.css" rel="stylesheet" media="screen">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- pace -->
  <script src="assets/js/pace.js"></script>

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
                <a class="usermenuhref" href="?logout"><li class="mdl-menu__item">Logout</li></a>
              </ul>
          </div>

        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a href="#emailsTab" class="mdl-layout__tab is-active">Emails</a>
          <a href="#firmenTab" class="mdl-layout__tab">Firmen</a>
          <a href="#kundenTab" class="mdl-layout__tab">Kunden CIDs</a>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title"><img src="/assets/images/newtelco_black.png"/></span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><span class="ndl-home"></span>  Home</a>
          <a class="mdl-navigation__link" href="userhome.php"><i class="ndl-face"></i>  <?php echo $token_data['name'] ?></a>
          <a class="mdl-navigation__link" href="overview.php"><i class="ndl-overview"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming</a>
          <a class="mdl-navigation__link" href="group.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">maintenance</small></a>
          <a class="mdl-navigation__link" href="groupservice.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">service</small></a>
          <a class="mdl-navigation__link" href="addedit.php"><i class="ndl-createnew"></i></i>  Add</a>
          <a class="mdl-navigation__link" target="_blank" href="crm_iframe.php"><i class="ndl-work"></i>  CRM</a>
          <a class="mdl-navigation__link" href="settings.php"><i class="ndl-settings"></i>  Settings</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link menu_logout" href="?logout">
            <button id="menuLogout" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
              <i class="material-icons">exit_to_app</i>
            </button>
            <div class="mdl-tooltip  mdl-tooltip--top" data-mdl-for="menuLogout">
              Logout
            </div>
          </a>
        </nav>
      </div>
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
        <div class="mdl-dialog__content">
          <p>

            <?php
              $service = new Google_Service_Gmail($client);

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
          <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
            <i class="material-icons">close</i>
          </button>
        </dialog>
        <script>

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
             colWidths: [100, 85, 320],
             columnSorting: true,
             colHeaders: ['Name', 'Mail Domain', 'Maintenance Recipient'],
             columns: [
              {data: 'name'},
              {data: 'mailDomain'},
              {data: 'maintenanceRecipient'}
             ],
             
             stretchH: 'all',
             manualColumnMove: true,
             manualColumnResize: true,
             manualRowMove: true,
             manualRowResize: true,
             contextMenu: true,
             comments: true,
             autoWrapRows: true,
             height: 400,
             search: true,
             search: {
               searchResultClass: 'searchResultClass'
             },
             cell: [
               {row: 1, col: 4, comment: {value: 'Multiple recipients should be separated by semicolon (";")'}},
               {row: 1, col: 3, comment: {value: 'Email address ending'}}
             ],
             afterChange: function (change, source) {
                 $.ajax('save', 'GET', JSON.stringify({data: this.getData()}), function (res) {
                   var response = JSON.parse(res.response);

                   if (response.result === 'ok') {
                      console.log("Data saved");
                   }
                   else {
                      console.log("Saving error");
                   }
              });
            }
          });

          searchField = document.getElementById('firmenSearch');

          Handsontable.dom.addEvent(searchField, 'keyup', function (event) {
            var search = hot.getPlugin('search');
            var queryResult = search.query(this.value);

            console.log(queryResult);
            hot.render();
          });

          $( document ).ready(function() {
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

        /*****************
         * 
         *  KUNDEN Table
         * 
         ******************/

          var container2 = document.getElementById('kundenTable');
          var hot2 = new Handsontable(container2, {
             rowHeaders: true,
             colHeaders: true,
             contextMenu: true,
             colWidths: [85, 85, 100],
             columnSorting: true,
             colHeaders: ['Deren CID', 'Unsere CID', 'Kunde'],
             columns: [
              {data: 'derenCID'},
              {data: 'unsereCID'},
              {data: 'name'}
             ],
             
             stretchH: 'all',
             manualColumnMove: true,
             manualColumnResize: true,
             manualRowMove: true,
             manualRowResize: true,
             contextMenu: true,
             height: 400,
             comments: true,
             autoWrapRows: true,
             search: true,
             search: {
               searchResultClass: 'searchResultClass'
             },
             cell: [
               {row: 1, col: 4, comment: {value: 'Multiple recipients should be separated by semicolon (";")'}},
               {row: 1, col: 3, comment: {value: 'Email address ending'}}
             ],
             afterChange: function (change, source) {
                 $.ajax('save', 'GET', JSON.stringify({data: this.getData()}), function (res2) {
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

          searchField2 = document.getElementById('kundenSearch');

          Handsontable.dom.addEvent(searchField2, 'keyup', function (event) {
            var search2 = hot2.getPlugin('search');
            var queryResult2 = search2.query(this.value);

            console.log(queryResult2);
            hot2.render();
          });

          $( document ).ready(function() {
            // For Loading
            $.ajax({
              type: "GET",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              'url':'api?kunden=1',
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
        <footer class="mdl-mini-footer mdl-grid">
            <div class="mdl-mini-footer__left-section mdl-cell mdl-cell--10-col mdl-cell--middle">
              <span class="mdl-logo">Newtelco GmbH</span>
              <ul class="mdl-mini-footer__link-list">
                <li><a href="#">Help</a></li>
                <li><a href="#">Privacy & Terms</a></li>
              </ul>
            </div>
          <div class="mdl-layout-spacer"></div>
            <div class="mdl-mini-footer__right-section mdl-cell mdl-cell--2-col mdl-cell--middle mdl-typography--text-right">
              <div class="footertext">
                built with <span class="love">&hearts;</span> by <a target="_blank" class="footera" href="https://github.com/ndom91">ndom91</a> &copy;
              </div>
            </div>
        </footer>
      </div>
</body>
</html>
