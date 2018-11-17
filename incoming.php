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
                  <div class="mdl-cell mdl-cell--1-col">
                    <div class="userHomeHeader">
                      <button id="show-dialog" type="button" class="mdl-button selectGoogleButton">Mail Label</button>
                    </div>
                    <dialog style="width: 900px;" id="dialog1" class="mdl-dialog">
                      <h4 class="mdl-dialog__title">Which label are your maintenance emails in?</h4>
                      <div class="mdl-dialog__content">
                        <p>

                          <?php
                            $service = new Google_Service_Gmail($client);

                            // Print the labels in the user's account.
                            $user = 'me';
                            $results = $service->users_labels->listUsersLabels($user);

                            if (count($results->getLabels()) == 0) {
                             print "No labels found.\n";
                            } else {

                              echo '<form action="incoming" method="post">';
                              echo '<div class="mdl-grid">';
                              foreach ($results->getLabels() as $label) {
                                echo '<div class="mdl-cell mdl-cell--2-col">' . $label->getName() . '</div>';
                                //printf($label->getName());

                                echo '<div class="mdl-cell mdl-cell--2-col"><button type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getName() . '"><i class="material-icons">add</i></button></div>';
                              }
                              echo '</form></div>';
                            }

                            ?>
                          </p>
                        </div>
                        <div class="mdl-dialog__actions">
                          <button type="button" class="mdl-button close">Close</button>
                        </div>
                      </dialog>
                    </div>



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
                  <div class="mdl-cell mdl-cell--1-col mdl-typography--text-right">
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
                              <th>R Mail Content</th>
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

                // https://stackoverflow.com/questions/32655874/cannot-get-the-body-of-email-with-gmail-php-api

                function decodeBody($body) {
                    $rawData = $body;
                    $sanitizedData = strtr($rawData,'-_', '+/');
                    $decodedMessage = base64_decode($sanitizedData);
                    if(!$decodedMessage){
                        $decodedMessage = FALSE;
                    }
                    return $decodedMessage;
                }

                function getHeader($headers, $name) {
                  foreach($headers as $header) {
                    if($header['name'] == $name) {
                      return $header['value'];
                    }
                  }
                }

                function stripHTML($html) {

                    $dom = new DOMDocument();

                    $dom->loadHTML($html);

                    $script = $dom->getElementsByTagName('script');

                    $remove = [];
                    foreach($script as $item)
                    {
                      $remove[] = $item;
                    }

                    foreach ($remove as $item)
                    {
                      $item->parentNode->removeChild($item);
                    }

                    $html = $dom->saveHTML();
                    return $html;
                }

                function fetchMails($gmail, $q) {

                try{
                    $list = $gmail->users_messages->listUsersMessages('me', array('q' => $q));
                    while ($list->getMessages() != null) {

                        foreach ($list->getMessages() as $mlist) {

                            $message_id = $mlist->id;
                            $optParamsGet2['format'] = 'full';
                            //$optParamsGet2['maxResults'] = 5; // Return Only 5 Messages
                            //$optParamsGet2['labelId'] = $labelID;
                            $single_message = $gmail->users_messages->get('me', $message_id, $optParamsGet2);
                            $payload = $single_message->getPayload();
                            $headers = $payload->getHeaders();
                            $snippet = $single_message->getSnippet();
                            $date = getHeader($headers, 'Date');
                            $subject = getHeader($headers, 'Subject');
                            $from = getHeader($headers, 'From');
                            $fromHTML = htmlentities($from);
                            if (($pos = strpos($fromHTML, "@")) !== FALSE) {
                              $domain = substr($fromHTML, strpos($fromHTML, "@") + 1);
                              $dtld = substr($fromHTML, strpos($fromHTML, "."));
                              $domain = basename($domain, $dtld);
                            }

                            // With no attachment, the payload might be directly in the body, encoded.
                            $body = $payload->getBody();
                            $FOUND_BODY = decodeBody($body['data']);

                            // If we didn't find a body, let's look for the parts
                            if(!$FOUND_BODY) {
                                $parts = $payload->getParts();
                                foreach ($parts  as $part) {
                                    if($part['body'] && $part['mimeType'] == 'text/html') {
                                        $FOUND_BODY = decodeBody($part['body']->data);
                                        break;
                                    }
                                }
                            } if(!$FOUND_BODY) {
                                foreach ($parts  as $part) {
                                    // Last try: if we didn't find the body in the first parts,
                                    // let's loop into the parts of the parts (as @Tholle suggested).
                                    if($part['parts'] && !$FOUND_BODY) {
                                        foreach ($part['parts'] as $p) {
                                            // replace 'text/html' by 'text/plain' if you prefer
                                            if($p['mimeType'] === 'text/plain' && $p['body']) {
                                                $FOUND_BODY = decodeBody($p['body']->data);
                                                break;
                                            }
                                        }
                                    }
                                    if($FOUND_BODY) {
                                        break;
                                    }
                                }
                            }
                            // Finally, print the message ID and the body



                            echo '<tr>
                                    <td><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
                                            <a class="editLink" href="addedit.php?mid=' . $rowx['id'] . '">
                                              <i class="material-icons">edit</i>
                                            </a>
                                          </button></td>
                                    <td></td>
                                    <td>'. $date  . '</td>
                                    <td><a id="show-dialog2" data-target="' . $message_id . '">' . $message_id . '</a></td>
                                    <td></td>
                                    <td>'. htmlentities($from)  . '</td>
                                    <td>'. $subject  . '</td>
                                    <td>'. $domain  . '</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>';

                              echo '<dialog id="dialog_' . $message_id . '" class="mdl-dialog" style="width: 800px !important;">
                                  <h4 class="mdl-dialog__title">Subject: ' . $subject . '</h4>
                                  <h6 class="mdl-dialog__title" style="font-size: 24px !important">From: ' . $from . '</h6>
                                  <div class="mdl-dialog__content">
                                    <p><div style="width: 750px; ">
                                     ' . stripHTML($FOUND_BODY) . '
                                    </pre></p>
                                  </div>
                                  <div class="mdl-dialog__actions">
                                    <button type="button" class="mdl-button">Fuck You</button>
                                    <button type="button" class="mdl-button close">Close</button>
                                  </div>
                                </dialog>';

                        }

                        if ($list->getNextPageToken() != null) {
                            $pageToken = $list->getNextPageToken();
                            $list = $gmail->users_messages->listUsersMessages('me', array('pageToken' => $pageToken));
                        } else {
                            break;
                        }

                    }

                echo '</tbody>
                </table>';

                echo '
                  <script>

                  var modalTriggers = document.querySelectorAll(\'.mailLinks\');

                  // Getting the target modal of every button and applying listeners
                  for (var i = modalTriggers.length - 1; i >= 0; i--) {
                        var t = modalTriggers[i].getAttribute(\'data-target\');
                        var id = \'#\' + modalTriggers[i].getAttribute(\'id\');
                        modalProcess(t, id);
                  }

                  function modalProcess(selector, button) {
                    var dialog = document.querySelector(selector);
                    var showDialogButton = document.querySelector(button);

                    if (dialog) {
                      if (!dialog.showModal) {
                        dialogPolyfill.registerDialog(dialog);
                      }
                      showDialogButton.addEventListener(\'click\', function() {
                        dialog.showModal();
                      });
                      dialog.querySelector(\'.close\').addEventListener(\'click\', function() {
                        dialog.close();
                      });
                    }
                  }

                  var mailID2 = \'\';

                  $("#dataTable3").click(function() {
                      var mailID2 = $(event.target).attr(\'data-target\');
                      console.log(mailID2);
                      var dialog2 = document.querySelector(\'#dialog_\' + mailID2);
                      var showDialogButton2 = document.querySelector(\'[data-target="\' + mailID2 + \'"]\');
                      if (! dialog2.showModal) {
                        dialogPolyfill.registerDialog(dialog);
                      }
                      showDialogButton2.addEventListener(\'click\', function() {
                        dialog2.showModal();
                      });
                      dialog2.querySelector(\'.close\').addEventListener(\'click\', function() {
                        dialog2.close();
                      });
                  });
                </script>';


                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                }


                if(isset($_POST['label'])) {
                  $labelID = $_POST['label'];
                } else {
                  $labelID = '0';
                }

                $q = 'label:' . $labelID . ' newer_than:2d';
                fetchMails($service, $q);


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
                          targets: [2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ],
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
        <script>
          var dialog = document.querySelector('#dialog1');
          var showDialogButton = document.querySelector('#show-dialog');
          if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
          }
          showDialogButton.addEventListener('click', function() {
            dialog.showModal();
          });
          dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
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
