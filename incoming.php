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
  <title>Newtelco Maintenance | Incoming</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/material.min.js"></script>

  <!-- material animations UNUSED
  <script src="node_modules/@material/animation/dist/mdc.animation.min.js"></script>
  <link rel="stylesheet" href="assets/css/material_animation.min.css"> -->

  <!-- jquery -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>

  <!-- Datatables -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/jquery.dataTables.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.material.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.select.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/dataTables/dataTables.responsive.min.js"></script>

  <!-- moment -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/moment.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="assets/js/moment/datetime-moment.min.js"></script>

  <!-- OverlayScrollbars -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/OverlayScrollbars.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="assets/js/pace.js"></script>

  <style>
    <?php echo file_get_contents("assets/css/style-ndo.min.css"); ?>
    <?php echo file_get_contents("assets/css/material-ndo.min.css"); ?>
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

    <script language="javascript" type="text/javascript">

    </script>

    <main class="mdl-layout__content">
        <div id="loading">
          <img id="loading-image" src="assets/images/Preloader_3.gif" alt="Loading..." />
        </div>
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
              <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone incomingHeaderWrapper">
                <div class="userHomeHeader">
                  <h4 class="selectGoogleLabel">Incoming Maintenance E-Mail</h4>
                  <!-- <button id="show-dialog" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectGoogleButton">
                    <i class="material-icons">mail</i>
                  </button>
                  <div class="mdl-tooltip" for="show-dialog">
                  Select your Maintenance Label
                  </div>-->
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
                            echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getId() . '"><i class="material-icons">check</i></button></div>';
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

              echo '
              <table id="dataTable3" class="mdl-data-table striped" style="width: 100%">
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
                //$script = $dom->getElementsByTagName('script');
                //$html = $dom->getElementsByTagName('html');
                //$body1 = $dom->getElementsByTagName('body');
                //$table = $dom->getElementsByTagName('table');
                $remove = [];

                foreach($script as $item) {
                  $remove[] = $item;
                }

                foreach($table as $item) {
                  $item->setAttribute("style","overflow: auto !important;");
                  $item->parentNode->setAttribute("style", "display: table !important;");
                }

                // foreach($html as $item) {
                //   //$remove[] = $item;
                // }
                //
                // foreach($body1 as $item) {
                //   //$remove[] = $item;
                // }

                foreach ($remove as $item) {
                  $item->parentNode->removeChild($item);
                }

                $nodes = $dom->getElementsByTagName('*');


                // foreach($nodes as $node)
                // {
                //     if ($node->hasAttribute('onload')) {
                //         $node->removeAttribute('onload');
                //     }
                //     if ($node->hasAttribute('onclick')) {
                //         $node->removeAttribute('onclick');
                //     }
                // }

                $html = $dom->saveHTML();
                //$html = strip_tags($html, "<table>");
                $inlineJS = "/\bon\w+=\S+(?=.*>)/";

                //$html = preg_replace('/\bon\w+=\S+(?=.*>)/g', '', $html);
                return trim($html);
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
                  $fContents = '';

                  $mFile = "msg/" . $message_id . ".html";
                  //$fContents .= stripHTML($FOUND_BODY);
                  $fContents .= $FOUND_BODY;
                  //$fPreview = substr($fContents, 0, 45);
                  //var_dump('fPreview: ' . $fPreview . '<br>');
                  //var_dump('fSnippet: ' . $snippet . '<br>');

                  if (!file_exists($mFile)) {
                    file_put_contents($mFile, $fContents);
                  }

                  echo '
                  <script>
                  /*var showMailModal = document.querySelector("#show-dialog2");
                  showMailModal.addEventListener("click", function() {
                  //$(document).ready(function() {
                    var msgid1 = showMailModal.data("target");
                    console.log("msgid1: " + msgid1);
                    var iframe = document.getElementById(\'emailBody1_\'+msgid1\');
                    iframe.src = "javascript:;";
                    var iframedoc = iframe.document;

                    console.log("begin framedoc");
                    if (iframe.contentWindow){

                      //console.log("contentWindow");
                      iframedoc = iframe.contentWindow;
                      //console.log("iframe has contentWindow");
                    } else if (iframe.contentDocument){
                     iframedoc = iframe.contentDocument.document;
                     console.log("iframe has contentDocument.document");
                    }

                    if (iframedoc) {
                      iframedoc.document.open();
                      iframedoc.document.write("' . $FOUND_BODY . '");
                      iframedoc.document.close();
                      console.log("iframedoc written");
                    } else {

                      console.log("Cannot inject dynamic contents");
                     alert(\'Cannot inject dynamic contents into iframe.\');
                    }
                  });*/
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
                            <p>
                            <div class="mailcHR">NT</div>
                              <div class="mailWrapper0">
                                <div class="mdl-textfield mdl-js-textfield mailWrapper1">
                                  <div style="display:inline-block !important;height: 100%;margin-top: 20px;" class=" mailWrapper2">
                                    <iframe importance="low" class="frameClass" style="margin-top: 20px;" height="100%" width="100%" frameborder="0" src="msg/' . $message_id . '.html" id="emailBody1_' . $message_id . '"></iframe>
                                  </div>
                                </div>
                              </div>

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
                      str1 = "emailBody";
                      var mailIDcc = str1.concat(mailID2);
                      $("#"+mailIDcc).attr(\'src\',"msggg/"+mailID2+".html");
                      $("#"+mailIDcc).attr(\'src\', function ( i, val ) { return val; });

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
                    //var_dump('labelid1: ' . $labelID);
                  }
                } else {
                  if(isset($_COOKIE['label'])) {
                    $labelID = $_COOKIE['label'];
                  } else {
                    $labelID = '0';
                  }
                }

                $labelservice = new Google_Service_Gmail($clientService);
                $user = 'ndomino@newtelco.de';
                $labelresults = $labelservice->users_labels->listUsersLabels($user);
                foreach ($labelresults->getLabels() as $labelr) {
                  $labelid1 = $labelr->getId();
                  $labelname = $labelr->getName();

                  if ($labelid1 == $labelID) {
                    $labelNameForSearch = $labelname;
                  }
                }
                //var_dump('label_results: ' . $results);
                // $q = 'label:' . $labelNameForSearch . ' newer_than:1d';
                $q = 'label:' . $labelNameForSearch . ' is:unread';
                fetchMails($service, $q);

                ?>
                </div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone mdl-2col table2">
                  <table id="dataTable2" class="hidden mdl-data-table striped" style="width: 100%">
                    <thead>
                      <tr>
                        <th class=""></th>
                        <th class="">Maileingang</th>
                        <th class="">Bearbeitet Von</th>
                        <th>Start Date/Time</th>
                        <th>Complete</th>
                        <th>ID</th>
                        <th>Received Mail ID</th>
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
            });

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
                      url: "api?liefName=" + data2,
                      dataSrc: ""
                    },
                    columns: [
                        { title: "View" },
                        { data: "maileingang" },
                        { data: "bearbeitetvon" },
                        { data: "startDateTime" },
                        { data: "done" },
                        { data: "id" },
                        { data: "receivedmail" }
                    ],
                    columnDefs: [
                      {
                          "targets": [ 0 ],
                          "visible": true,
                          "searchable": false
                      },{
                          "targets": [ 5, 6 ],
                          "visible": false,
                          "searchable": false
                      },{
                        targets: [4], render: function (a, b, data, d) {
                          if (data['done'] === '1'){
                            return '<span class="mdi mdi-24px mdi-check-decagram mdi-dark"></span>';
                          } else if (data['done'] === '0') {
                            return '<span class="mdi mdi-24px mdi-checkbox-blank-circle-outline mdi-dark mdi-inactive"></span>';
                          } else {
                            return '';
                          }
                        }
                      },{
                        targets: [0], render: function (a, b, data, d) {
                          if (data['id'] != ''){
                            return '<a href="addedit?mid='+data['id']+'&update=1&gmid='+data['receivedmail']+'"><button style=\'margin-left:auto;margin-right:auto;text-align:center;\' id=\'sendMailbtn\' type=\'button\' class=\'mdl-color--light-green-nt mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored\'><span class=\'mdi mdi-file-find mdi-24px\'></span></button></a>'
                          } else {
                            return '';
                          }
                        }
                      }
                    ],
                    responsive: true,
                    order: [ 1, 'desc' ]
                  });
                }
              })
            })

        </script>
        <script>
          /* COMMENTED BECAUSE HIDDEN SELECT LABEL DIALOG ON INCOMING PAGE
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
          }); */

          document.addEventListener("DOMContentLoaded", function() {
            //The first argument are the elements to which the plugin shall be initialized
            //The second argument has to be at least a empty object or a object with your desired options
            OverlayScrollbars(document.querySelectorAll(".mdl-dialog"), {
              className       : "os-theme-dark",
              resize          : "vertical",
              sizeAutoCapable : true
            });
            /*OverlayScrollbars(document.querySelectorAll(".frameClass"), {
              className       : "os-theme-dark",
              resize          : "vertical",
              sizeAutoCapable : false
            });*/
          });

          $( document ).ready(function() {
             setTimeout(function() {$('#loading').hide()},500);
          });

        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <!-- datatables css -->
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/responsive.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/select.dataTables.min.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/dataTables/dataTables.material.min.css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="assets/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="assets/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="assets/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- Overlay Scrollbars -->
      <link rel="preload stylesheet" as="style" type="text/css" href="assets/css/OverlayScrollbars.min.css" onload="this.rel='stylesheet'">
</body>
</html>
