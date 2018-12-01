<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

if(isset($_POST['label']) || isset($_SESSION['label'])) {
  if(isset($_POST['label'])) {
    $labelID2 = $_POST['label'];
  } else {
    $labelID2 = $_SESSION['label'];
  }

  setcookie("label", $labelID2, strtotime( '+30 days' ));
}

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
  <link rel="dns-prefetch" rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100.300.400,700" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <script src="node_modules/@material/animation/dist/mdc.animation.min.js"></script>
  <link rel="stylesheet" href="assets/css/material_animation.min.css">
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

  <script type="text/javascript" src="assets/js/dataTables.responsive.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.dataTables.css"/>


  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>

  <!-- OverlayScrollbars -->
  <link type="text/css" href="assets/css/OverlayScrollbars.css" rel="stylesheet"/>
  <script type="text/javascript" src="assets/js/OverlayScrollbars.js"></script>

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
                      <h4 class="selectGoogleLabel">Incoming Maintenance E-Mail</h4>
                      <!-- <button id="show-dialog" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectGoogleButton">
                        <i class="material-icons">mail</i>
                      </button> -->
                      <div class="mdl-tooltip" for="show-dialog">
                      Select your Maintenance Label
                      </div>
                    </div>
                    <dialog style="width: 900px;" id="dialog1" class="mdl-dialog">
                      <div class="labelSelectHeader">
                        <h6 class="mdl-dialog__title labelSelectLabel">Which label are your maintenance emails in?</h6>

                          <button tabindex="-1" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
                            <i class="material-icons">close</i>
                          </button>
                      </div>
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

                              echo '<form action="incoming" method="post">';
                              echo '<div class="mdl-grid">';
                              foreach ($results->getLabels() as $label) {
                                $labelColor = $label->getColor();
                                if ($labelColor['backgroundColor'] != '') {
                                  echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . '; background-color: ' . $labelColor['backgroundColor'] . '; box-shadow: 0px 0px 55px ' . $labelColor['backgroundColor'] . '">' . $label->getName() . '</div>';
                                } else {
                                echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . '; background-color: ' . $labelColor['backgroundColor'] . ';">' . $label->getName() . '</div>';
                                }
                                echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getName() . '"><i class="material-icons">check</i></button></div>';
                              }
                              echo '</form></div>';
                            }

                            ?>
                          </p>
                        </div>
                      </dialog>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone dataTables_wrapper mdl-2col">
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
                          $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, kunden.derenCID, maintenancedb.bearbeitetvon, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailankunde, maintenancedb.done FROM maintenancedb  LEFT JOIN kunden ON maintenancedb.derenCIDid = kunden.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE lieferant LIKE '$lieferant_id'");
                        }

                } elseif (! empty($_POST['tdCID'])){
                    $tdCID = $_POST['tdCID'];
                    $query = $tdCID;

                    $dCID_escape = mysqli_real_escape_string($dbhandle, $query);
                    $dCID_escape = '%' . $dCID_escape . '%';

                    $resultx = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, kunden.derenCID, maintenancedb.bearbeitetvon, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailankunde, maintenancedb.done FROM maintenancedb  LEFT JOIN kunden ON maintenancedb.derenCIDid = kunden.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.derenCIDid IN (SELECT id FROM kunden WHERE derenCID LIKE '$dCID_escape' GROUP BY derenCID)");
                }


                  // DEBUG
                  //echo("Error description: " . mysqli_error($dbhandle));
                  //echo '</pre>';
                  // END DEBUG

                  // class - mdl-data-table--selectable for select buttons on rows

                  // mdl table class - class="mdl-data-table mdl-js-data-table  mdl-shadow--4dp" style="width: 100%"
                  // non-numeric columns: class="mdl-data-table__cell--non-numeric"

                  echo '
                  <table id="dataTable3" class="table table-striped compact nowrap order-column hover" style="width: 100%">
                          <thead>
                            <tr>
                              <th style="width:20px!important"></th>
                              <th class="">id</th>
                              <th class="">Maileingang Date/Time</th>
                              <th>Mail ID</th>
                              <th>R Mail Content</th>
                              <th>Sender</th>
                              <th>Deren CID</th>
                              <th>Bearbeitet Von</th>
                              <th>Start Date/Time</th>
                              <th>End Date/Time</th>
                              <th>Postponed</th>
                              <th>Notes</th>
                              <th>Complete</th>
                              <th>Domain</th>
                            </tr>
                          </thead>
                          <tbody>';
                    if ((! empty($_POST['tdCID'])) || (! empty($_POST['tLieferant']))) {
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

                function get_email_domain($email) {
                  $domain = substr(strrchr($email[0], "@"), 1);
                  $result = preg_split('/(?=\.[^.]+$)/', $domain);
                  return $domain;
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
                              preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $fromHTML, $matches);
                              $fromAddress = $matches[0];
                              $domain = get_email_domain($matches[0]);
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

                            echo '
                            <script>
                            (function() {
                              var iframe = document.getElementById(\'emailBody_' . $message_id . '\');
                              var iframedoc = iframe.document;

                              console.log("begin framedoc");
                              if (iframe.contentDocument){

                                console.log("contentDocument");
                                iframedoc = iframe.contentDocument;
                                console.log("iframe has contentDocument");
                              } else if (iframe.contentWindow){
                               iframedoc = iframe.contentWindow.document;
                               console.log("iframe has contentWindow.document");
                              }

                              if (iframedoc) {
                                //iframedoc.open();
                                iframedoc.write(' . stripHTML($FOUND_BODY) . ');
                                iframedoc.close();
                                console.log("iframedoc is not NULL");
                              } else {

                                console.log("Cannot inject dynamic contents");
                               alert(\'Cannot inject dynamic contents into iframe.\');
                              }
                            })();
                            </script>';

                            echo '<tr>
                                    <td><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
                                          <a class="editLink" href="addedit?gmid=' . $message_id . '">
                                              <i class="material-icons">edit</i>
                                            </a>
                                          </button></td>
                                    <td></td>
                                    <td>'. $date  . '</td>
                                    <td><a id="show-dialog2" data-target="' . $message_id . '">' . $message_id . '</a></td>
                                    <td></td>
                                    <td>'. $from . '('. $domain . ')' . '</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>' . $domain . '</td>
                                  </tr>';

                              echo '<dialog id="dialog_' . $message_id . '" class="mdl-dialog mailDialog1" style="width: 800px;">
                                    <div class="mailcSelectHeader">
                                      <h4 class="labelSelectLabel"><font color="#67B246">Sub:</font> ' . $subject . '</h4><br>
                                      <h6 class="sublabelSelectLabel"><font color="#67B246">From:</font> ' . htmlentities($from) . '</h6><br>
                                      <h6 class="sublabelSelectLabel"><font color="#67B246">Date:</font> ' . $date . '</h6>
                                      <button tabindex="-1" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 mailcSelectClose">
                                        <i class="material-icons">close</i>
                                      </button>
                                    </div>

                                    <div class="mdl-dialog__content">
                                      <p><div style="width: 750px; margin-top: 40px; ">
                                        <div class="mdl-textfield mdl-js-textfield" style="margin-left: auto !important; margin-right: auto !important; width: 95% !important;">
                                          <div contenteditable="true" class="mdl-textfield__input" type="text" rows= "3" style="width:100% !important; height: 100% !important;" id="sample5" >' . stripHTML($FOUND_BODY) . '</div>

                                        </div>
                                        <!-- <iframe height="100%" width="100%" frameborder="0" id="emailBody_' . $message_id . '"></iframe> -->
                                      </p>
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
                      dialog.querySelector(\'.close1\').addEventListener(\'click\', function() {
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
                      dialog2.querySelector(\'.close1\').addEventListener(\'click\', function() {
                        dialog2.close();
                      });
                  });
                </script>';


                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                }


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

                $q = 'label:' . $labelID . ' newer_than:7d';
                fetchMails($service, $q);

                ?>
                </div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone mdl-2col table2">
                  <table id="dataTable2" class="hidden table table-striped compact nowrap" style="width: 100%">
                    <thead>
                      <tr>
                        <th class="">ID</th>
                        <th class="">Deren CID</th>
                        <th>Unsere CID</th>
                        <th>Kunde</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
        </main>
        <script>
        $(document).ready(function() {

            $.fn.dataTable.moment( 'ddd, DD MMM YYYY HH:mm:SS ZZ' );

             var table = $('#dataTable3').DataTable( {
                  scrollx: true,
                  select: true,
                  stateSave: true,
                  responsive: true,
                  scrolly: false,
                  columnDefs: [
                      {
                          "targets": [ 1, 4, 6, 7, 8, 9, 10, 11, 12, 13 ],
                          "visible": false,
                          "searchable": false
                      },
                      { responsivePriority: 1, targets: [ 0, 2, 5 ] },
                      { responsivePriority: 2, targets: [ 3 ] },
                      {
                          targets: [2, 3, 5 ],
                          className: 'mdl-data-table__cell--non-numeric'
                      },
                      {
                          targets: [ 0, 3, 5 ],
                          className: 'all'
                      }
                  ]
              } );

              table.on( 'select', function ( e, dt, type, indexes ) {
                  if ( type === 'row' ) {
                      var data2 = table.rows( { selected: true } ).data()[0][13]
                            if ( $.fn.dataTable.isDataTable( '#dataTable2' ) ) {
                                table2 = $('#dataTable2').DataTable();
                                table2.destroy();
                            }
                            $('#dataTable2').addClass('display').removeClass('hidden');
                            $('#dataTable2').DataTable( {
                              ajax: {
                                url: "api?dKName=" + data2,
                                dataSrc: ""
                              },
                              columns: [
                                  { data: "id" },
                                  { data: "derenCID" },
                                  { data: "unsereCID" },
                                  { data: "name" }
                              ],
                              columnDefs: [
                                  {
                                      "targets": [ 0 ],
                                      "visible": false,
                                      "searchable": false
                                  }
                                ]
                             } );
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
          dialog.querySelector('.close1').addEventListener('click', function() {
            dialog.close();
          });

          document.addEventListener("DOMContentLoaded", function() {
            //The first argument are the elements to which the plugin shall be initialized
            //The second argument has to be at least a empty object or a object with your desired options
            OverlayScrollbars(document.querySelectorAll(".mdl-dialog"), {
              className       : "os-theme-dark",
              resize          : "both",
              sizeAutoCapable : true
            });
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
