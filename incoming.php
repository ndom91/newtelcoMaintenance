<!DOCTYPE html>
<?php
require('authenticate_google.php');

global $dbhandle;

?>

<html lang="en">

<head>
    <title>Newtelco Maintenance | Incoming</title>
    <?php echo file_get_contents("views/meta.html"); ?>

    <!-- material design -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/material.min.js"></script>

    <!-- jquery -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/jquery-3.3.1.min.js"></script>

    <!-- Datatables -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/jquery.dataTables.min.js"></script>
    <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.material.min.js"></script>
    <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.select.min.js"></script>
    <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.responsive.min.js"></script>

    <!-- moment -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment.min.js"></script>
    <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/datetime-moment.min.js"></script>

    <!-- OverlayScrollbars -->
    <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
    <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
    <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>

    <!-- pace -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/pace.js"></script>

    <!-- mdl modal -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/mdl-jquery-modal-dialog.js"></script>

    <style>
      <?php 
        echo file_get_contents("dist/css/style.min.css");
        echo file_get_contents("dist/css/material.min.css");
      ?>
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
                            <h4 class="selectGoogleLabel">Incoming Maintenance E-Mail</h4>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--8-col mdl-cell--4-col-phone dataTables_wrapper mdl-2col">
                        <?php
                        $service = new Google_Service_Gmail($clientService);
                        $results = $service->users_labels->listUsersLabels($user);
                        echo '
              <table id="dataTable3" class="mdl-data-table striped" style="width: 100%">
                <thead>
                  <tr>
                    <th style="width:20px!important"></th>
                    <th class="">id</th>
                    <th class="">Maileingang Date/Time</th>
                    <th>Sender</th>
                    <th>R Mail Content</th>
                    <th>Subject</th>
                    <th>Deren CID</th>
                    <th>Bearbeitet Von</th>
                    <th>Start Date/Time</th>
                    <th>End Date/Time</th>
                    <th>Postponed</th>
                    <th>Notes</th>
                    <th>Complete</th>
                    <th>Delete</th>
                    <th>Domain</th>
                  </tr>
                </thead>
                <tbody>';
                        if ((!empty($_POST['tdCID'])) || (!empty($_POST['tLieferant']))) {
                          while ($rowx = mysqli_fetch_assoc($resultx)) {
                            echo '<tr>';
                            echo '<td>
                          <a class="editLink" href="addedit.php?mid=' . $rowx['id'] . '">
                            <button class="mdl-color--light-green-nt mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
                              <i class="material-icons">edit</i>
                            </button>
                          </a></td>';
                            foreach ($rowx as $field) {
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

                        function decodeBody($body)
                        {
                          $rawData = $body;
                          $sanitizedData = strtr($rawData, '-_', '+/');
                          $decodedMessage = base64_decode($sanitizedData);
                          if (!$decodedMessage) {
                            $decodedMessage = false;
                          }
                          return $decodedMessage;
                        }

                        function getHeader($headers, $name)
                        {
                          foreach ($headers as $header) {
                            if ($header['name'] == $name) {
                              return $header['value'];
                            }
                          }
                        }

                        function get_email_domain($email)
                        {
                          $domain = substr(strrchr($email[0], "@"), 1);
                          $result = preg_split('/(?=\.[^.]+$)/', $domain);
                          return $domain;
                        }

                        function stripHTML($html)
                        {

                          $dom = new DOMDocument();
                          $dom->loadHTML($html);
                          $remove = [];

                          foreach ($script as $item) {
                            $remove[] = $item;
                          }

                          foreach ($table as $item) {
                            $item->setAttribute("style", "overflow: auto !important;");
                            $item->parentNode->setAttribute("style", "display: table !important;");
                          }

                          foreach ($remove as $item) {
                            $item->parentNode->removeChild($item);
                          }

                          $nodes = $dom->getElementsByTagName('*');
                          $html = $dom->saveHTML();
                          $inlineJS = "/\bon\w+=\S+(?=.*>)/";
                          return trim($html);
                        }

                        function fetchMails($gmail, $q)
                        {

                          global $user;
                          try {
                            $list = $gmail->users_messages->listUsersMessages($user, array('q' => $q));
                            while ($list->getMessages() != null) {
                              foreach ($list->getMessages() as $mlist) {
                                global $user;
                                $message_id = $mlist->id;
                                $optParamsGet2['format'] = 'full';
                                //$optParamsGet2['maxResults'] = 5; // Return Only 5 Messages
                                //$optParamsGet2['labelId'] = $labelID;
                                $single_message = $gmail->users_messages->get($user, $message_id, $optParamsGet2);
                                $payload = $single_message->getPayload();
                                $headers = $payload->getHeaders();
                                $snippet = $single_message->getSnippet();
                                $date = getHeader($headers, 'Date');
                                $subject = getHeader($headers, 'Subject');
                                $from = getHeader($headers, 'From');
                                $fromHTML = htmlentities($from);
                                if (($pos = strpos($fromHTML, "@")) !== false) {
                                  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $fromHTML, $matches);
                                  $fromAddress = $matches[0];
                                  $domain = get_email_domain($matches[0]);
                                }

                                $CET = new DateTimeZone('Europe/Berlin');
                                //$date = 'Wed, 5 Dec 2018 11:51:41 +0000';

                                $date2 = new DateTime($date);
                                $timezone = $date2->getTimezone();
                                $date2 = new DateTime($date, $timezone);
                                $date2->setTimezone($CET);
                                $date2 = $date2->format('Y-m-d  H:i:s');

                                // With no attachment, the payload might be directly in the body, encoded.
                                $body = $payload->getBody();
                                $FOUND_BODY = decodeBody($body['data']);

                                // If we didn't find a body, let's look for the parts
                                if (!$FOUND_BODY) {
                                  $parts = $payload->getParts();
                                  foreach ($parts  as $part) {

                                    if ($part['body'] && $part['mimeType'] == 'text/html') {
                                      $FOUND_BODY = decodeBody($part['body']->data);
                                      break;
                                    }
                                  }
                                }
                                if (!$FOUND_BODY) {
                                  foreach ($parts  as $part) {
                                    // Last try: if we didn't find the body in the first parts,
                                    // let's loop into the parts of the parts (as @Tholle suggested).
                                    if ($part['parts'] && !$FOUND_BODY) {
                                      foreach ($part['parts'] as $p) {
                                        // replace 'text/html' by 'text/plain' if you prefer
                                        if ($p['body'] &&  $p['mimeType'] == 'text/html') {
                                          $FOUND_BODY = decodeBody($p['body']->data);
                                          break;
                                        }
                                      }
                                    }
                                    if ($FOUND_BODY) {
                                      break;
                                    }
                                  }
                                }
                                if (!$FOUND_BODY) {
                                  foreach ($parts  as $part) {
                                    if ($part['parts'] && !$FOUND_BODY) {
                                      foreach ($part['parts'] as $p) {
                                        foreach ($p['parts'] as $p2) {
                                          if ($p2['body'] && $p2['mimeType'] == 'text/plain' ||  $p2['mimeType'] == 'text/html') {
                                            $FOUND_BODY = decodeBody($p2['body']->data);
                                            break;
                                          }
                                        }
                                      }
                                    }
                                    if ($FOUND_BODY) {
                                      break;
                                    }
                                  }
                                }
                                if (!$FOUND_BODY) {
                                  $parts = $payload->getParts();
                                  foreach ($parts  as $part) {

                                    if ($part['body'] && $part['mimeType'] == 'text/plain') {
                                      $FOUND_BODY = decodeBody($part['body']->data);
                                      break;
                                    }
                                  }
                                }
                                if (!$FOUND_BODY) {
                                  foreach ($parts  as $part) {
                                    // Last try: if we didn't find the body in the first parts,
                                    // let's loop into the parts of the parts (as @Tholle suggested).
                                    if ($part['parts'] && !$FOUND_BODY) {
                                      foreach ($part['parts'] as $p) {
                                        // replace 'text/html' by 'text/plain' if you prefer
                                        if ($p['body'] &&  $p['mimeType'] == 'text/plain') {
                                          $FOUND_BODY = decodeBody($p['body']->data);
                                          break;
                                        }
                                      }
                                    }
                                    if ($FOUND_BODY) {
                                      break;
                                    }
                                  }
                                }

                                if (strpos($FOUND_BODY, 'html') == false) {
                                  $FOUND_BODY = "<html><pre>" . $FOUND_BODY;
                                  $FOUND_BODY .= "</pre></html>";
                                }

                                $FOUND_BODY = str_replace("http:", "https:", $FOUND_BODY);

                                // Finally, print the message ID and the body
                                $fContents = '';
                                $mFile = "msg/" . $message_id . ".html";
                                $fContents .= $FOUND_BODY;

                                // write html file for mail
                                if (!file_exists($mFile)) {
                                  file_put_contents($mFile, $fContents);
                                }

                                /* INCOMING TABLE */

                                echo '<tr>
                    <td>
                      <a class="hvr-icon-spin editLink" href="addedit?gmid=' . $message_id . '">
                        <button class="hvr-icon-spin mdl-color-text--primary-contrast mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored button40">
                          <span style="color:#fff !important; line-height: 41px !important;" class="hvr-icon mdi mdi-24px mdi-circle-edit-outline mdi-light">
                        </button>
                      </a>
                    </td>
                    <td></td>
                    <td>' . $date2 . '</td>
                    <td><a id="show-dialog2" class="hvr-underline-from-left" data-target="' . $message_id . '">' . $domain . ' ' . '<img src="https://www.google.com/s2/favicons?domain=' . $domain . '"></a></td>
                    <td></td>
                    <td>' . $subject . '</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <button data-button="' . $message_id . '" class="btnDelMail mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                        <span style="color:#fff !important;position: unset;" class="mdi mdi-24px mdi-delete mdi-light">
                      </button>
                    </td>
                    <td>' . $domain . '</td>
                  </tr>';


                                echo '<dialog id="dialog_' . $message_id . '" class="mdl-dialog mailDialog1" style="width: 800px;">
                    <div class="mailcSelectHeader">
                      <h6 class="labelSelectLabel"><font color="#67B246">Sub:</font> ' . $subject . '</h6><br>
                      <h6 class="sublabelSelectLabel"><font color="#67B246">From:</font> ' . $fromHTML . '</h6><br>
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
                            <div style="display:inline-block !important;margin-top: 20px;" class=" mailWrapper2">
                              <iframe onload="resizeIframe(this)" class="frameClass" style="min-width:100%;min-height:100%;margin-top: 20px;" height="100%" width="100%" frameborder="0" src="msg/' . $message_id . '.html" id="emailBody1_' . $message_id . '"></iframe>
                            </div>
                          </div>
                        </div>

                      </p>
                    </div>
                  </dialog>';
                              }

                              if ($list->getNextPageToken() != null) {
                                $pageToken = $list->getNextPageToken();
                                $list = $gmail->users_messages->listUsersMessages($user, array('pageToken' => $pageToken));
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
                    // console.log(mailID2);
                    str1 = "emailBody";
                    var mailIDcc = str1.concat(mailID2);
                    $("#"+mailIDcc).attr(\'src\',"msg/"+mailID2+".html");
                    $("#"+mailIDcc).attr(\'src\', function ( i, val ) { return val; });

                    var dialog2 = document.querySelector(\'#dialog_\' + mailID2);
                    var showDialogButton2 = document.querySelector(\'[data-target="\' + mailID2 + \'"]\');
                    if (! dialog2.showModal) {
                      dialogPolyfill.registerDialog(dialog);
                    }
                    showDialogButton2.addEventListener(\'click\', function() {
                      dialog2.showModal();
                      OverlayScrollbars(document.querySelectorAll(".mdl-dialog"), {
                        className       : "os-theme-minimal-dark",
                        resize          : "vertical",
                        sizeAutoCapable : true
                      });
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


                        if (isset($_POST['label']) || isset($_SESSION['label'])) {

                          if (!empty($_POST['label'])) {
                            $labelID = $_POST['label'];
                            $_SESSION['label'] = $labelID;
                          } else {
                            $labelID = $_SESSION['label'];
                            //var_dump('labelid1: ' . $labelID);
                          }
                        } else {
                          if (isset($_COOKIE['label'])) {
                            $labelID = $_COOKIE['label'];
                          } else {
                            $labelID = '';
                          }
                        }

                        $labelNameForSearch = '';
                        $labelservice = new Google_Service_Gmail($clientService);
                        //$user = 'ndomino@newtelco.de';
                        $labelresults = $labelservice->users_labels->listUsersLabels($user);
                        foreach ($labelresults->getLabels() as $labelr) {
                          $labelid1 = $labelr->getId();
                          $labelname = $labelr->getName();

                          if ($labelid1 == $labelID) {
                            $labelNameForSearch = $labelname;
                          }
                        }
                        if ($labelNameForSearch == '') {
                          echo '<script>
              showDialog({
                title: \'No Mailbox Labels Selected\',
                text: \'You will not see any incoming mail until you set your label preferences<br>Please go to Settings and select your <b>incoming</b> and <b>completed</b> labels.\',
                negative: {
                    title: \'Home\',
                    onClick: function() {window.location.replace("https://maintenance.newtelco.de/index")}
                },
                positive: {
                    title: \'Settings\',
                    onClick: function() {window.location.replace("https://maintenance.newtelco.de/settings")}
                },
                cancelable: true
                }); 
                </script>';
                          $labelNameForSearch = 'aaaaaaa';
                        }
                        $q = 'label:' . $labelNameForSearch . ' is:unread';
                        fetchMails($service, $q);

                        ?>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-phone mdl-2col table2">
                        <table id="dataTable2" class="hidden mdl-data-table striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class=""></th>
                                    <th class="">Maileingang</th>
                                    <th>Start Date/Time</th>
                                    <th>End Date/Time</th>
                                    <th>ID</th>
                                    <th>Received Mail ID</th>
                                    <th>Betroffene CIDs</th>
                                    <th>Deren CID</th>
                                    <th>Company</th>
                                    <th>Complete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <script>

            $('#show-dialog2').on('click',function() {
          var obj = $('.frameClass');
          obj.height = obj.contentWindow.document.body.scrollHeight;
          obj.width = obj.contentWindow.document.body.scrollWidth;
          // console.log("click: " + obj.width);

          obj.style.height = obj.contentWindow.document.body.scrollHeight+"px";
          obj.style.width = obj.contentWindow.document.body.scrollWidth+"px";
          // console.log("click: " + obj.style.width);
        })

        function resizeIframe(obj) {

          obj.height = obj.contentWindow.document.body.scrollHeight;
          obj.width = obj.contentWindow.document.body.scrollWidth;
          // console.log(obj.width);

          obj.style.height = obj.contentWindow.document.body.scrollHeight+"px";
          obj.style.width = obj.contentWindow.document.body.scrollWidth+"px";
          // console.log(obj.style.width);
        }

        $(window).on('load',function(){
            var e = $('.mailDialog1');
            e = e.contents();
            e = e.find('body');
            $(e).each(function(i, el) {
                $(el).css('overflow','auto');
            });
        });
        
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
                    "targets": [ 1, 4, 6, 7, 8, 9, 10, 11, 12, 14 ],
                    "visible": false,
                    "searchable": false
                },
                { responsivePriority: 1, targets: [ 0, 3, 5 ] },
                { responsivePriority: 2, targets: [ 0, 2, 13 ] },
                {
                    targets: [0, 2, 3, 6, 7, 14, -1 ],
                    className: 'mdl-data-table__cell--non-numeric'
                },
                {
                    targets: [ 0 ],
                    className: 'all'
                },
                {
                    targets: [ 5 ],
                    className: 'datatablesWraptext'
                },
                {
                    targets: [5], render: function (a, b, data, d) {
                      var subject = data[5];
                      if (subject.length > 70) {
                        subject = subject.substring(0,70);
                        subject += ' ...';
                        return subject;
                      } else {
                        return subject;
                      }
                    }
                }
              ]
            });

              table.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                  var data2 = table.rows( { selected: true } ).data()[0][14]
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
                        { data: "startDateTime" },
                        { data: "endDateTime" },
                        { data: "id" },
                        { data: "receivedmail" },
                        { data: "betroffeneCIDs" },
                        { data: "derenCID" },
                        { data: "name" },
                        { data: "done" }
                    ],
                    columnDefs: [
                      {
                          "targets": [ 0 ],
                          "visible": true,
                          "searchable": false
                      },{
                          "targets": [ 4, 5, 6 ],
                          "visible": false,
                          "searchable": false
                      },{
                          targets: [6], render: function (a, b, data, d) {
                            var subject = data['betroffeneCIDs'];
                            if (subject.length > 40) {
                              subject = subject.substring(0,40);
                              subject += ' ...';
                              return subject;
                            } else {
                              return subject;
                            }
                          }
                      },{
                        targets: [9], render: function (a, b, data, d) {
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
                            return '<a href="addedit?mid='+data['id']+'&update=1&gmid='+data['receivedmail']+'"><button style=\'margin-left:auto;margin-right:auto;margin-top: -3px;text-align:center;\' id=\'sendMailbtn\' type=\'button\' class=\'mdl-color--light-green-nt mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored\'><span class=\'mdi mdi-file-find mdi-24px\'></span></button></a>'
                          } else {
                            return '';
                          }
                        }
                      },
                      { responsivePriority: 1, targets: [ 0, 2, 7 ] },
                      { responsivePriority: 2, targets: [ 2, 3 ] },
                      {
                          targets: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, -1 ],
                          className: 'mdl-data-table__cell--non-numeric'
                      }
                    ],
                    responsive: true,
                    order: [ 1, 'desc' ]
                  });
                  $('#dataTable2_filter').parent("div").css("width","calc(70% - 16px)");
                  $('#dataTable2_length').parent("div").css("width","calc(30% - 16px)");
                }
              })

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

            // Hide Loader
            setTimeout(function() {$('#loading').hide()},1000);
          });

          $(".btnDelMail").click(function(){
            var mailId = $(this).attr('data-button');
            showDialog({
              title: 'Delete Incoming Maintenance Notification',
              text: 'Are you sure you want to delete this Maintenance Inbox Entry?.',
              negative: {
                  title: 'No, take me back'
              },
              positive: {
                  title: 'Yes. Delete!',
                  onClick: function(e) {
                    // console.log(e);
                    $.ajax({
                      url: 'api?mRead='+mailId,
                      success: function (data) {
                        window.location.replace("https://maintenance.newtelco.de/incoming");
                      },
                      error: function (err) {
                        console.log('Error', err);
                      }
                    });
                  }
              },
              cancelable: true
              }); 
          }); 

        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
    </div>

    <!-- mdl modal -->
    <link prefetch rel="preload stylesheet" as="style" href="dist/css/mdl-jquery-modal-dialog.css" type="text/css" onload="this.rel='stylesheet'">

    <!-- datatables css -->
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/responsive.dataTables.min.css" onload="this.rel='stylesheet'">
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/select.dataTables.min.css" onload="this.rel='stylesheet'">
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/dataTables.material.min.css" onload="this.rel='stylesheet'">

    <!-- font awesome -->
    <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

    <!-- material icons -->
    <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
    <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

    <!-- hover css -->
    <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

    <!-- Google font-->
    <link prefetch rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

</body>

</html> 