<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="application-name" content="Newtelco Maintenance">
  <title>Newtelco Maintenance | Welcome</title>
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

  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- luxon -->
  <script src="assets/js/luxon.min.js"></script>
  <script src="assets/js/moment.js"></script>
  <script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>

  <!-- Datatables -->
  <script src="assets/js/datatables.js"></script>
  <script src="assets/css/datatables.css"></script>

  <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-html5-1.5.4/cr-1.5.0/fh-3.1.4/kt-2.5.0/datatables.min.css"/>
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-html5-1.5.4/cr-1.5.0/fh-3.1.4/kt-2.5.0/datatables.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>

  <link rel="stylesheet" type="text/css" href="assets/css/select.dataTables.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>

  <script type="text/javascript" src="assets/js/dataTables.responsive.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.dataTables.css"/>

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
      </header>
      <?php
      if(isset($_POST['label']) || isset($_SESSION['label'])) {
        if(! empty($_POST['label'])) {
        $labelID = $_POST['label'];
        $_SESSION['label'] = $labelID;
        } else {
          $labelID = $_SESSION['label'];
        }
      } else {
        if(isset($_COOKIE['label'])) {
          $labelID = $_COOKIE['label'];
        } else {
          $labelID = '0';
        }
      }

      if ($labelID != '0') {
        $service3 = new Google_Service_Gmail($clientService);
        $results3 = $service3->users_labels->get($user,$labelID);
      }

      ?>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title"><img src="/assets/images/newtelco_black.png"/></span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><span class="ndl-home"></span>  Home</a>
          <!-- <a class="mdl-navigation__link" href="userhome.php"><i class="ndl-face"></i>  <?php echo $token_data['name'] ?></a> -->
          <a class="mdl-navigation__link" href="overview.php"><i class="ndl-overview"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming<div class="material-icons mdl-badge mdl-badge--overlap menuSubLabel2" data-badge="<?php if ($labelID != '0') { if ($results3['messagesTotal'] == 0) { echo "♥"; } else { echo $results3['messagesTotal']; }} else {  echo "♥"; } ?>"></div></a></a>
          <a class="mdl-navigation__link" href="group.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">maintenance</small></a>
          <a class="mdl-navigation__link" href="groupservice.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">service</small></a>
          <a class="mdl-navigation__link" href="addedit.php"><i class="ndl-createnew"></i></i>  Add</a>
          <a class="mdl-navigation__link" href="crm_iframe.php"><i class="ndl-work"></i>  CRM</a>
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
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone incomingHeaderWrapper">
                  <div class="userHomeHeader">
                    <h4 class="selectGoogleLabel">Maintenance History</h4>
                  </div>
                </div>
                <!--
                <div class="mdl-grid tableSearchGrid">
                  <!-- <div class="mdl-cell mdl-cell--1-col">
                    <div class="searchHeaderLabel">
                      Search
                    </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-col">
                    <form action="overview" method="post">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" name="tLieferant" id="tLieferant">
                        <label class="mdl-textfield__label" for="tLieferant">Lieferant</label>
                      </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-col">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" name="tdCID" id="tdCID">
                        <label class="mdl-textfield__label" for="tdCID">deren CID</label>
                      </div>
                  </div>
                  <div class="mdl-cell mdl-cell--4-col"></div>
                  <!--
                  <div class="mdl-cell mdl-cell--2-col">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" name="tKunde" id="tKunde">
                        <label class="mdl-textfield__label" for="tKunde">Kunde</label>
                      </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-col">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" name="tuCID" id="tuCID">
                        <label class="mdl-textfield__label" for="tuCID">unsere CID</label>
                      </div>
                  </div>
                  <div class="mdl-cell mdl-cell--2-col"></div>
                  <div class="mdl-cell mdl-cell--2-col mdl-typography--text-right">
                    <button type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color--light-green-nt ">
                      <i class="material-icons">search</i>
                    </button>
                    </form>
                  </div>
                </div>-->
                <?php
                $lieferant = '';
                $tdCID = '';

                if (empty($_POST['tLieferant']) && empty($_POST['tdCID'])) {
                  $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, lieferantCID.derenCID, maintenancedb.bearbeitetvon, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailSentAt, maintenancedb.updatedAt, maintenancedb.done FROM maintenancedb  LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id");
                }

                if (! empty($_POST['tLieferant'])){
                  $lieferant = $_POST['tLieferant'];
                  $query = $lieferant;

                  // DEBUG
                  //echo '<b>Debug:</b><br>';
                  //echo '<pre>';
                  // END DEBUG

                  $lieferant_escape = mysqli_real_escape_string($dbhandle, $query);
                  $lieferant_escape = '%' . $lieferant_escape . '%';
                  // search first for existance of company
                  $lieferant_query = mysqli_query($dbhandle, "SELECT `id`,`name` FROM `companies` WHERE `name` LIKE '$lieferant_escape'");

                  if ($fetch = mysqli_fetch_array($lieferant_query)) {
                      //Found a companyn - now show all maintenances for company
                    $lieferant_id = $fetch[0];
                    $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, lieferantCID.derenCID, maintenancedb.bearbeitetvon, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailSentAt, maintenancedb.updatedAt,maintenancedb.done FROM maintenancedb  LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE lieferant LIKE '$lieferant_id'");
                  }
                } elseif (! empty($_POST['tdCID'])){
                  $tdCID = $_POST['tdCID'];
                  $query = $tdCID;

                  $dCID_escape = mysqli_real_escape_string($dbhandle, $query);
                  $dCID_escape = '%' . $dCID_escape . '%';

                  $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, lieferantCID.derenCID, maintenancedb.bearbeitetvon, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailSentAt, maintenancedb.updatedAt,maintenancedb.done FROM maintenancedb  LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.derenCIDid IN (SELECT id FROM lieferantCID WHERE derenCID LIKE '$dCID_escape' GROUP BY derenCID)");
                }

                // DEBUG
                //echo("Error description: " . mysqli_error($dbhandle));
                //echo '</pre>';
                // END DEBUG

                // class - mdl-data-table--selectable for select buttons on rows

                // mdl table class - class="mdl-data-table mdl-js-data-table  mdl-shadow--4dp" style="width: 100%"
                // non-numeric columns: class="mdl-data-table__cell--non-numeric"

                echo '<div class="dataTables_wrapper">
                <table id="dataTable1" class="table table-striped  hover nowrap" style="width: 100%">
                        <thead>
                          <tr>
                            <th style="width: max-content;"></th>
                            <th class="">id</th>
                            <th class="">Maileingang Date/Time</th>
                            <th>R Mail</th>
                            <th>Lieferant</th>
                            <th>Deren CID</th>
                            <th>Bearbeitet Von</th>
                            <th>Start Date/Time</th>
                            <th>End Date/Time</th>
                            <th>Postponed</th>
                            <th>Notes</th>
                            <th>Mail Sent At</th>
                            <th>Updated At</th>
                            <th>Complete</th>
                          </tr>
                        </thead>
                        <tbody>';

                  while ($rowx = mysqli_fetch_assoc($resultx)) {
                    echo '<tr>';
                    // button - class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"
                        echo '<td><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
                                <a class="editLink" href="addedit.php?update=1&mid=' . $rowx['id'] . '&gmid=' . $rowx['receivedmail'] . '">
                                  <i class="material-icons">edit</i>
                                </a>
                              </button></td>';

                    while (list($key, $value) = each($rowx)) {

                      if ($key == 'startDateTime') {

                        $newDate = DateTime::createFromFormat("Y-m-d  H:i:s", $value);
                        $newDate = new DateTime($value);
                        $newDate->add(new DateInterval('PT1H'));
                        $newDate = $newDate->format('Y-m-d  H:i:s'); // for example

                        echo "<td> $newDate </td>";
                      } elseif ($key == 'endDateTime') {

                        $newDate = DateTime::createFromFormat("Y-m-d  H:i:s", $value);
                        $newDate = new DateTime($value);
                        $newDate->add(new DateInterval('PT1H'));
                        $newDate = $newDate->format('Y-m-d  H:i:s'); // for example

                        echo "<td> $newDate </td>";
                      } elseif ($key == 'mailSentAt') {

                        $newDate = DateTime::createFromFormat("Y-m-d  H:i:s", $value);
                        $newDate = new DateTime($value);
                        $newDate->add(new DateInterval('PT1H'));
                        $newDate = $newDate->format('Y-m-d  H:i:s'); // for example

                        echo "<td> $newDate </td>";
                      } elseif ($key == 'maileingang') {

                        $newDate = DateTime::createFromFormat("Y-m-d  H:i:s", $value);
                        $newDate = new DateTime($value);
                        $newDate->add(new DateInterval('PT1H'));
                        $newDate = $newDate->format('Y-m-d  H:i:s'); // for example

                        echo "<td> $newDate </td>";
                      } elseif ($key == 'done') {
                        echo '<td style="text-align: center;">';
                        if ($value === '1'){
                          echo '<span class="mdi mdi-24px mdi-check-decagram mdi-dark"></span>';
                        } else {
                          echo '<span class="mdi mdi-24px mdi-checkbox-blank-circle-outline mdi-dark mdi-inactive"></span>';
                        }
                        echo '</td>';
                      } else {
                        echo "<td>$value</td>";
                      }
                    }

                    echo '</tr>';
                  }
                  echo '</tbody>
                  </table>
                  </div>';

                ?>
              </div>
            </div>
        </main>
        <script>
        $(document).ready(function() {
             var table = $('#dataTable1').DataTable( {
                  scrollx: true,
                  //stateSave: true,
                  scrollY: false,
                  select: true,
                  responsive: true,
                  order: [ 2, 'desc' ],
                  columnDefs: [
                      {
                          "targets": [ 1 ],
                          "visible": false,
                          "searchable": false
                      },
                      {
                          "targets": [ 0, 3, 13 ],
                          "visible": true,
                          "searchable": false
                      },
                      { responsivePriority: 1, targets: [ 0, 2, 3, 4, 5, 6 ] },
                      { responsivePriority: 2, targets: [ -1 ] },
                      { responsivePriority: 5, targets: [ 7, 8, 12 ] },
                      { responsivePriority: 10, targets: [ 11, 9, 10 ] },
                      {
                          targets: [2, 3, 4, 6, 7, 8, 9, 10, 13 ],
                          className: 'mdl-data-table__cell--non-numeric'
                      }
                  ]
              } );

              table.on( 'select', function ( e, dt, type, indexes ) {
                  if ( type === 'row' ) {
                      var data = table.rows( { selected: true } ).data()[0][1]
                        console.log(data);
                  }
              } );
          } );
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
