<!DOCTYPE html>
<?php
require('authenticate_google.php');
require_once('config.php');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

global $dbhandle;

?>

<html lang="en">
<head>
  <title>Newtelco Maintenance | Edit</title>
  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- moment -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/luxon.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/moment/moment-timezone-with-data.min.js"></script>

  <!-- jquery -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/jquery-3.3.1.min.js"></script>

  <!-- select2 -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/select2_4.0.6-rc1.min.js"></script>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/material.min.js"></script>

  <!--getmdl-select-->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/mdl-selectfield.min.js"></script>

  <!-- flatpickr -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/flatpickr.min.js"></script>

  <!-- materialize (multiselect) -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/materialize.min.js"></script>

  <!-- Datatables -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/jquery.dataTables.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.material.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.select.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/dataTables/dataTables.responsive.min.js"></script>

  <!-- OverlayScrollbars -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/pace.js"></script>

  <!-- SheetJS -->
  <script rel="preload" as="script" type="text/javascript" lang="javascript" src="dist/js/xlsx.full.min.js"></script>
  <script rel="preload" as="script" type="text/javascript" lang="javascript" src="https://unpkg.com/canvas-datagrid/dist/canvas-datagrid.js"></script>

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
            <img id="loading-image" src="dist/images/Preloader_4.gif" alt="Loading..." />
          </div>
          <div class="mdl-grid">

          <?php


            $otitlestring = 'Add';
            $omaileingang = '';
            $oreceivedmail = '';
            $olieferant = '';
            $olieferantID = '';
            $oderenCIDid = '';
            $obearbeitetvon = '';
            $omaintenancedate = '';
            $ostartdatetime = '';
            $oenddatetime = '';
            $opostponed = '';
            $onotes = '';
            $omailSentAt = '';
            $ocal = '';
            $odone = '';
            $update = '0';


            if(isset($_GET['update'])) {
              $update = '1';
            }

            if (isset($_GET['mid'])) {

              $activeID = $_GET['mid'];

              $mID_escape = mysqli_real_escape_string($dbhandle, $activeID);
              $mID_query = mysqli_query($dbhandle, "SELECT * FROM `maintenancedb` WHERE `id` LIKE $mID_escape");
              $mIDresult = mysqli_fetch_array($mID_query);

              $otitlestring = 'Edit';
              $omaintid = $mIDresult['id'];
              $omaileingang = $mIDresult['maileingang'];
              $oreceivedmail = $mIDresult['receivedmail'];
              $olieferantID = $mIDresult['lieferant'];
              $oderenCIDid = $mIDresult['derenCIDid'];
              $obearbeitetvon = $mIDresult['bearbeitetvon'];
              //$omaintenancedate = $mIDresult['maintenancedate'];
              $ostartdatetime = $mIDresult['startDateTime'];
              $oenddatetime = $mIDresult['endDateTime'];
              $opostponed = $mIDresult['postponed'];
              $onotes = $mIDresult['notes'];
              $omailSentAt = $mIDresult['mailSentAt'];
              $oupdatedBy = $mIDresult['updatedBy'];
              $oupdatedAt = $mIDresult['updatedAt'];
              $cancelled = $mIDresult['cancelled'];
              //$ocal = $mIDresult['cal'];
              if ($mIDresult['done'] == 1) {
                $odone = 'checked';
              } else {
                $odone = '';
              }
              if ($mIDresult['cancelled'] == 1) {
                $cancelled = 'checked';
              } else {
                $cancelled = '';
              }

              $newSDT = DateTime::createFromFormat("Y-m-d  H:i:s", $ostartdatetime);
              $newSDT = new DateTime($ostartdatetime);
              $newSDT->add(new DateInterval('PT1H'));
              $newSDT = $newSDT->format('Y-m-d  H:i:s'); // for example


              $newEDT = DateTime::createFromFormat("Y-m-d  H:i:s", $oenddatetime);
              $newEDT = new DateTime($oenddatetime);
              $newEDT->add(new DateInterval('PT1H'));
              $newEDT = $newEDT->format('Y-m-d  H:i:s'); // for example

              $derenCIDQ =  mysqli_query($dbhandle, "SELECT companies.name, lieferantCID.derenCID, lieferantCID.id FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id WHERE lieferantCID.lieferant LIKE '$olieferant'") or die(mysqli_error($dbhandle));

            }
            if (isset($_GET['gmid'])) {

              $gmid = $_GET['gmid'];

              $service2 = new Google_Service_Gmail($clientService);

              function decodeBody($body) {
                  $rawData = $body;
                  $sanitizedData = strtr($rawData,'-_', '+/');
                  $decodedMessage = base64_decode($sanitizedData);
                  if(!$decodedMessage){
                      $decodedMessage = FALSE;
                  }
                  return $decodedMessage;
              }

              function get_email_domain($email) {
                $domain = substr(strrchr($email[0], "@"), 1);
                $result = preg_split('/(?=\.[^.]+$)/', $domain);
                return $domain;
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
                $html = $dom->getElementsByTagName('html');
                $body1 = $dom->getElementsByTagName('body');
                $table = $dom->getElementsByTagName('table');
                $remove = [];

                foreach($script as $item) {
                  $remove[] = $item;
                }

                foreach($table as $item) {
                  $item->setAttribute("style","overflow: auto !important;");
                  $item->parentNode->setAttribute("style", "display: table !important;");
                }

                foreach($html as $item) {
                  //$remove[] = $item;
                }

                foreach($body1 as $item) {
                  //$remove[] = $item;
                }

                foreach ($remove as $item) {
                  $item->parentNode->removeChild($item);
                }

                $nodes = $dom->getElementsByTagName('*');

                foreach($nodes as $node) {
                  if ($node->hasAttribute('onload')) {
                    $node->removeAttribute('onload');
                  }
                  if ($node->hasAttribute('onclick')) {
                    $node->removeAttribute('onclick');
                  }
                }

                $html = $dom->saveHTML();
                $html = strip_tags($html, "<table>");
                $inlineJS = "/\bon\w+=\S+(?=.*>)/";

                //$html = preg_replace('/\bon\w+=\S+(?=.*>)/g', '', $html);
                return trim($html);
              }
              
              
              function getMessage2($service, $userId, $message_id) {
                try {
                  $msgArray = array();
                  $attachmentParts = array();
                  $optParamsGet2['format'] = 'full';
                  $single_message = $service->users_messages->get($userId, $message_id, $optParamsGet2);
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
                    foreach ($parts as $part) {
                      if($part['partId'] > '0' && $part['mimeType'] !== 'text/plain') {
                        //array_push($attachmentParts,$part['partId'],$part['filename']);
                        $attachmentParts[] = array($part['partId'],$part['filename']);
                      }
                      if($part['body'] && $part['mimeType'] == 'text/plain' ||  $part['mimeType'] == 'text/html') {
                        $FOUND_BODY = decodeBody($part['body']->data);
                        // break;
                      }
                    }
                    $msgArray[] = $attachmentParts;
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

                } catch (Exception $e) {
                    //echo $e->getMessage();
                    echo '<div style="width:100%;font-size: 18px;font-weight:200;margin-left:10px;margin-top:25px;">Maintenance Entry created from a different <b>base</b> Email Account (See Settings)</div>';
                }
                  return $msgArray;
                }


                $msgInfo = getMessage2($service2, $user, $gmid);

                $otitlestring = 'Edit';
                $omaileingang = $msgInfo[0];
                $oreceivedmail = $gmid;
                $olieferantDomain = $msgInfo[1];

                if (isset($_GET['mid'])) {
                  $lieferantNameQ =  mysqli_query($dbhandle, "SELECT companies.name, companies.id FROM companies WHERE companies.id LIKE '$olieferantID'");
                  while ($row = mysqli_fetch_assoc($lieferantNameQ)) {
                    $olieferant = $row['name'];
                    $olieferantID = $row['id'];
                  }
                } else {
                  $lieferantNameQ =  mysqli_query($dbhandle, "SELECT companies.name, companies.id FROM companies WHERE companies.mailDomain LIKE '$olieferantDomain'");
                  while ($row = mysqli_fetch_assoc($lieferantNameQ)) {
                    $olieferant = $row['name'];
                    $olieferantID = $row['id'];
                  }
                }

                $msubject = $msgInfo[2];
                $mfrom = $msgInfo[3];
                $mdate = $msgInfo[4];
                $mbody = $msgInfo[6];

              }

              if (isset($_GET['mid'])) {
                $lieferantNameQ =  mysqli_query($dbhandle, "SELECT companies.name, companies.id FROM companies WHERE companies.id LIKE '$olieferantID'");
                while ($row = mysqli_fetch_assoc($lieferantNameQ)) {
                  $olieferant = $row['name'];
                  $olieferantID = $row['id'];
                }
              }

              $derenCIDQ =  mysqli_query($dbhandle, "SELECT companies.name, lieferantCID.derenCID, lieferantCID.id FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id WHERE lieferantCID.lieferant LIKE '$olieferantID'") or die(mysqli_error($dbhandle));

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

            ?>

        <!-- EDIT MODE -->

        <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone" id="addEditDetails">

        <div class="demo-card-wide3 mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $otitlestring ?> Maintenance Entry</h2>
            <div class="mdl-layout-spacer"></div>
            <button id="btnSave" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
              <i class="material-icons">save</i>
            </button>
            <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnSave">
              Save Maintenance
            </div>
          </div>
          <div class="mdl-card__supporting-text">
            <small><?php if ($oupdatedBy != '') { echo 'Last updated by: <span class="updatedLabel">' . $oupdatedBy . '</span> at <span class="updatedLabel" id="updatedAtLabel">' . $oupdatedAt . '</span>';}?></small>
            <form action="#">
              <div class="mdl-grid">
              <input type="hidden" value="<?php echo $omaintid ?>" id="maintid">
              <div class="mdl-cell mdl-cell--6-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" value="<?php echo $omaileingang ?>" id="medt">
                  <label class="mdl-textfield__label" for="medt">Maileingang Date/Time</label>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--6-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input"  style="width: 82% !important;" type="text" value="<?php echo $oreceivedmail ?>" id="rmail">
                  <label class="mdl-textfield__label" for="rmail">Incoming Mail ID</label>

                <?php if (! empty($oreceivedmail)) { echo '
                  <button style="position:absolute; right:0;" id="viewmailbtn" type="button" class=" mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab viewMail2">
                    <i class="mdi mdi-24px mdi-email-search-outline mdi-dark"></i>
                  </button>

                  <div class="mdl-tooltip  mdl-tooltip--bottom" data-mdl-for="viewmailbtn">
                    View Mail
                  </div>'; } ?>
                 </div>
               </div>
               <div class="mdl-cell mdl-cell--6-col">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" data-val="<?php echo $olieferantID ?>" value="<?php echo $olieferant ?>" id="company">
                <label class="mdl-textfield__label" for="company">Lieferant</label>
              </div>
              </div>
              <div class="mdl-cell mdl-cell--6-col">

              <div>
                <label class="mdl-selectfield--floating-label" >Deren CID</label>
                <div class="multiselect-wrapper">
                <select id="dcid3" multiple class="select_all">                  
                  <?php
                      while ($row = mysqli_fetch_row($derenCIDQ)) {
                        if (strpos($oderenCIDid, ',') !== false) {
                          // comma in string, now split
                          $dCIDarray = explode(',', $oderenCIDid);
                          foreach ($dCIDarray as $value) {
                            if ($row[2] == $value) {
                              echo '<option selected value="' . $value . '">' . $row[1] . '</option>';
                            } 
                          }
                          if (!in_array($row[2],$dCIDarray)) {
                            echo '<option value="' . $row[2] . '">' . $row[1] . '</option>';
                          }
                        } else {
                          if ((isset($_GET['mid'])) && ($row[2] == $oderenCIDid)) {
                            echo '<option selected value="' . $row[2] . '">' . $row[1] . '</option>';
                          } else {
                            echo '<option value="' . $row[2] . '">' . $row[1] . '</option>';
                          }
                        }
                      }
                    ?>
                </select>     

                </div>         
              </div>  
                  <script>
                    $(document).ready(function() {
                        // $('select').val([1]);
                        $('#dcid3').formSelect();
                        $('select.select_all').siblings('ul').prepend('<li id=sm_select_all><span>Select All</span></li>');
                        $('li#sm_select_all').on('click', function () {
                          var jq_elem = $(this), 
                              jq_elem_span = jq_elem.find('span'),
                              select_all = jq_elem_span.text() == 'Select All',
                              set_text = select_all ? 'Select None' : 'Select All';
                          jq_elem_span.text(set_text);
                          jq_elem.siblings('li').filter(function() {
                            return $(this).find('input').prop('checked') != select_all;
                          }).click();
                        });
                    })
                  </script>
              </div>
              <div class="mdl-cell mdl-cell--6-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr">
                    <input type="text" id="sdt" class="mdl-textfield__input"  value="<?php echo $newSDT ?>" data-input>
                    <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span>
                    <label class="mdl-textfield__label" for="sdt">Start Date/Time</label>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--6-col">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr">
                    <input type="text" id="edt" class="mdl-textfield__input"  value="<?php echo $newEDT ?>" data-input>
                    <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span>
                    <label class="mdl-textfield__label" for="edt">End Date/Time</label>
                </div>
              </div>
              <div style="margin-right: calc(12% - 32px) !important;" class="mdl-cell mdl-cell--12-col">
                <label class="timeZoneLabel" for="timezoneSelector">
                  Timezone
                </label>
                  <select class="js-example-basic-multiple js-states form-control" id="timezoneSelector"></select>
              </div>
              <div class="mdl-cell mdl-cell--6-col">
                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                  <select id="bearbeitet" name="bearbeitet" class="mdl-selectfield__select">
                    <option value="<?php echo $usernameBV ?>"><?php echo $usernameBV ?></option>
                    <option value="<?php echo $workers[0] ?>"><?php echo $workers[0] ?></option>
                    <option value="<?php echo $workers[1] ?>"><?php echo $workers[1] ?></option>
                    <option value="<?php echo $workers[2] ?>"><?php echo $workers[2] ?></option>
                  </select>
                  <label class="mdl-selectfield__label" for="bearbeitet">Bearbeitet Von</label>
                  <span class="mdl-selectfield__error">Select a value</span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--6-col">
                <!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" value="<?php echo $opostponed ?>" id="pponed">
                  <label class="mdl-textfield__label" for="pponed">Postponed</label>
                </div> -->
                <label style="display: inline; margin-right: 5px;" class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
                  <span style="color: #6e6e6e;line-height: 44px !important;top: 16px; margin-left: 180px; color:#67B246;" class="mdl-switch__label">Cancelled</span>
                  <input type="checkbox" id="switch-3" style="right: 0; float: right; margin-left: 260px;" class="mdl-switch__input" <?php echo $cancelled ?>>
                </label>
              </div>
              <div style="margin-right: calc(12% - 32px) !important;" class="mdl-cell mdl-cell--12-col">
                <div style="margin-top: -20px;" class="mdl-textfield mdl-js-textfield notesTextArea">
                  <span class="notesLabel1">Notes</span>
                  <textarea class="mdl-textfield__input" type="text" rows= "4" id="notes" ><?php echo $onotes ?></textarea>
                </div>
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

              $( '.flatpickr' ).flatpickr({
                enableTime: true,
                dateFormat: 'Z',
                time_24hr: true,
                wrap: true,
                altInput: true,
                altFormat: 'd M Y H:i:S'
              });

              </script>
              <br>

              <input type="hidden" value="<?php echo $update ?>" id="update">
              <input type="hidden" value="<?php echo $omailSentAt ?>" id="mailSentAt">
              <input type="hidden" value="<?php echo $_COOKIE['label'] ?>" id="gmailLabel">
              <input type="hidden" value="<?php echo $msgInfo[1] ?>" id="mailDomain">
              <input type="hidden" value="<?php echo $activeID ?>" id="activeMID">
            </div>
            </form>
            </div>
            <div class="mdl-card__actions mdl-card--border">
              <div style="display: inline;">
                <label style="display: inline; margin-right: 5px; float: right;width: 150px; line-height: 2.8em;" class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                  <span style="color: #6e6e6e;line-height: 44px !important;" class="mdl-switch__label">Completed</span>
                  <input type="checkbox" id="switch-2" class="mdl-switch__input" <?php echo $odone ?>>
                </label>
                <div class="mdl-layout-spacer"></div>
                <button id="addCalbtn" type="button" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                  <span class="mdi mdi-24px mdi-calendar-plus mdi-light"></span>
                </button>
                <div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="addCalbtn">
                  Create Calendar Entry
                </div>
              </div>
            </div>
          </div>
          <?php
          echo '<dialog id="mailDialog" class="mdl-dialog mailDialog1" style="">
                <div class="mailcSelectHeader">
                  <h6 class="labelSelectLabel"><font color="#67B246">Sub:</font> ' . $msubject . '</h6><br>
                  <h6 class="sublabelSelectLabel"><font color="#67B246">From:</font> ' . $mfrom . '</h6><br>
                  <h6 class="sublabelSelectLabel"><font color="#67B246">Date:</font> ' . $mdate . '</h6>
                  <button tabindex="-1" type="button" class="mailcSelectClose2 mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1">
                    <i class="material-icons">close</i>
                  </button>';



                $attachmentParts2 = $msgInfo[5];
                if ($attachmentParts2 !== '') {
                  echo '<div style="float:right;text-align:right;z-index:1000;position:relative;">
                  <font style="color:#4c4c4c">Attachments:</font><br>';
                  foreach ($attachmentParts2 as $part) {
                    echo '<a class="attachmentLink" target="_blank" href="attachments?messageId='.$oreceivedmail.'&part_id='.$part[0].'">'.$part[1].'</a><br>';
                    }

                  }
                  echo '</div>';
                
                 echo '<br><br></div>
                 <div class="mdl-dialog__content">
                 <p>
                 <div class="mailcHR">NT</div>
                    <div class="mailWrapper0">
                      <div class="mdl-textfield mdl-js-textfield mailWrapper1">
                        <div style="display:inline-block !important;height: 100%;margin-top: 20px;" class=" mailWrapper2">
                          <iframe class="frameClass" style="margin-top: 20px;" height="100%" width="100%" frameborder="0"  id="emailBodyFrame" src="https://maintenance.newtelco.de/msg/' . $oreceivedmail . '.html"></iframe>
                        </div>
                      </div>
                    </div>
                  </p>
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
          <div id="sbUpdated" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
          </div>
          <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">
            <div id="kundenCard" class="demo-card-wide3 mdl-card mdl-shadow--2dp hidden">
              <div id="addEditKundenTitle" class="mdl-card__title">
                <h2 class="mdl-card__title-text">Kunden Circuits</h2>
                <div class="mdl-layout-spacer"></div>
                <?php
                  if ($omailSentAt != '') {
                    echo '<button id="btnShowSent" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                      <i class="material-icons">search</i>
                    </button>
                    <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnShowSent">
                      Show Related Mails
                    </div>';
                  }
                ?>
              </div>
              <div class="mdl-card__supporting-text">
              <table id="dataTable4" class="mdl-data-table striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>Unserer CID</th>
                    <th class="">Unsere CID</th>
                    <th>Protection</th>
                    <th>Kunde</th>
                    <th>Maintenancee Recipient</th>
                    <th>Maintenance Recipient</th>
                  </tr>
                </thead>
              </table>
              </div>
            </div>
          </div>
        </div>

        <dialog id="xlsDialog" class="mdl-dialog">
          <h4 id="xlsTitle" class="mdl-dialog__title"></h4>
          <div class="mdl-dialog__actions">
            <button tabindex="-1" type="button" class="close2 mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect">
              <i class="material-icons">close</i>
            </button>
          </div>
          <div class="mdl-dialog__content">
            
            <p>
              <div id="gridctr"></div>
            </p>
          </div>

          <div class="mdl-dialog__actions">
            <a class="xlsDownload" href="">
              <button tabindex="-1" type="button" id="btnDownloadXLS" class="greenRoundBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect">
                <i class="material-icons">cloud_download</i>
              </button>
              <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnDownloadXLS">
                Download Attachment
              </div>
            </a>
          </div>
        </dialog>
        
      <script>

$('#btnShowSent').click(function(){

  var jMailSentAt = $("#mailSentAt").val();
  var DateTime = luxon.DateTime;
  var jMailSentAtDate = DateTime.fromSQL(jMailSentAt).toFormat("y-MM-d");
  // var jMailSentAtDate2 = jMailSentAtDate.local();
  var jMailSentAtDate3 = DateTime.fromISO(jMailSentAtDate).plus({ days: 1 }).toISODate();
      // .add(1, 'days');
      // .plus({ days: 1 });
  //console.log(jMailSentAtDate3);

  table4 = $('#dataTable4').DataTable();
  var kUnsereCIDs = table4
        .columns( 1 )
        .data()
        .eq( 0 )      // Reduce the 2D array into a 1D array of data
        .sort()       // Sort data alphabetically
        .unique()     // Reduce to unique values
        .join( ',' );

  // before:${jMailSentAtDate3}
  var activeUser = $(".menumail").html();
  openInNewTab(`https://mail.google.com/mail/ca/u/0/#search/in:sent+after:${jMailSentAtDate}+before:${jMailSentAtDate3}+from:maintenance@newtelco.de+Planned+Work+Notification+${kUnsereCIDs}`);
});

$('#addCalbtn').click(function(){

  var calSDT = $('#sdt').val();
  var calSDTISO = moment(calSDT).toISOString().replace(/[^a-z0-9\s]/gi, '');
  var calSDTISO2 = calSDTISO.replace('000Z','Z');

  var calEDT = $('#edt').val();
  var calEDTISO = moment(calEDT).toISOString().replace(/[^a-z0-9\s]/gi, '');;
  var calEDTISO2 = calEDTISO.replace('000Z','Z');

  var selectedDCID = $( "#dcid3 option:selected" ).text().trim();
  var selectedCompany = $('#company').val();

  var activeID = $('#activeMID').val();

  table4 = $('#dataTable4').DataTable();
  var data = table4.row( $('tr') ).data();
  // console.log('data: ' + data['kundenCID']);

  // concat all visible 'unsere CIDs' from kunden table aka selected 'deren CIDs'
  var kIDsconcat = table4
        .columns( 1 )
        .data()
        .eq( 0 )      // Reduce the 2D array into a 1D array of data
        .sort()       // Sort data alphabetically
        .unique()     // Reduce to unique values
        .join( ',' );


  openInNewTab(`http://www.google.com/calendar/event?action=TEMPLATE&dates=${calSDTISO2}%2F${calEDTISO2}&src=newtelco.de_hkp98ambbvctcn966gjj3c7dlo@group.calendar.google.com&text=Maintenance%20${selectedCompany}%20CID%20${kIDsconcat}&add=service@newtelco.de&details=Maintenance%20for%20<b>${selectedCompany}</b>%20on%20deren%20CID:%20"<b>${selectedDCID}</b>".<br><br>Affected%20Newtelco%20CIDs:%20<b>${kIDsconcat}</b><br><br>Source%20-%20<a href="https://maintenance.newtelco.de/addedit?mid=${activeID}">NT-M_${activeID}</a>&trp=false`);
});

const _t = (s) => {
  if (i18n !== void 0 && i18n[s]) {
    return i18n[s];
  }
  return s;
};

const timezones = [
  "Etc/GMT+12",
  "Pacific/Midway",
  "Pacific/Honolulu",
  "America/Juneau",
  "America/Dawson",
  "America/Boise",
  "America/Chihuahua",
  "America/Phoenix",
  "America/Chicago",
  "America/Regina",
  "America/Mexico_City",
  "America/Belize",
  "America/Detroit",
  "America/Indiana/Indianapolis",
  "America/Bogota",
  "America/Glace_Bay",
  "America/Caracas",
  "America/Santiago",
  "America/St_Johns",
  "America/Sao_Paulo",
  "America/Argentina/Buenos_Aires",
  "America/Godthab",
  "Etc/GMT+2",
  "Atlantic/Azores",
  "Atlantic/Cape_Verde",
  "GMT",
  "Africa/Casablanca",
  "Atlantic/Canary",
  "Europe/Belgrade",
  "Europe/Sarajevo",
  "Europe/Brussels",
  "Europe/Amsterdam",
  "Africa/Algiers",
  "Europe/Bucharest",
  "Africa/Cairo",
  "Europe/Helsinki",
  "Europe/Athens",
  "Asia/Jerusalem",
  "Africa/Harare",
  "Europe/Moscow",
  "Asia/Kuwait",
  "Africa/Nairobi",
  "Asia/Baghdad",
  "Asia/Tehran",
  "Asia/Dubai",
  "Asia/Baku",
  "Asia/Kabul",
  "Asia/Yekaterinburg",
  "Asia/Karachi",
  "Asia/Kolkata",
  "Asia/Kathmandu",
  "Asia/Dhaka",
  "Asia/Colombo",
  "Asia/Almaty",
  "Asia/Rangoon",
  "Asia/Bangkok",
  "Asia/Krasnoyarsk",
  "Asia/Shanghai",
  "Asia/Kuala_Lumpur",
  "Asia/Taipei",
  "Australia/Perth",
  "Asia/Irkutsk",
  "Asia/Seoul",
  "Asia/Tokyo",
  "Asia/Yakutsk",
  "Australia/Darwin",
  "Australia/Adelaide",
  "Australia/Sydney",
  "Australia/Brisbane",
  "Australia/Hobart",
  "Asia/Vladivostok",
  "Pacific/Guam",
  "Asia/Magadan",
  "Pacific/Fiji",
  "Pacific/Auckland",
  "Pacific/Tongatapu"
];

const i18n = {
  "Etc/GMT+12": "International Date Line West",
  "Pacific/Midway": "Midway Island, Samoa",
  "Pacific/Honolulu": "Hawaii",
  "America/Juneau": "Alaska",
  "America/Dawson": "Pacific Time (US and Canada); Tijuana",
  "America/Boise": "Mountain Time (US and Canada)",
  "America/Chihuahua": "Chihuahua, La Paz, Mazatlan",
  "America/Phoenix": "Arizona",
  "America/Chicago": "Central Time (US and Canada)",
  "America/Regina": "Saskatchewan",
  "America/Mexico_City": "Guadalajara, Mexico City, Monterrey",
  "America/Belize": "Central America",
  "America/Detroit": "Eastern Time (US and Canada)",
  "America/Indiana/Indianapolis": "Indiana (East)",
  "America/Bogota": "Bogota, Lima, Quito",
  "America/Glace_Bay": "Atlantic Time (Canada)",
  "America/Caracas": "Caracas, La Paz",
  "America/Santiago": "Santiago",
  "America/St_Johns": "Newfoundland and Labrador",
  "America/Sao_Paulo": "Brasilia",
  "America/Argentina/Buenos_Aires": "Buenos Aires, Georgetown",
  "America/Godthab": "Greenland",
  "Etc/GMT+2": "Mid-Atlantic",
  "Atlantic/Azores": "Azores",
  "Atlantic/Cape_Verde": "Cape Verde Islands",
  "GMT": "Dublin, Edinburgh, Lisbon, London",
  "Africa/Casablanca": "Casablanca, Monrovia",
  "Atlantic/Canary": "Canary Islands",
  "Europe/Belgrade": "Belgrade, Bratislava, Budapest, Ljubljana, Prague",
  "Europe/Sarajevo": "Sarajevo, Skopje, Warsaw, Zagreb",
  "Europe/Brussels": "Brussels, Copenhagen, Madrid, Paris",
  "Europe/Amsterdam": "Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
  "Africa/Algiers": "West Central Africa",
  "Europe/Bucharest": "Bucharest",
  "Africa/Cairo": "Cairo",
  "Europe/Helsinki": "Helsinki, Kiev, Riga, Sofia, Tallinn, Vilnius",
  "Europe/Athens": "Athens, Istanbul, Minsk",
  "Asia/Jerusalem": "Jerusalem",
  "Africa/Harare": "Harare, Pretoria",
  "Europe/Moscow": "Moscow, St. Petersburg, Volgograd",
  "Asia/Kuwait": "Kuwait, Riyadh",
  "Africa/Nairobi": "Nairobi",
  "Asia/Baghdad": "Baghdad",
  "Asia/Tehran": "Tehran",
  "Asia/Dubai": "Abu Dhabi, Muscat",
  "Asia/Baku": "Baku, Tbilisi, Yerevan",
  "Asia/Kabul": "Kabul",
  "Asia/Yekaterinburg": "Ekaterinburg",
  "Asia/Karachi": "Islamabad, Karachi, Tashkent",
  "Asia/Kolkata": "Chennai, Kolkata, Mumbai, New Delhi",
  "Asia/Kathmandu": "Kathmandu",
  "Asia/Dhaka": "Astana, Dhaka",
  "Asia/Colombo": "Sri Jayawardenepura",
  "Asia/Almaty": "Almaty, Novosibirsk",
  "Asia/Rangoon": "Yangon Rangoon",
  "Asia/Bangkok": "Bangkok, Hanoi, Jakarta",
  "Asia/Krasnoyarsk": "Krasnoyarsk",
  "Asia/Shanghai": "Beijing, Chongqing, Hong Kong SAR, Urumqi",
  "Asia/Kuala_Lumpur": "Kuala Lumpur, Singapore",
  "Asia/Taipei": "Taipei",
  "Australia/Perth": "Perth",
  "Asia/Irkutsk": "Irkutsk, Ulaanbaatar",
  "Asia/Seoul": "Seoul",
  "Asia/Tokyo": "Osaka, Sapporo, Tokyo",
  "Asia/Yakutsk": "Yakutsk",
  "Australia/Darwin": "Darwin",
  "Australia/Adelaide": "Adelaide",
  "Australia/Sydney": "Canberra, Melbourne, Sydney",
  "Australia/Brisbane": "Brisbane",
  "Australia/Hobart": "Hobart",
  "Asia/Vladivostok": "Vladivostok",
  "Pacific/Guam": "Guam, Port Moresby",
  "Asia/Magadan": "Magadan, Solomon Islands, New Caledonia",
  "Pacific/Fiji": "Fiji Islands, Kamchatka, Marshall Islands",
  "Pacific/Auckland": "Auckland, Wellington",
  "Pacific/Tongatapu": "Nuku'alofa"
}

const selectorOptions = moment.tz.names()
  .filter(tz => {
    return timezones.includes(tz)
  })
  .reduce((memo, tz) => {
    memo.push({
      name: tz,
      offset: moment.tz(tz).utcOffset()
    });

    return memo;
  }, [])
  .sort((a, b) => {
    return a.offset - b.offset
  })
  .reduce((memo, tz) => {
    const timezone = tz.offset ? moment.tz(tz.name).format('Z') : '';

    return memo.concat(`<option value="${tz.name}">(GMT${timezone}) ${_t(tz.name)}</option>`);
  }, "");

document.querySelector("#timezoneSelector").innerHTML = selectorOptions;
document.querySelector("#timezoneSelector").value = "Europe/Amsterdam";

const event = new Event("change");
document.querySelector("#timezoneSelector").dispatchEvent(event);

// note: timezone selector - https://codepen.io/matallo/pen/WEjKqG?editors=1010#0

// TODO: Check this on change event handler firing once per selected
//       dCID onLoad. Making many unnecessary db calls!

$("#dcid3").change(function() {
if ( $.fn.dataTable.isDataTable( '#dataTable4' ) ) {
    table3 = $('#dataTable4').DataTable();
    table3.destroy();
}

var data3 = $('#dcid3').val();
$('#kundenCard').addClass('display').removeClass('hidden');
//filter by selected value on second column
var table4 = $('#dataTable4').DataTable( {
  ajax: {
    url: "api?dCID=" + data3,
    dataSrc: ""
  },
  columns: [
      { title: "Notification" },
      { data: "kundenCID" },
      { data: "protected" },
      { data: "name" },
      { data: "kunde" },
      { data: "maintenanceRecipient" }
  ],
  columnDefs: [
      {
          "targets": [ 4 ],
          "visible": false,
          "searchable": false
      }, {
          "targets": 0,
          "data": null,
          "defaultContent": "<button style='margin-left:3px;text-align:center;' id='sendMailbtn' type='button' class='mdl-color--light-green-nt mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored button40'><span class='mdi mdi-send mdi-24px'></span></button><div class='mdl-tooltip  mdl-tooltip--bottom' data-mdl-for='sendMailbtn'> Send Notification </div>",
          className: 'mdl-data-table__cell--non-numeric text-center'
      },{
          targets: [ 1, 3 ],
          className: 'mdl-data-table__cell--non-numeric'
      },{
          targets: [ 5 ],
          className: 'mdl-typography--text-lowercase'
      },{
          targets: [2], render: function (a, b, data, d) {
            if (data['protected'] == '0' ){
              return 'Unprotected'
            } else if (data['protected'] == '1' ){
              return 'Protected';
            } else {
              return data['protected'];
            }
          }
      },{ responsivePriority: 1, targets: [ 0, 1, 3 ] }
    ],
    responsive: true
});

});


$('#btnSave').on('click', function(e) {

  e.preventDefault();

  // Some formatting before we push to mysql
  var DateTime = luxon.DateTime;

  var medt = $('#medt').val();
  var medtUTC = moment.parseZone(medt).utc().format();
  var medtISO = moment(medtUTC).toISOString();

  var mdtTZ = $('#timezoneSelector').val();

  var mSDT = $('#sdt').val();
  var mSDT = moment(mSDT).format('YYYY-MM-DD\THH:mm:ss');
  var zOffset = moment.tz(mdtTZ).format('Z');
  var tzConcat = mSDT.concat(zOffset);
  var sdtUTC = moment(tzConcat).utc().format();
  var mEDT = $('#edt').val();
  var mEDT = moment(mEDT).format('YYYY-MM-DD\THH:mm:ss');
  var tzConcat2 = mEDT.concat(zOffset);
  var edtUTC = moment(tzConcat2).utc().format();

  if($('#switch-2:checked').val() == 'on') {
    var odone = '1';
  } else {
    var odone = '0';
  }
  if($('#switch-3:checked').val() == 'on') {
    var cancelled = '1';
  } else {
    var cancelled = '0';
  }

  table4 = $('#dataTable4').DataTable();
  var kCompaniesConcat = table4
        .columns( 3 )
        .data()
        .eq( 0 )      // Reduce the 2D array into a 1D array of data
        .sort()       // Sort data alphabetically
        .unique()     // Reduce to unique values
        .join( ',' );
  console.log('kCompaniesConcat: ' + kCompaniesConcat);

  var kCIDsConcat = table4
        .columns( 1 )
        .data()
        .eq( 0 )      // Reduce the 2D array into a 1D array of data
        .sort()       // Sort data alphabetically
        .unique()     // Reduce to unique values
        .join( ',' );
  console.log('kCIDsConcat: ' + kCIDsConcat);

  var getSelected = $('#dcid3').val();
  var selectedNums = [];
  for (var i = 0; i < getSelected.length; i++) {
    selectedNums.push(getSelected[i]);
  }
  var dcid = selectedNums.join(',');

  var TableData = new Array();

  TableData[0] = {
    "omaintid" : $('#maintid').val(),
    "omaileingang" : medtISO,
    "oreceivedmail" : $('#rmail').val(),
    "olieferant" : $('#company').val(),
    "olieferantid" : $("#company").data('val'),
    "oderenCIDid" : dcid, 
    "obearbeitetvon" : $('#bearbeitet').val(),
    "omaintenancedate" : $('#mdt').val(),
    "ostartdatetime" : sdtUTC,
    "oenddatetime" : edtUTC,
    "opostponed": $('#pponed').val(),
    "onotes" : $('#notes').val(),
    //"omailankunde" : makdtUTC.toString(),
    "mailSentAt" : $('#mailSentAt').val(),
    "odone" : odone,
    "cancelled" : cancelled,
    "update" : $('#update').val(),
    "updatedBy": $('.menumail').text(),
    "gmailLabel" : $('#gmailLabel').val(),
    "mailDomain" : $('#mailDomain').val(),
    "kundenCompanies": kCompaniesConcat,
    "kundenCIDs": kCIDsConcat
    }

    $.ajax({

    type : "POST",
    url : "api",
    cache : "false",
    dataType: "json",
    data :  {data:TableData},
    success : function(result1){
      var obj = JSON.stringify(result1);

      if (result1.exist === 1) {
        var snackbarContainer = document.querySelector('#sbMExists');
        var midval = $('#rmail').val();
        var handler = function(event) {
          var aeURL = 'https://maintenance.newtelco.de/addedit?update=1&gmid=' + midval
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
      } else if (result1.updated === 1){
        var snackbarContainer2 = document.querySelector('#sbUpdated');
        var dataME3 = {
          message: 'Maintenance Successfully Updated',
          timeout: 2000
        };
        snackbarContainer2.MaterialSnackbar.showSnackbar(dataME3);
      } else {
        alert('Invalid Response');
      }
      if (result1.updatedID != '') {
        var newID = result1.updatedID;
        window.location.href = "https://maintenance.newtelco.de/addedit?gmid="+$('#rmail').val()+"&mid="+newID+"&update=1";
      }
    }
    });
}); // clicking orderSave button

  </script>
  <script>
  if ($("#viewmailbtn").length > 0) {

    var mailID = $('#rmail').val();

    $("#emailBodyFrame").attr('src',"msg/"+mailID+".html");
    $("#emailBodyFrame").attr('src', function ( i, val ) { return val; });

    // Mail preview modal
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

      // xls(x) preview modal
    var dialog2 = document.querySelector('#xlsDialog');
    var showDialogButton2 = document.querySelectorAll('.attachmentLink');
    if (! dialog2.showModal) {
      dialogPolyfill.registerDialog(dialog2);
    }
    for (var i = 0; i < showDialogButton2.length; i++) {
      var link = showDialogButton2[i];
      if (link.innerHTML.indexOf('xls') >= 0) {
        showDialogButton2.forEach(function(elem) {
          elem.addEventListener('click', function(e) {
            var targetText = $(e.target).text();
            if (targetText.indexOf("xls") >= 0) {
              dialog2.showModal();
            };
          });
        });
      };
    }
    
    dialog2.querySelector('.close2').addEventListener('click', function() {
      dialog2.close();
    });
  }

  $('.attachmentLink').on('click', function(e) {
    //console.log($(this).text());
    var targetText = $(e.target).text();
    var title = $(this).text();
    if (targetText.indexOf("xls") >= 0) {
      e.preventDefault();

      $('#xlsTitle').text($(this).text());

      if ($('canvas-datagrid').length == '0') {
        var url = $(this).attr('href');
        $('.xlsDownload').attr('href', url);
        var req = new XMLHttpRequest();
        req.open("GET", url, true);
        req.responseType = "arraybuffer";
        req.onload = function(e) {
          /* parse the data when it is received */
          var data = new Uint8Array(req.response);
          var workbook = XLSX.read(data, {type:"array"});
          /* DO SOMETHING WITH workbook HERE */
          //console.log(workbook);
          var grid = canvasDatagrid({
            parentNode: document.getElementById('gridctr'),
            data: []
          });
          var ws = workbook.Sheets[workbook.SheetNames[0]];
          grid.data = XLSX.utils.sheet_to_json(ws, {header:1});
          grid.style.height = '150%';
          grid.style.width = '100%';
          $('#gridctr').height('180px');
        };
        req.send();
      }
      
    }
  });

  document.addEventListener("DOMContentLoaded", function() {

    // Adjusting Timezones and Date/Time Format
    var mEingangVal =  moment($('#medt').val()).format("DD MMM YYYY HH:mm:SS ZZ");
    $('#medt').val(mEingangVal);

    var updatedAtLabel = moment($('#updatedAtLabel').html()).format("DD MMM YYYY HH:mm:SS ZZ");
    $('#updatedAtLabel').html(updatedAtLabel);

    $("#timezoneSelector").select2({
      placeholder: "Select a Timezone"
    });

    // Loading 'Kunden Circuits' content
    $('iframe').on('load', function() {
        $('this').contents().find('html:first').css('white-space', 'pre-wrap');
    });

    $('#dataTable4').on( 'click', '#sendMailbtn', function () {
      table3 = $('#dataTable4').DataTable();
      var data = table3.row( $(this).parents('tr') ).data();

      var start = moment($('#sdt').val());
      var end = moment($('#edt').val());

      var startLabel = start.format("DD MMM YYYY HH:mm:SS");
      var endLabel = end.format("DD MMM YYYY HH:mm:SS");

      var tzSuffix = $("#timezoneSelector option:selected").text();
      var regExp = /\(([^)]+)\)/;
      var matches = regExp.exec(tzSuffix);
      var tzSuffixRAW = matches[1];

      // var ms = moment(end).diff(moment(start));
      // var d = moment.duration(ms);
      // var impactTime = d.format("mm");

      openInNewTab2('mailto:' + data['maintenanceRecipient'] + '?from=maintenance@newtelco.de&subject=Planned Work Notification on CID: ' + data['kundenCID'] + '&cc=service@newtelco.de;maintenance@newtelco.de&body=<head> <style>.grayText10{font-size:10pt;font-family:\'Arial\',sans-serif;color:#636266}.tdSizing{width:467.8pt;padding:0cm 5.4pt 0cm 5.4pt;vertical-align:text-top;width:131px}.tdSizing2{width:467.8pt;padding:0cm 5.4pt 0cm 5.4pt;vertical-align:text-top;width:624px}</style></head><body style="{padding:0;margin:0;}"> <div> <p><span class="grayText10">Dear Colleagues,</span></p><p><span class="grayText10">We would like to inform you about planned work on the CID ' + data['kundenCID'] + '. The maintenance work is with the following details</span></p><table border="0 " cellspacing="0 " cellpadding="0" width="775 style="width:581.2pt;border-collapse:collapse;border:none"> <tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"> <span class="grayText10">Start date and time:</span></p></td><td class="tdSizing"> <p style="margin-bottom:12.0pt;text-align:justify"><span><b><span class="grayText10">' + startLabel + ' (' + tzSuffixRAW + ')</span></b></span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span><span class="grayText10">Finish date and time:</span></span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span><b><span class="grayText10">' + endLabel + ' (' + tzSuffixRAW + ')</span></b></span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"> <span> <span class="grayText10">Impact:</span></span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span><span class="grayText10">[INSERT IMPACT HERE]</span></span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span><span class="grayText10">Location:</span></span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span><span class="grayText10">[INSERT LOCATION HERE]</span></span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span><span class="grayText10">Reason:</span></span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span><span class="grayText10">[INSERT REASON HERE]</span></span></p></td></tr></table> <p><span class="grayText10">We sincerely regret causing any inconveniences by this and hope for your understanding and the further mutually advantageous cooperation.</span></p><p><span class="grayText10">If you have any questions feel free to contact us at maintenance@newtelco.de.</span></p><style>.sig{font-family: Century Gothic, sans-serif;font-size: 9pt;color: #636266 !important;}b{color: #4ca702;}.gray{color: #636266 !important;}a{text-decoration: none;color: #636266 !important;}</style><div class="sig"><br><div>Best regards | Mit freundlichen Grüßen</div><br><div><b class="gray">Newtelco Maintenance Team</b></div><br><div>NewTelco GmbH <b>|</b> Mainzer Landstr. 351-353 <b>|</b> 60326 Frankfurt a.M. <b>|</b> DE <br>www.newtelco.com <b>|</b> 24/7 NOC +49 69 75 00 27 30 <b>|</b> <a style="color:#" href="mailto:service@newtelco.de">service@newtelco.de</a><br><br><div><img src="https://home.newtelco.de/sig.png" alt="" height="29" width="516"></div></div></body>');

      var DateTime = luxon.DateTime;
      var now = DateTime.local().toFormat("y-MM-dd HH:mm");
      $("#mailSentAt").val(now);
    } );

    /*************************************************************************************************
     *
     *   Gmail HTML Paste Extension:
     *   https://chrome.google.com/webstore/detail/gmail-append-html/dnfikahmfhcjfcmbgbkklecekfeijmda
     *
     *************************************************************************************************/

    function openInNewTab2(url) {
      var win = window.open(url, '_blank');
      win.focus();
    };
    

    // Show 'Kunden Circuits' if loading with selected Deren CIDs
    if ($( "#dcid3 option:selected" ).text() != '') {
      $('#kundenCard').addClass('display').removeClass('hidden');
      var value = $( "#dcid3 option:selected" ).val();

      $('#dcid3')
          .find('option:checked(' + value + ')')
          .prop('selected',true)
          .trigger('change');

      return false;
    }

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
      OverlayScrollbars(document.getElementById("mailDialog"), {
        className       : "os-theme-dark",
        resize          : "both",
        sizeAutoCapable : true
      });
      OverlayScrollbars(document.getElementById("notes"), {
        className       : "os-theme-dark",
        resize          : "vertical",
        sizeAutoCapable : true
      });
  });

  $( window ).on('load',function() {
     setTimeout(function() {$('#loading').hide()},500);
  });

</script>
</main>
    <?php echo file_get_contents("views/footer.html"); ?>
  </div>

  <!-- Google font-->
  <link rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

  <!-- mdl-selectfield css -->
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/mdl-selectfield.min.css" onload="this.rel='stylesheet'">

  <!-- select 2 css -->
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/select2.min.css" onload="this.rel='stylesheet'">

  <!-- flatpickr -->
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/flatpickr.min.css" onload="this.rel='stylesheet'">
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/flatpickr_green.css" onload="this.rel='stylesheet'">

  <!-- material icons -->
  <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
  <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

  <!-- datatables css -->
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/responsive.dataTables.min.css" onload="this.rel='stylesheet'">
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/select.dataTables.min.css" onload="this.rel='stylesheet'">
  <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/dataTables/dataTables.material.min.css" onload="this.rel='stylesheet'">

  <!-- font awesome -->
  <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

  <!-- materialize (multi select) -->
  <link rel="preload stylesheet" as="style" href="dist/css/materialize.min.css" onload="this.rel='stylesheet'">

  <!-- hover css -->
  <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

  <!-- overlay scrollbars css -->
  <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
</body>
</html>
