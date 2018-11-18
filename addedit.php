<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['id_token_token']);
}

/*
$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$client1 = new Google_Client();
$client1->setAuthConfig($oauth_credentials);
$client1->setRedirectUri($redirect_uri);
$client1->setScopes('https://www.googleapis.com/auth/userinfo.email');
$client1->setApplicationName("NT_User_Info");
$apiKey = 'AIzaSyDwfqT6lZld67Py1WwZ9x-6HHVkv9_p-y8';


$client1->setDeveloperKey($apiKey);
$oauth2 = new \Google_Service_Oauth2($client1);
$userInfo = $oauth2->userinfo->get();
print_r($userInfo);
*/

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

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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

          <?php
            // Default Values (empty)
            $otitlestring = 'Add';
            $omaileingang = '';
            $oreceivedmail = '';
            $olieferant = '';
            $oderenCIDid = '';
            $obearbeitetvon = '';
            $omaintenancedate = '';
            $ostartdatetime = '';
            $oenddatetime = '';
            $opostponed = '';
            $onotes = '';
            $omailankunde = '';
            $ocal = '';
            $odone = '';

            if (isset($_GET['mid'])) {

              $activeID = $_GET['mid'];

              $mID_escape = mysqli_real_escape_string($dbhandle, $activeID);
              $mID_query = mysqli_query($dbhandle, "SELECT * FROM `maintenancedb` WHERE `id` LIKE $mID_escape");
              $mIDresult = mysqli_fetch_array($mID_query);

              $otitlestring = 'Edit';
              $omaileingang = $mIDresult['maileingang'];
              $oreceivedmail = $mIDresult['receivedmail'];
              $olieferant = $mIDresult['lieferant'];
              $oderenCIDid = $mIDresult['derenCIDid'];
              $obearbeitetvon = $mIDresult['bearbeitetvon'];
              $omaintenancedate = $mIDresult['maintenancedate'];
              $ostartdatetime = $mIDresult['startDateTime'];
              $oenddatetime = $mIDresult['endDateTime'];
              $opostponed = $mIDresult['postponed'];
              $onotes = $mIDresult['notes'];
              $omailankunde = $mIDresult['mailankunde'];
              $ocal = $mIDresult['cal'];
              if ($mIDresult['done'] == 1) {
                $odone = 'checked';
              } else {
                $odone = '';
              }
            } elseif (isset($_GET['gmid'])) {

              $gmid = $_GET['gmid'];

              $service2 = new Google_Service_Gmail($client);

              // Print the labels in the user's account.
              $user = 'me';

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

              function getMessage2($service, $userId, $message_id) {
                try {
                      $msgArray = array();

                      $optParamsGet2['format'] = 'full';
                      $single_message = $service->users_messages->get($userId, $message_id,$optParamsGet2);

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

                      $msgArray[] = $date;
                      $msgArray[] = $domain;

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

                  $("#addEditDetails").click(function() {
                      var mailID2 = $(event.target).attr(\'data-target\');
                      console.log(mailID2);
                      var dialog2 = document.querySelector(\'#viewMailID\');
                      dialog2.preventDefault();
                      event.preventDefault();

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
                  return $msgArray;
                }

                $msgInfo = getMessage2($service2, $user, $gmid);

                $otitlestring = 'Edit';
                $omaileingang = $msgInfo[0];
                $oreceivedmail = $gmid;
                $olieferant = $msgInfo[1];


              }
            ?>

        <!-- EDIT MODE -->

        <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone" id="addEditDetails">
        <style>
        .demo-card-wide.mdl-card {
          width: 100%;
          margin-top: 3%;
        }
        .demo-card-wide > .mdl-card__title {
          color: #fff;
          height: 65px;
          background: #4d4d4d;
        }
        .demo-card-wide > .mdl-card__menu {
          color: #fff;
        }
        </style>

        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $otitlestring ?> Maintenance Entry</h2>
          </div>
          <div class="mdl-card__supporting-text">
            <form action="#">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $omaileingang ?>" id="medt">
                <label class="mdl-textfield__label" for="medt">Maileingang Date/Time</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $oreceivedmail ?>" id="rmail">
                <label class="mdl-textfield__label" for="rmail">Incoming Mail ID</label>
                <?php if (! empty($oreceivedmail)) { echo '<button id="viewMailID" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab viewMail2">
                          <i class="material-icons">view</i>
                      </button>'; } ?>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $olieferant ?>" id="company">
                <label class="mdl-textfield__label" for="company">Lieferant</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $oderenCIDid ?>" id="dcid">
                <label class="mdl-textfield__label" for="dcid">Deren CID</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $obearbeitetvon ?>" id="bearbeitet">
                <label class="mdl-textfield__label" for="bearbeitet">Bearbeitet Von</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $omaintenancedate ?>" id="mdt">
                <label class="mdl-textfield__label" for="mdt">Maintenance Date/Time</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $ostartdatetime ?>" id="sdt">
                <label class="mdl-textfield__label" for="sdt">Start Date/Time</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $oenddatetime ?>" id="edt">
                <label class="mdl-textfield__label" for="edt">End Date/Time</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $opostponed ?>" id="pponed">
                <label class="mdl-textfield__label" for="pponed">Postponed</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $onotes ?>" id="notes">
                <label class="mdl-textfield__label" for="notes">Notes</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $omailankunde ?>" id="makdt">
                <label class="mdl-textfield__label" for="makdt">Mail an Kunde Date/Time</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $ocal ?>" id="cal">
                <label class="mdl-textfield__label" for="cal">Add to Cal</label>
              </div>
              <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                <input type="checkbox" id="switch-2" class="mdl-switch__input" <?php echo $odone ?>>
                <span class="mdl-switch__label">Completed</span>
              </label>
                    </form>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <a id="btnSave" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Save
                      </a>
                      <!-- <a href="incoming.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Back
                      </a> -->
                    </div>
                  </div>
              </div>
              <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">

                <h4>kunden datatable</h4>
              </div>
            </div>

      <script>

        $('#btnSave').on('click', function(e) {

                e.preventDefault();

                //alert('Maintenance Saved');

                //console.log($('#rmail').text());

                var TableData = new Array();


                TableData[0] = {

                  "omaileingang" : $('#medt').val(),
                  "oreceivedmail" : $('#rmail').val(),
                  "olieferant" : $('#company').val(),
                  "oderenCIDid" : $('#dcid').val(),
                  "obearbeitetvon" : $('#bearbeitet').val(),
                  "omaintenancedate" : $('#mdt').val(),
                  "ostartdatetime" : $('#sdt').val(),
                  "oenddatetime" : $('#edt').val(),
                  "opostponed": $('#pponed').val(),
                  "onotes" : $('#notes').val(),
                  "omailankunde" : $('#makdt').val(),
                  "ocal" : $('#cal').val(),
                  "odone" : $('#switch-2:checked').val()

                  }

                  //TableData = JSON.stringify(TableData);
                  console.log('tabledata: ' + TableData);

                  //alert(TableData);

                  $.ajax({

                   type : "POST",
                   url : "api",
                   cache : "false",
                   dataType: "json",
                   data :  {data:TableData},
                   success : function(result){
                     console.log('result: ' + result);
                   }
                  });

              }); // clicking orderSave button

          </script>
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
