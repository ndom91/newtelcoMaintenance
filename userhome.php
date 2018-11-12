<!DOCTYPE html>
<?php
require('authenticate_google.php');

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
  <link rel='stylesheet' href='assets/css/dropdown.css'>

  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?php
          function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    ?>
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
            <span class="mdl-layout-subtitle"><?php echo $token_data['email'] ?></span>
            <button id="user-profile-menu" class="mdl-button mdl-js-button mdl-userprofile-button">
              <img class="menu_userphoto" src="<?php echo $token_data['picture'] ?>"/>
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
          <a class="mdl-navigation__link" target="_blank" href="https://crm.newtelco.de"><i class="fas fa-users"></i>  CRM</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link menu_logout" href="?logout">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Logout</button>
          </a>
        </nav>
      </div>
        <main class="mdl-layout__content">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--8-col mdl-cell--4-col-phone">
                <h4>Mails</h4>

                <button id="show-dialog" type="button" class="mdl-button">Select Label</button>
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

                            echo '<form action="userhome" method="post">';
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
                  <?php

                  //https://stackoverflow.com/questions/32655874/cannot-get-the-body-of-email-with-gmail-php-api


                  function decodeBody($body) {
                      $rawData = $body;
                      $sanitizedData = strtr($rawData,'-_', '+/');
                      $decodedMessage = base64_decode($sanitizedData);
                      if(!$decodedMessage){
                          $decodedMessage = FALSE;
                      }
                      return $decodedMessage;
                  }


                  function fetchMails($gmail, $q) {

                  try{
                      $list = $gmail->users_messages->listUsersMessages('me', array('q' => $q));
                      while ($list->getMessages() != null) {
                       
                        echo '<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--4dp">
                                <thead>
                                  <tr>
                                    <th>Mail ID</th>
                                    <th class="mdl-data-table__cell--non-numeric">Subject</th>
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
                                              if($p['mimeType'] === 'text/html' && $p['body']) {
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
                                      <td><a name="' . $message_id . '" id="show-dialog2">' . $message_id . '</a><td><td>SUBJECT</td>
                                    </tr>';
                              //print_r($message_id . " <br> <br> <br> *-*-*- " . $FOUND_BODY);
                              
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

                          echo '<dialog id="dialog2" class="mdl-dialog">
                                <h4 class="mdl-dialog__title">Email Body</h4>
                                <div class="mdl-dialog__content">
                                  <p>
                                   ' . $FOUND_BODY . '
                                  </p>
                                </div>
                                <div class="mdl-dialog__actions">
                                  <button type="button" class="mdl-button">Agree</button>
                                  <button type="button" class="mdl-button close">Disagree</button>
                                </div>
                              </dialog>';
                  } catch (Exception $e) {
                      echo $e->getMessage();
                  }

                  } 
                  


                  $labelID = $_POST['label'];

                  $q = 'label:' . $labelID . ' newer_than:1d';
                  fetchMails($service, $q);

                  
                  ?>
                   
                  <script>
                    var dialog2 = document.querySelector('#dialog2');
                    var showDialogButton2 = document.querySelector('#show-dialog2');
                    if (! dialog2.showModal) {
                      dialogPolyfill.registerDialog(dialog);
                    }
                    showDialogButton2.addEventListener('click', function() {
                      dialog2.showModal();
                    });
                    dialog2.querySelector('.close').addEventListener('click', function() {
                      dialog2.close();
                    });
                  </script>

                  <?php

                  /* 
                  KIND OF WORKING
                    https://stackoverflow.com/questions/24503483/reading-messages-from-gmail-in-php-using-gmail-api/31047235

                  $labelID = $_POST['label'];

                  $optParams = [];
                  $optParams['maxResults'] = 5; // Return Only 5 Messages
                  $optParams['labelIds'] = $labelID; 
                  $messages = $service->users_messages->listUsersMessages('me',$optParams);
                  $list = $messages->getMessages();
                  $messageId = $list[0]->getId(); // Grab first Message


                  $optParamsGet = [];
                  $optParamsGet['format'] = 'full'; // Display message in payload
                  $message = $service->users_messages->get('me',$messageId,$optParamsGet);
                  $messagePayload = $message->getPayload();
                  $headers = $message->getPayload()->getHeaders();
                  $parts = $message->getPayload()->getParts();

                  $body = $parts[0]['body'];
                  $rawData = $body->data;
                  $sanitizedData = strtr($rawData,'-_', '+/');
                  $decodedMessage = base64_decode($sanitizedData);

                  var_dump($decodedMessage);

                  */


                  /*

                  https://developers.google.com/gmail/api/v1/reference/users/messages/list?apix_params=%7B%22userId%22%3A%22me%22%2C%22labelIds%22%3A%5B%22Label_187%22%5D%7D

                  $labelID = $_POST['label'];
                  $userID = 'me';

                  function listMessages($service, $userId) {
                    $pageToken = NULL;
                    $messages = array();
                    $opt_param = array('labelIDs') == $labelID;
                    do {
                      try {
                        if ($pageToken) {
                          $opt_param['pageToken'] = $pageToken;
                        }
                        $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
                        if ($messagesResponse->getMessages()) {
                          $messages = array_merge($messages, $messagesResponse->getMessages());
                          $pageToken = $messagesResponse->getNextPageToken();
                        }
                      } catch (Exception $e) {
                        print 'An error occurred: ' . $e->getMessage();
                      }
                    } while ($pageToken);

                    foreach ($messages as $message) {
                      print 'Message with ID: ' . $message->getId() . '<br/>';
                    }

                    return $messages;
                  }


                  TEST:

                  var_dump($_POST);
                  // Get emails after label has been chosen
                  if (isset($_POST['labelID'])){
                    // get emails by labelID
                    $opt_param = array('labelIDs') == 'Label_143';
                    $messagesResponse = 
                         $service->users_messages->listUsersMessages($userId, $opt_param);
                  };
                  */

                  ?>

              </div>
              <div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-phone">CS 6 (8 on tablet)</div>
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

