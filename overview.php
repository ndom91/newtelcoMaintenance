<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

?>

<html lang="en">
<head>
  <title>Newtelco Maintenance | Overview</title>

  <!-- jquery -->
  <script rel="preload" as="script" src="dist/js/jquery-3.3.1.min.js"></script>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" src="dist/js/material.min.js"></script>

  <!-- luxon -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/luxon.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment-timezone-with-data.min.js"></script>

  <!-- Datatables -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/jquery.dataTables.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.material.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.responsive.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.select.min.js"></script>

  <!-- toastify.js -->
  <script rel="preload" as="script" src="dist/js/toastify.js"></script>

  <!-- moment -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/luxon.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/pace.js"></script>

  <!-- vis.js -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/vis.js"></script>

  <!-- OverlayScrollbars -->
  <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>

  <!-- mdl modal -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/mdl-jquery-modal-dialog.js"></script>
  <style>
    <?php echo file_get_contents("dist/css/style.min.css"); ?>
    <?php echo file_get_contents("dist/css/material.min.css"); ?>
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
            <img id="loading-image" src="dist/images/Preloader_bobbleHead.gif" alt="Loading..." />
          </div>
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone incomingHeaderWrapper">
                  <div class="userHomeHeader">
                    <h4 class="selectGoogleLabel">Maintenance History</h4>
                  </div>
                </div>
                <?php

                if (empty($_POST['tLieferant']) && empty($_POST['tdCID'])) {
                  $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, lieferantCID.derenCID, maintenancedb.bearbeitetvon, maintenancedb.betroffeneKunden, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailSentAt, maintenancedb.updatedAt, maintenancedb.betroffeneCIDs, maintenancedb.done, maintenancedb.cancelled, companies.mailDomain FROM maintenancedb LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.active = 1");

                }

                echo '<div class="dataTables_wrapper">
                <table id="dataTable1" class="mdl-data-table striped" style="width: 100%">
                        <thead>
                          <tr>
                            <th style="width: max-content;"></th>
                            <th class="">ID</th>
                            <th class="">Maileingang Date/Time</th>
                            <th data-priority="10001">R Mail</th>
                            <th>Lieferant</th>
                            <th>Deren CID</th>
                            <th>Bearbeitet Von</th>
                            <th>Betroffene Kunden</th>
                            <th>Start Date/Time</th>
                            <th>End Date/Time</th>
                            <th data-priority="10001">Postponed</th>
                            <th>Notes</th>
                            <th>Mail Sent At</th>
                            <th>Updated At</th>
                            <th>Betroffene CIDs</th>
                            <th>Complete</th>
                          </tr>
                        </thead>
                        <tbody>';

                  while ($rowx = mysqli_fetch_assoc($resultx)) {
                    if ($rowx['cancelled'] == '1') {
                      echo '<tr class="strikeout">';
                    } else {
                      echo '<tr>';
                    }
                    echo '<td><a class="editLink" href="addedit.php?update=1&mid=' . $rowx['id'] . '&gmid=' . $rowx['receivedmail'] . '"><button class="mdl-color-text--primary-contrast mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored button40" style="margin-left:3px">
                    <span style="color:#fff !important; line-height: 41px !important;" class="mdi mdi-24px mdi-circle-edit-outline mdi-light"></button></a></td>';

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
                      } elseif ($key == 'name') {
                        $mailDomain = $rowx['mailDomain'];
                        echo "<td><img src='https://www.google.com/s2/favicons?domain=$mailDomain'> $value</td>";
                        
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
                <div class="chartLabel">Press <font style="font-weight:300">CTRL</font> and <font style="font-weight:300">CLICK</font> on a maintenance to open that entry in a new tab</div>
                <div class="timelinewrapper">
                  <div id="timelinevis"></div>
                </div>
              </div>
            </div>
            <!-- <div id="hideComplete" class="mdl-js-snackbar mdl-snackbar">
              <div class="mdl-snackbar__text"></div>
              <button class="mdl-snackbar__action" type="button"></button>
            </div> -->
        </main>
        <script>

         

          function openInNewTab(url) {
            var win = window.open(url, '_blank');
            win.focus();
          }

          key('alt+shift+l', function(){ 
            
            var table3 = $('#dataTable1').DataTable();
                var mid = table3.row('.selected').data();
                showDialog({
                title: 'Delete Maintenance',
                text: 'Do you really wish to delete the selected maintenance:<br><table style="color:#000;font-size:14px;"><tr><td>ID:</td><td><b>NT-' + mid[1] + '</b></td></tr><tr><td>CID:</td><td><b>' + mid[4] + ' - ' + mid[5] + '</b></td></tr><tr><td>Edited by:</td><td><b>' + mid[6] + '</b></td></tr><tr><td>Date/Time:</td><td><b>' + mid[8] + '</b> to <b>' + mid[9] + '</b></td></tr></table><br><p>From the history? There is <b>no</b> reversing this decision.</p>',
                negative: {
                  title: 'Cancel',
                },
                positive: {
                  title: 'Delete',
                  onClick: function() {$.ajax({
                    url: 'api?hider=1&mid='+mid[1],
                    success: function(result1){
                        var obj = JSON.stringify(result1);
                        if (result1.updated === 1) {
                          const deletedToast = showToaster("Maintenance Successfully Deleted");
                          deletedToast.showToast();
                          // var snackbarContainer = document.querySelector('#hideComplete');
                          // var dataSB1 = {
                          //   message: 'Maintenance Successfully Deleted',
                          //   timeout: 2000
                          // };
                          // snackbarContainer.MaterialSnackbar.showSnackbar(dataSB1);
                          setTimeout(function(){ window.location.href = 'https://'+window.location.hostname+'/overview'; }, 1000);
                        }
                    },
                    error: function (err) {

                      console.log('Error', err);
                      if (err.status === 0) {
                        alert('Failed to load data.\nPlease run this example on a server.');
                      }
                      else {
                        alert('Failed to load data.');
                      }
                    }
                  });}
                },
                cancelable: true
                }); 
            
            return false });

          $( document ).ready(function() {
            // Initialize Primary Overview Datatable
            var table = $('#dataTable1').DataTable( {
                  scrollx: true,
                  //stateSave: true,
                  scrollY: false,
                  select: true,
                  responsive: true,
                  order: [ 13, 'desc' ],

                    // 0? - Buttons
                    // 1 - ID
                    // 2 - Maileingang Date/Time
                    // 3 - R Mail
                    // 4 - Lieferant
                    // 5 - Deren CID
                    // 6 - Bearbeitet Von
                    // 7 - Betroffene Kunden
                    // 8 - Start Date/Time
                    // 9 - End Date/Time
                    // 10 - Postponed
                    // 11 - Notes
                    // 12 - Mail Sent At
                    // 13 - Updated At
                    // 14 - BetroffeneCIDs
                    // 15 - Complete
                    // 16 - Cancelled
                    // 17 - L Mail Domain

                  columnDefs: [
                      {
                        "targets": [ 12, 16, 17 ],
                        "visible": false,
                        "searchable": false
                      },
                      {
                        "targets": [ 3, 10 ],
                        "visible": false,
                        "searchable": false
                      },
                      {
                        "targets": [ 0, 3 ],
                        "visible": true,
                        "searchable": false
                      },
                      {
                        "targets": [1],
                          render: function(a, b, data, d) {
                              return 'NT-' + data[1];
                          }
                      },
                      {
                        targets: [ 7, 14 ],
                        className: "datatablesWraptext"
                      },
                      { responsivePriority: 1, targets: [ 0, 1, 3, 4, 5, 6, 13 ] },
                      { responsivePriority: 2, targets: [ -1 ] },
                      { responsivePriority: 5, targets: [ 7, 8, 12 ] },
                      { responsivePriority: 10, targets: [ 2, 11, 9, 10, 14 ] },
                      {
                        targets: [ 0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 15 ],
                        className: 'mdl-data-table__cell--non-numeric'
                      }
                  ]
              } );

            table.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var data = table.rows( { selected: true } ).data()[0][1]
                      //console.log(data);
                }
            });

            // Hide Loader
            setTimeout(function() {$('#loading').hide()},500);

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

            // load data via an ajax request. When the data is in, load the timeline
            $.ajax({
              url: 'api?timeline=1',
              success: function (data) {

                // DOM element where the Timeline will be attached
                var container = document.getElementById('timelinevis');

                // DEBUG
                str2 = JSON.stringify(data, null, 4);
                // console.log(str2);

                var DateTime = luxon.DateTime;
                var now = DateTime.local();
                var m14days = now.minus({days: 14});
                m14days = m14days.toISODate();
                var p14days = now.plus({days: 21});
                p14days = p14days.toISODate();
                var items = new vis.DataSet(data);

                // Create a DataSet (allows two way data-binding)
                // var items = new vis.DataSet([
                //   {id: 1, content: 'item 1', start: '2018-12-20'},
                //   {id: 2, content: 'item 2', start: '2018-12-14'},
                //   {id: 3, content: 'item 3', start: '2018-12-18'},
                //   {id: 4, content: 'item 4', start: '2018-12-16', end: '2018-12-19'},
                //   {id: 5, content: 'item 5', start: '2018-12-25'},
                //   {id: 6, content: 'item 6', start: '2018-12-27'}
                // ]);

                // Configuration for the Timeline
                var options = {
                  tooltip: {
                    followMouse: true,
                    overflowMethod: 'cap'
                  },
                  start: m14days,
                  end: p14days,
                  zoomMax: 1000 * 60 * 60 * 24 * 12
                };

                // Create a Timeline
                var timeline = new vis.Timeline(container, items, options);
               
                timeline.on('click', function (e) {
                  // console.log('click without ctrl');
                  // console.log(e);
                  if (e.what != 'background') {
                    if(window.event.ctrlKey) {
                      openInNewTab('https://'+window.location.hostname+'/addedit?update=1&mid='+e.item);
                    }
                  }
                })
              },
              error: function (err) {
                console.log('Error', err);
                if (err.status === 0) {
                  alert('Failed to load data.\nPlease run this example on a server.');
                }
                else {
                  alert('Failed to load data.');
                }
              }
            });
          });

          $('#dataTable1').on('responsive-resize.dt', function(e) {
            // console.log('Table Redrawn - Responsive');
            // console.log(e);
            // console.log(e.currentTarget.childNodes);
            var tbody = e.currentTarget.childNodes[3];
            // console.log(tbody.children);
            var tbodyChild = tbody.children;
            var rowStyle = $('<style />').appendTo('head');
            var fullstyle = '';

            if (typeof tbodyChild !== 'undefined') {
              for(i=0;i<tbody.children.length;i++) {
                var rowHeight = tbody.children[i].offsetHeight;
                var className = 'rowHeight' + i;
                // console.log(rowHeight);
                var firstChild = tbodyChild[i].firstChild;
                // console.log(firstChild);
                $(firstChild).addClass(className);
                var adjustedMargin = rowHeight - 61;
                adjustedMargin = adjustedMargin / 2;
                adjustedMargin = adjustedMargin - 1;
                fullstyle += '.' + className + ':before { margin-top: ' + adjustedMargin + 'px !important;}\n';
                rowStyle.text(fullstyle);
              }
            }

          });

          $('#dataTable1').on('draw.dt', function(e) {
            // console.log('Table Redrawn - Draw');
            // console.log(e);
            // console.log(e.currentTarget.childNodes);
            var tbody = e.currentTarget.childNodes[3];
            // console.log(tbody.children);
            var tbodyChild = tbody.children;
            var rowStyle = $('<style />').appendTo('head');
            var fullstyle = '';

            if (typeof tbodyChild !== 'undefined') {
              for(i=0;i<tbody.children.length;i++) {
                var rowHeight = tbody.children[i].offsetHeight;
                var className = 'rowHeight' + i;
                // console.log(rowHeight);
                var firstChild = tbodyChild[i].firstChild;
                // console.log(firstChild);
                $(firstChild).addClass(className);
                var adjustedMargin = rowHeight - 61;
                adjustedMargin = adjustedMargin / 2;
                adjustedMargin = adjustedMargin - 1;
                fullstyle += '.' + className + ':before { margin-top: ' + adjustedMargin + 'px !important;}\n';
                rowStyle.text(fullstyle);
              }
            }
          });

        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <?php  
          mysqli_close($dbhandle); 
      ?>
      <!-- mdl modal -->
      <link prefetch rel="preload stylesheet" as="style" href="dist/css/mdl-jquery-modal-dialog.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- datatables css -->
      <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/responsive.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/select.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/dataTables.material.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

      <!-- vis.js -->
      <link prefetch rel="preload stylesheet" as="style" href="dist/css/vis-timeline.min.css" type="text/css" onload="this.rel='stylesheet'">
      
      <!-- hover css -->
      <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

      <!-- toastify css -->
      <link type="text/css" rel="stylesheet" href="dist/css/toastify.css" />

      <!-- Google font -->
      <link prefetch rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

</body>
</html>
