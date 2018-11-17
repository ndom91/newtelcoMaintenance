<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['id_token_token']);
}

?>

<html>
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

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-html5-1.5.4/cr-1.5.0/fh-3.1.4/kt-2.5.0/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-html5-1.5.4/cr-1.5.0/fh-3.1.4/kt-2.5.0/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>

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
                <li class="mdl-menu__item"><a class="usermenuhref" href="?logout">Logout</a></li>
              </ul>
          </div>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Maintenance</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><i class="fas fa-home"></i>  Home</a>
          <a class="mdl-navigation__link" href="userhome.php"><i class="fas fa-user"></i>  <?php echo $token_data['name'] ?></a>
          <a class="mdl-navigation__link" href="overview.php"><i class="fas fa-book-open"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="fas fa-folder-plus mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming</a>
          <a class="mdl-navigation__link" href="group.php"><i class="far fa-comment-alt"></i>  Group <small style="color: #67B246">maintenance@newtelco.de</small></a>
          <a class="mdl-navigation__link" href="groupservice.php"><i class="far fa-comment-alt"></i>  Group <small style="color: #67B246">service@newtelco.de</small></a>
          <a class="mdl-navigation__link" href="addedit.php"><i class="fas fa-plus-circle"></i></i>  Add</a>
          <a class="mdl-navigation__link" target="_blank" href="https://crm.newtelco.de"><i class="fas fa-users"></i>  CRM</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link menu_logout" href="?logout">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Logout</button>
          </a>
        </nav>
      </div>
        <main class="mdl-layout__content">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                <div class="mdl-grid tableSearchGrid">
                <div class="mdl-cell mdl-cell--2-col">
                  <form action="incoming" method="post">
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
                </div>
                <?php
                $lieferant = '';
                $tdCID = '';

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
                          $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, kunden.derenCID, maintenancedb.bearbeitetvon, maintenancedb.maintenancedate, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailankunde, maintenancedb.cal, maintenancedb.done FROM maintenancedb  LEFT JOIN kunden ON maintenancedb.derenCIDid = kunden.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE lieferant LIKE '$lieferant_id'");
                        }

                } elseif (! empty($_POST['tdCID'])){
                    $tdCID = $_POST['tdCID'];
                    $query = $tdCID;

                    $dCID_escape = mysqli_real_escape_string($dbhandle, $query);
                    $dCID_escape = '%' . $dCID_escape . '%';

                    $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, kunden.derenCID, maintenancedb.bearbeitetvon, maintenancedb.maintenancedate, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailankunde, maintenancedb.cal, maintenancedb.done FROM maintenancedb  LEFT JOIN kunden ON maintenancedb.derenCIDid = kunden.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.derenCIDid IN (SELECT id FROM kunden WHERE derenCID LIKE '$dCID_escape' GROUP BY derenCID)");
                }


                  // DEBUG
                  //echo("Error description: " . mysqli_error($dbhandle));
                  //echo '</pre>';
                  // END DEBUG

                  // class - mdl-data-table--selectable for select buttons on rows

                  // mdl table class - class="mdl-data-table mdl-js-data-table  mdl-shadow--4dp" style="width: 100%"
                  // non-numeric columns: class="mdl-data-table__cell--non-numeric"

                  echo '<div class="dataTables_wrapper">
                  <table id="dataTable3" class="table table-striped compact nowrap" style="width: 100%">
                          <thead>
                            <tr>
                              <th style="width:20px!important"></th>
                              <th class="">id</th>
                              <th class="">Maileingang Date/Time</th>
                              <th>R Mail</th>
                              <th>Lieferant</th>
                              <th>Deren CID</th>
                              <th>Bearbeitet Von</th>
                              <th>Maintenance Date/Time</th>
                              <th>Start Date/Time</th>
                              <th>End Date/Time</th>
                              <th>Postponed</th>
                              <th>Notes</th>
                              <th>Mail an Kunde Date/Time</th>
                              <th>Add to Cal</th>
                              <th>Complete</th>
                            </tr>
                          </thead>
                          <tbody>';

                    while ($rowx = mysqli_fetch_assoc($resultx)) {
                      echo '<tr>';
                      // button - class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"
                          echo '<td><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
                                  <a class="editLink" href="addedit.php?mid=' . $rowx['id'] . '">
                                    <i class="material-icons">edit</i>
                                  </a>
                                </button></td>';
                      foreach($rowx as $field) {
                          if ($rowx['maileingang']) {
                            echo '<td>' . $field . '</td>';
                          } else {
                          echo '<td>' . htmlspecialchars($field) . '</td>';
                          }
                      }
                      echo '</tr>';
                  }
                  echo '</tbody>
                  </table>
                  ';


                ?>

                <table id="dataTable2" class="hidden table table-striped compact nowrap" style="width: 100%">
                          <thead>
                            <tr>
                              <th class="">ID</th>
                              <th class="">Deren CID</th>
                              <th>Unsere CID</th>
                              <th>Kunde</th>
                              <th>Sent Mail</th>
                            </tr>
                          </thead>
                      </table>
                      </div>
              </div>
            </div>
        </main>
        <script>
        $(document).ready(function() {
             var table = $('#dataTable3').DataTable( {
                  scrollx: true,
                  select: true,
                  stateSave: true,
                  columnDefs: [
                      {
                          "targets": [ 1 ],
                          "visible": false,
                          "searchable": false
                      },
                      {
                          targets: [2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14 ],
                          className: 'mdl-data-table__cell--non-numeric'
                      }
                  ]
              } );

              table.on( 'select', function ( e, dt, type, indexes ) {
                  if ( type === 'row' ) {
                      var data2 = table.rows( { selected: true } ).data()[0][5]
                            if ( $.fn.dataTable.isDataTable( '#dataTable2' ) ) {
                                table2 = $('#dataTable2').DataTable();
                                table2.destroy();
                            }
                            //window.location.hash = "#?dcid=" + data;
                            $('#dataTable2').addClass('display').removeClass('hidden');
                            $('#dataTable2').DataTable( {
                              columnDefs: [
                                  {
                                      "targets": [ 0],
                                      "visible": false,
                                      "searchable": false
                                  }
                                ]
                                  /*"processing": true,
                                  "serverSide": true,
                                 "ajax": {
                                      "url": "dCID=" + data2,
                                      "type": "GET"
                                  },
                                  "columns": [
                                      { "data": "id" },
                                      { "data": "dCID" },
                                      { "data": "uCID" },
                                      { "data": "company" }
                                  ]*/
                             } );
                            $.ajax({
                                method: 'GET',
                                url: 'api',
                                data: "dCID=" + data2,
                                dataType: 'json',
                                success: function(data) {

                                  for (var row2 in data) {
                                    $('#dataTable2 tr:last').after('<tr><td>' + data[row2][1] + '</td><td>' + data[row2][2] + '</td><td>' + data[row2][3] + '</td><td>' + data[row2][4] + '</td></tr>');
                                  }
                                  /*console.log(status);

                                  console.log(data[0]);
                                  for (var row2 in data) {

                                    var item = data[row2];
                                    console.log(item);

                                    var id = data[0];
                                    var dCID1 = data[1];
                                    var uCID1 = data[2];
                                    var company = data[3];*/

                                  //}
                                }
                            });
                  }
              })
            })

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
