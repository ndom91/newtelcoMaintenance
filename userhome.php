<!DOCTYPE html>
<?php
require('authenticate_google.php');

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
  <link rel='stylesheet' href='assets/css/dropdown.css'>

  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!-- pace -->
  <script src="assets/js/pace.js"></script>

</head>
<body id="mdlBody">
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
        <span class="mdl-layout-title"><img src="/assets/images/newtelco_black.png"/></span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><span class="ndl-home"></span>  Home</a>
          <a class="mdl-navigation__link" href="userhome.php"><i class="ndl-face"></i>  <?php echo $token_data['name'] ?></a>
          <a class="mdl-navigation__link" href="overview.php"><i class="ndl-overview"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming</a>
          <a class="mdl-navigation__link" href="group.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">maintenance</small></a>
          <a class="mdl-navigation__link" href="groupservice.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">service</small></a>
          <a class="mdl-navigation__link" href="addedit.php"><i class="ndl-createnew"></i></i>  Add</a>
          <a class="mdl-navigation__link" href="crm_iframe.php"><i class="ndl-work"></i>  CRM</a>
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
              <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">
                <div class="userHomeHeader">
                  <h4 class="selectGoogleLabel">Mails</h4>
                  <button id="show-dialog" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectGoogleButton">
                    <i class="material-icons">mail</i>
                  </button>
                  <div class="mdl-tooltip" for="show-dialog">
                  Select your Mailbox
                  </div>
                </div>
                  <dialog style="width: 900px;" id="dialog1" class="mdl-dialog">
                    <div class="labelSelectHeader">
                      <h6 class="mdl-dialog__title labelSelectLabel">Which label are your maintenance emails in?</h6>

                        <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
                          <i class="material-icons">close</i>
                        </button>
                    </div>
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

                            echo '<form action="userhome" method="post">';
                            echo '<div class="mdl-grid">';
                            foreach ($results->getLabels() as $label) {
                              echo '<div class="mdl-cell mdl-cell--3-col">' . $label->getName() . '</div>';
                              //printf($label->getName());

                              echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getName() . '"><i class="material-icons">check</i></button></div>';
                            }
                            echo '</form></div>';
                          }

                        ?>
                      </p>
                    </div>
                  </dialog>
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
                  </script>
                  <?php

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

                        echo '<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--4dp mailLinks" id="mailTable">
                                <thead>
                                  <tr>
                                    <th>Mail ID</th>
                                    <th class="mdl-data-table__cell--non-numeric">From</th>
                                    <th class="mdl-data-table__cell--non-numeric">Subject</th>
                                    <th class="mdl-data-table__cell--non-numeric">Snippet</th>
                                  </tr>
                                </thead>
                                <tbody>';

                          foreach ($list->getMessages() as $mlist) {

                              $message_id = $mlist->id;
                              $optParamsGet2['format'] = 'full';
                              //$optParamsGet2['maxResults'] = 5; // Return Only 5 Messages
                              //$optParamsGet2['labelId'] = $labelID;
                              $single_message = $gmail->users_messages->get('me', $message_id, $optParamsGet2);
                              $payload = $single_message->getPayload();
                              $headers = $payload->getHeaders();
                              $snippet = $single_message->getSnippet();
                              $subject = getHeader($headers, 'Subject');
                              $from = getHeader($headers, 'From');

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
                                      <td><a id="show-dialog2" data-target="' . $message_id . '">' . $message_id . '</a></td>
                                        <td>'. $from  . '</td>
                                        <td>'. $subject  . '</td>
                                        <td>'. $snippet  . '</td>
                                    </tr>';


                                echo '<dialog id="dialog_' . $message_id . '" class="mdl-dialog" style="width: 800px !important;">
                                <h4 class="mdl-dialog__title">Subject: ' . $subject . '</h4>
                                <h6 class="mdl-dialog__title" style="font-size: 24px !important">From: ' . $from . '</h6>
                                <div class="mdl-dialog__content">
                                  <p><div style="width: 750px; ">
                                   ' . $FOUND_BODY . '
                                  </div>></p>
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
                        dialog.querySelector(\'.close1\').addEventListener(\'click\', function() {
                          dialog.close();
                        });
                      }
                    }

                    var mailID2 = \'\';

                    $("#mailTable").click(function() {
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


                  if(isset($_POST['label'])) {
                    $labelID = $_POST['label'];
                  } else {
                    $labelID = '0';
                  }

                  $q = 'label:' . $labelID . ' newer_than:1d';
                  fetchMails($service, $q);


                  ?>

              </div>
              <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">
              <div class="userHomeHeader">
                <h4 class="selectGoogleLabel">Calendar</h4>
                <button id="show-dialog3" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectGoogleButton">
                  <i class="material-icons">calendar_today</i>
                </button>
                <div class="mdl-tooltip" for="show-dialog3">
                Select your Maintenance Calendar
                </div>
              </div>
                  <dialog style="width: 900px;" id="dialog3" class="mdl-dialog">
                    <div class="labelSelectHeader">
                      <h6 class="mdl-dialog__title labelSelectLabel">Which calendar are your maintenance tasks in?</h6>
                      <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
                        <i class="material-icons">close</i>
                      </button>
                    </div>
                    <div class="mdl-dialog__content">
                      <p>

                        <?php
                          $service2 = new Google_Service_Calendar($client);
                          $calendarList = $service2->calendarList->listCalendarList();

                          while(true) {

                            echo '<form action="userhome" method="post">';
                            echo '<div class="mdl-grid">';
                            foreach ($calendarList->getItems() as $calendarListEntry) {
                              echo '<div class="mdl-cell mdl-cell--3-col">' . $calendarListEntry->getSummary() . '</div>';
                              echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="cal" value="' . $calendarListEntry->getID() . '"><i class="material-icons">check</i></button></div>';
                            }

                            echo '</form></div>';
                            $pageToken = $calendarList->getNextPageToken();
                            if ($pageToken) {
                              $optParams = array('pageToken' => $pageToken);
                              $calendarList = $service->calendarList->listCalendarList($optParams);
                            } else {
                              break;
                            }
                          }
                        ?>
                      </p>
                    </div>
                  </dialog>
                  <script>
                    var dialog3 = document.querySelector('#dialog3');
                    var showDialogButton3 = document.querySelector('#show-dialog3');
                    if (! dialog3.showModal) {
                      dialogPolyfill.registerDialog(dialog3);
                    }
                    showDialogButton3.addEventListener('click', function() {
                      dialog3.showModal();
                    });
                    dialog3.querySelector('.close1').addEventListener('click', function() {
                      dialog3.close();
                    });
                  </script>
                  <?php

                  if(isset($_POST['cal'])) {
                    $calID = $_POST['cal'];
                  } else {
                    $calID = '0';
                  }
                  $optParams = array(
                    'maxResults' => 10,
                    'orderBy' => 'startTime',
                    'singleEvents' => true,
                    'timeMin' => date('c'),
                  );

                  $resultsCal = $service2->events->listEvents($calID, $optParams);
                  $events = $resultsCal->getItems();


                  if (empty($events)) {
                      echo "<br><h5>No upcoming events found.</h5><br>";
                  } else {
                      echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp calEntries" id="calTable">
                                <thead>
                                  <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Summary</th>
                                    <th class="mdl-data-table__cell--non-numeric">Creator</th>
                                    <th class="">Start</th>
                                    <th class="">End</th>
                                  </tr>
                                </thead>
                                <tbody>';

                      // print "Upcoming events:\n";
                      foreach ($events as $event) {
                          $start = $event->start->dateTime;
                          if (empty($start)) {
                              $start = $event->start->date;
                          }
                          $end = $event->end->dateTime;
                          if (empty($end)) {
                              $end = $event->end->date;
                          }

                          echo '<tr>
                                  <td>' . $event->getSummary() . '</td>
                                  <td>' . $event->creator->displayName . '</td>
                                  <td>' . $start . '</td>
                                  <td>' . $end . '</td>
                                </tr>';
                          //printf("%s (%s)\n", $event->getSummary(), $start);
                      }
                      echo '</tbody>
                        </table>';
                  }

                  ?>
              </div>
            </div>
        </main>
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
