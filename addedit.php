<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

global $dbhandle;

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
  <link rel="dns-prefetch" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!--getmdl-select-->
  <link rel="stylesheet" href="assets/css/getmdl-select.min.css">
  <script defer src="assets/js/getmdl-select.min.js"></script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- flatpickr -->
  <link rel="dns-prefetch" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/flatpickr_green.css">

  <script rel="dns-prefetch" src="https://unpkg.com/flatpickr@4.5.2/dist/flatpickr.js"></script>

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
                      $msgArray[] = $subject;
                      $msgArray[] = $fromHTML;
                      $msgArray[] = $date;

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

                      $msgArray[] = $FOUND_BODY;






                  /* PREVIOUS click event functions

                    var mailID2 = $(event.target).attr(\'data-target\');
                    console.log(mailID2);
                    var dialog2 = document.querySelector(\'#viewMailID\');
                    dialog2.preventDefault();
                    event.preventDefault();
                    var showDialogButton2 = document.querySelector(\'[data-target="\' + mailID2 + \'"]\');

                    showDialogButton2.addEventListener(\'click\', function() {
                      dialog2.showModal();
                    });
                    */


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

                  $msubject = $msgInfo[2];
                  $mfrom = $msgInfo[3];
                  $mdate = $msgInfo[4];
                  $mbody = $msgInfo[5];

                  $emailBV = $token_data['email'];
                  if (($pos2 = strpos($emailBV, "@")) !== FALSE) {
                    $domainBV = substr($emailBV, strpos($emailBV, "@"));
                    $usernameBV = basename($emailBV, $domainBV);
                  }

                  $workers = array();
                  $workers[] = "ndomino";
                  $workers[] = "fwaleska";
                  $workers[] = "alissitsin";
                  $workers[] = "sstergiou";

                  if (($key = array_search($usernameBV, $workers)) !== false) {
                      unset($workers[$key]);
                      $workers = array_values($workers);
                  }

                  $derenCIDQ =  mysqli_query($dbhandle, "SELECT companies.name, kunden.derenCID FROM kunden LEFT JOIN companies ON kunden.kunde = companies.id WHERE companies.name LIKE '$olieferant'") or die(mysqli_error($dbhandle));

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
              </div>
              <?php if (! empty($oreceivedmail)) { echo '<button id="viewmailbtn" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab viewMail2">
                                                           <i class="material-icons">alternate_email</i>
                                                         </button>'; } ?>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" value="<?php echo $olieferant ?>" id="company">
                <label class="mdl-textfield__label" for="company">Lieferant</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
                  <input type="text" value="" class="mdl-textfield__input" id="#dcid" readonly>
                  <input type="hidden" value="" name="#dcid">
                  <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                  <label for="#dcid" class="mdl-textfield__label">Deren CID</label>
                  <ul for="#dcid" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                      <!-- <li class="mdl-menu__item" data-val="<?php echo $oderenCIDid ?>"><?php echo $oderenCIDid ?></li> -->
                      <?php
                        while ($row = mysqli_fetch_row($derenCIDQ)) {
                            echo '<li class="mdl-menu__item" data-val="' . $row[1] . '">' . $row[1] . '</li>';
                        }
                      ?>
                  </ul>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height">
                <input type="text" value="" class="mdl-textfield__input" id="bearbeitet" readonly>
                <input type="hidden" value="" name="bearbeitet">
                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                <label for="bearbeitet" class="mdl-textfield__label">Bearbeitet Von</label>
                <ul for="bearbeitet" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                    <li class="mdl-menu__item" data-val="<?php echo $usernameBV ?>" data-selected="true"><?php echo $usernameBV ?></li>
                    <li class="mdl-menu__item" data-val="<?php echo $workers[0] ?>"><?php echo $workers[0] ?></li>
                    <li class="mdl-menu__item" data-val="<?php echo $workers[1] ?>"><?php echo $workers[1] ?></li>
                    <li class="mdl-menu__item" data-val="<?php echo $workers[2] ?>"><?php echo $workers[2] ?></li>
                </ul>
              </div>
              <div class="mdl-textfield mdl-textfield--floating-label">
                  <input type="text" id="flatpickr" class="flatpickr" placeholder="" data-input> <!-- input is mandatory -->

                  <!-- <i class="material-icons" title="toggle" data-toggle>
                  calendar_today
                  </i>

                  <i class="material-icons" title="clear" data-clear>
                  cancel
                </i>-->
                  <label class="mdl-textfield__label" for="flatpickr">Maintenance Date/Time</label>
              </div>
              <script>
              $( '.flatpickr' ).flatpickr({
                enableTime: true,
                dateFormat: 'D, d M Y H:i:S ',
                time_24hr: true
                //"plugins": [new confirmDatePlugin({})]
              });

              </script>
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
              <?php
                $mailRecipientQ =  mysqli_query($dbhandle, "SELECT maintenanceRecipient FROM companies WHERE companies.name LIKE '$olieferant'") or die(mysqli_error($dbhandle));
                if ($row = mysqli_fetch_row($mailRecipientQ)) {
                  $mailrecipient = $row[0];
                }

              ?>
              <script>
                function openInNewTab(url) {
                  var win = window.open(url, '_blank');
                  win.focus();
                };
              </script>
              <button type="button" onclick="openInNewTab('mailto:<?php echo $mailrecipient ?>?subject=This is the subject&body=This is the body');" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                MAIL
              </button>
              <button onclick="<?php echo $ocal ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                CAL
              </button>
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
          <?php
          echo '<dialog id="mailDialog" class="mdl-dialog" style="width: 800px !important;">
                <div class="mailcSelectHeader">
                  <h4 class="labelSelectLabel"><font color="#67B246">Sub:</font> ' . $msubject . '</h4><br>
                  <h6 class="labelSelectLabel" style="font-size: 20px !important"><font color="#67B246">From:</font> ' . $mfrom . '</h6><br>
                  <h6 class="labelSelectLabel" style="font-size: 20px !important"><font color="#67B246">Date:</font> ' . $mdate . '</h6>
                  <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 mailcSelectClose">
                    <i class="material-icons">close</i>
                  </button>
                </div>

                <div class="mdl-dialog__content">
                  <p><div style="width: 750px; margin-top: 40px; ">
                   ' . $mbody . '
                  </div></p>
                </div>
              </dialog>';
            ?>
          </div>
          <div id="sbMExists" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
          </div>
          <div id="sbMAS" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
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
                  //console.log('tabledata: ' + TableData);

                  //alert(TableData);

                  $.ajax({

                   type : "POST",
                   url : "api",
                   cache : "false",
                   dataType: "json",
                   data :  {data:TableData},
                   success : function(result1){
                     //console.log('result: ' + result1.exist);
                     var obj = JSON.stringify(result1);
                       //console.log('obj.exist: ' + obj.exist);

                       if (result1.exist === 1) {
                          var snackbarContainer = document.querySelector('#sbMExists');
                          var midval = $('#rmail').val();
                          var handler = function(event) {
                            var aeURL = 'https://maintenance.newtelco.de/addedit?gmid=' + midval
                            window.location.href = aeURL;
                          };
                          var dataME = {
                            message: 'Maintenance Already Exists',
                            timeout: 4000,
                            actionHandler: handler,
                            actionText: 'OPEN'
                          };

                          snackbarContainer.MaterialSnackbar.showSnackbar(dataME);

                       } else if (result1.added === 1){
                         var snackbarContainer2 = document.querySelector('#sbMAS');
                         var dataME2 = {
                           message: 'Maintenance Successfully Saved',
                           timeout: 2000
                         };

                         snackbarContainer2.MaterialSnackbar.showSnackbar(dataME2);
                       } else {
                         alert('Invalid Response');
                       }

                   }
                  });

              }); // clicking orderSave button

          </script>
          <script>
            var dialog = document.querySelector('#mailDialog');
            var showDialogButton = document.querySelector('#viewmailbtn');
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
            	OverlayScrollbars(document.querySelectorAll("#mailDialog"), {
                className       : "os-theme-dark",
              	resize          : "both",
              	sizeAutoCapable : true
              });
            });
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
