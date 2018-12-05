<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

?>

<html lang="en">
<head>
  <title>Newtelco Maintenance | Overview</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" src="assets/js/material.min.js"></script>

  <!-- jquery -->
  <script rel="preload" as="script" src="assets/js/jquery-3.3.1.min.js"></script>

  <!-- luxon -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/luxon.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment-timezone-with-data.min.js"></script>

  <!-- Datatables -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/datatables.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/jquery.dataTables.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.bootstrap4.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.select.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.responsive.min.js"></script>

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
          <div id="loading">
            <img id="loading-image" src="assets/images/Preloader_3.gif" alt="Loading..." />
          </div>
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

          $( document ).ready(function() {
             setTimeout(function() {$('#loading').hide()},500);
          });
        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- datatables css -->
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/responsive.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/dataTables.bootstrap4.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/select.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/datatables.min.css" onload="this.rel='stylesheet'">

      <!-- bootstrap -->
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/bootstrap.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="assets/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">
</body>
</html>
