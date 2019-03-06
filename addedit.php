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

    <!-- jsPanel -->
    <script rel="preload" as="script" type="text/javascript" src="dist/js/jspanel.js"></script>
    <script rel="preload" as="script" type="text/javascript" src="dist/js/jspanel.dock.min.js"></script>

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
                <img id="loading-image" src="dist/images/Preloader_bobbleHead.gif" alt="Loading..." />
            </div>
            <div class="mdl-grid">

                <?php


                $otitlestring = 'Add';
                $omaileingang = '';
                $oreceivedmail = '';
                $newSDT = '';
                $newEDT = '';
                $olieferant = '';
                $olieferantID = '';
                $oderenCIDid = '';
                $obearbeitetvon = '';
                $omaintenancedate = '';
                $cancelled = '';
                $ostartdatetime = '';
                $oenddatetime = '';
                $opostponed = '';
                $oreason = '';
                $oimpact = '';
                $olocation = '';
                $onotes = '';
                $omailSentAt = '';
                $oupdatedBy = '';
                $omaintid = '';
                $ocal = '';
                $odone = '';
                $odoneVal = '0';
                $activeID = '';
                $update = '0';


                $nowDT = date("Y-m-d  H:i:s");

                if (isset($_GET['update'])) {
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
                  $oreason = $mIDresult['reason'];
                  $oimpact = $mIDresult['impact'];
                  $olocation = $mIDresult['location'];
                  $onotes = $mIDresult['notes'];
                  $omailSentAt = $mIDresult['mailSentAt'];
                  $oupdatedBy = $mIDresult['updatedBy'];
                  $oupdatedAt = $mIDresult['updatedAt'];
                  $cancelled = $mIDresult['cancelled'];
                  //$ocal = $mIDresult['cal'];
                  if ($mIDresult['done'] == 1) {
                    $odone = 'checked';
                    $odoneVal = '1';
                  } else {
                    $odone = '';
                    $odoneVal = '0';
                  }
                  if ($mIDresult['cancelled'] == 1) {
                    $cancelled = 'checked';
                  } else {
                    $cancelled = '';
                  }


                  $newSDT = DateTime::createFromFormat("Y-m-d  H:i:s", $ostartdatetime);
                  $newSDT = new DateTime($ostartdatetime);
                  $newSDT->add(new DateInterval('PT1H'));
                  $newSDT = $newSDT->format('Y-m-d  H:i:s'); 

                  $newEDT = DateTime::createFromFormat("Y-m-d  H:i:s", $oenddatetime);
                  $newEDT = new DateTime($oenddatetime);
                  $newEDT->add(new DateInterval('PT1H'));
                  $newEDT = $newEDT->format('Y-m-d  H:i:s');

                  $derenCIDQ =  mysqli_query($dbhandle, "SELECT companies.name, lieferantCID.derenCID, lieferantCID.id FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id WHERE lieferantCID.lieferant LIKE '$olieferant'") or die(mysqli_error($dbhandle));
                }
                if (isset($_GET['gmid'])) {

                  $gmid = $_GET['gmid'];

                  $service2 = new Google_Service_Gmail($clientService);

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

                  function get_email_domain($email)
                  {
                    $domain = substr(strrchr($email[0], "@"), 1);
                    $result = preg_split('/(?=\.[^.]+$)/', $domain);
                    return $domain;
                  }

                  function getHeader($headers, $name)
                  {
                    foreach ($headers as $header) {
                      if ($header['name'] == $name) {
                        return $header['value'];
                      }
                    }
                  }

                  function stripHTML($html)
                  {
                    $dom = new DOMDocument();
                    $dom->loadHTML($html);
                    $script = $dom->getElementsByTagName('script');
                    $html = $dom->getElementsByTagName('html');
                    $body1 = $dom->getElementsByTagName('body');
                    $table = $dom->getElementsByTagName('table');
                    $remove = [];

                    foreach ($script as $item) {
                      $remove[] = $item;
                    }

                    foreach ($table as $item) {
                      $item->setAttribute("style", "overflow: auto !important;");
                      $item->parentNode->setAttribute("style", "display: table !important;");
                    }

                    foreach ($html as $item) {
                      //$remove[] = $item;
                    }

                    foreach ($body1 as $item) {
                      //$remove[] = $item;
                    }

                    foreach ($remove as $item) {
                      $item->parentNode->removeChild($item);
                    }

                    $nodes = $dom->getElementsByTagName('*');

                    foreach ($nodes as $node) {
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


                  function getMessage2($service, $userId, $message_id)
                  {
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
                      if (($pos = strpos($fromHTML, "@")) !== false) {
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
                      if (!$FOUND_BODY) {
                        $parts = $payload->getParts();
                        foreach ($parts as $part) {
                          if ($part['partId'] > '0' && $part['mimeType'] !== 'text/plain') {
                            //array_push($attachmentParts,$part['partId'],$part['filename']);
                            $attachmentParts[] = array($part['partId'], $part['filename']);
                          }
                          if ($part['body'] && $part['mimeType'] == 'text/plain' ||  $part['mimeType'] == 'text/html') {
                            $FOUND_BODY = decodeBody($part['body']->data);
                            // break;
                          }
                        }
                        $msgArray[] = $attachmentParts;
                      }
                      // if(!$FOUND_BODY) {
                      //   foreach ($parts  as $part) {
                      //     // Last try: if we didn't find the body in the first parts,
                      //     // let's loop into the parts of the parts (as @Tholle suggested).
                      //     if($part['parts'] && !$FOUND_BODY) {
                      //       foreach ($part['parts'] as $p) {
                      //         // replace 'text/html' by 'text/plain' if you prefer
                      //         if($p['mimeType'] === 'text/plain' && $p['body']) {
                      //           $FOUND_BODY = decodeBody($p['body']->data);
                      //           break;
                      //         }
                      //       }
                      //     }
                      //     if($FOUND_BODY) {
                      //       break;
                      //     }
                      //   }
                      // }
                      // $msgArray[] = $FOUND_BODY;
                    } catch (Exception $e) {
                      if(strpos($message_id, 'NT-') !== false) {
                        echo '';
                      } else {
                        //echo $e->getMessage();
                        echo '<div style="width:100%;font-size: 18px;font-weight:200;margin-left:10px;margin-top:25px;">Maintenance Entry created from a different <b>base</b> Email Account (See Settings)</div>';
                      }
                    }
                    return $msgArray;
                  }

                  if ($gmid != '') {
                    $msgInfo = getMessage2($service2, $user, $gmid);
                  }

                  $otitlestring = 'Edit';
                  if(isset($msgInfo[0])) {
                    $omaileingang = $msgInfo[0];
                  }
                  $oreceivedmail = $gmid;
                  if(isset($msgInfo[1])) {
                    $olieferantDomain = $msgInfo[1];
                  }

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

                  if(isset($msgInfo[2])) {
                    $msubject = $msgInfo[2];
                  } else {
                    $msubject = '';
                  }
                  if(isset($msgInfo[3])) {
                    $mfrom = $msgInfo[3];
                  } else {
                    $mfrom = ' ';
                  }
                  if(isset($msgInfo[4])) {
                    $mdate = $msgInfo[4];
                  } else {
                    $mdate = ' ';
                  }
                  // $mbody = $msgInfo[6];
                }

                if (isset($_GET['mid'])) {
                  $lieferantNameQ =  mysqli_query($dbhandle, "SELECT companies.name, companies.id FROM companies WHERE companies.id LIKE '$olieferantID'");
                  while ($row = mysqli_fetch_assoc($lieferantNameQ)) {
                    $olieferant = $row['name'];
                    $olieferantID = $row['id'];
                  }
                }

                if ($olieferant == '') {
                  $olieferant = 'Please choose a company';
                  $olieferantID = '0';
                }

                $derenCIDQ =  mysqli_query($dbhandle, "SELECT companies.name, lieferantCID.derenCID, lieferantCID.id FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id WHERE lieferantCID.lieferant LIKE '$olieferantID'") or die(mysqli_error($dbhandle));

                $emailBV = $token_data['email'];
                if (($pos2 = strpos($emailBV, "@")) !== false) {
                  $domainBV = substr($emailBV, strpos($emailBV, "@"));
                  $usernameBV = basename($emailBV, $domainBV);
                }

                $workers = array();
                $workers[] = "ndomino";
                $workers[] = "fwaleska";
                $workers[] = "alissitsin";
                $workers[] = "sstergiou";

                $workers2 = array();
                $workers2[] = "ndomino";
                $workers2[] = "fwaleska";
                $workers2[] = "alissitsin";
                $workers2[] = "sstergiou";

                if (($key = array_search($usernameBV, $workers)) !== false) {
                  unset($workers[$key]);
                  $workers = array_values($workers);
                }

                if (($key = array_search($obearbeitetvon, $workers2)) !== false) {
                  unset($workers2[$key]);
                  $workers2 = array_values($workers2);
                }

                // for self-created maintenances without incoming mail
                if (!isset($olieferantDomain)) {
                  $olieferantDomain = '';
                }

                ?>

                <!-- EDIT MODE -->

                <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone" id="addEditDetails">

                    <div class="demo-card-wide3 mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title">
                            <h2 class="mdl-card__title-text">
                                <?php echo $otitlestring ?> Maintenance Entry</h2>
                            <div class="mdl-layout-spacer"></div>
                            <button id="addCalbtn" type="button" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 10px !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                                <span class="mdi mdi-24px mdi-calendar-plus mdi-light"></span>
                            </button>
                            <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="addCalbtn">
                                Create Calendar Entry
                            </div>
                            <button id="btnSave" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                                <i class="material-icons">save</i>
                            </button>
                            <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="btnSave">
                                Save Entry
                            </div>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <small>
                                <?php if ($oupdatedBy != '') {
                                  echo 'Last updated by: <span class="updatedLabel">' . $oupdatedBy . '</span> at <span class="updatedLabel" id="updatedAtLabel">' . $oupdatedAt . '</span>';
                                } ?></small>
                            <form action="#">
                                <div id="gridAppend" class="mdl-grid">
                                    <input type="hidden" value="<?php echo $omaintid ?>" id="maintid">
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" value="<?php if ($omaileingang == '') {
                                                                                                      echo $nowDT;
                                                                                                    } else {
                                                                                                      echo $omaileingang;
                                                                                                    } ?>" id="medt">
                                            <label class="mdl-textfield__label" for="medt">Maileingang Date/Time</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" style="width: 80% !important" value="<?php 
                                                                                                                                  if (!empty($oreceivedmail)) {
                                                                                                                                    echo $oreceivedmail;
                                                                                                                                  } else {
                                                                                                                                    echo uniqid('NT-');
                                                                                                                                  } ?>" id="rmail">
                                            <label class="mdl-textfield__label" for="rmail">Incoming Mail ID</label>

                                            <?php if (!empty($oreceivedmail) && strpos($oreceivedmail, 'NT-') === false) {
                                              echo '
                  <button style="position:absolute; right:0;" id="viewmailbtn" type="button" class=" mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab viewMail2">
                    <i class="mdi mdi-24px mdi-email-search-outline mdi-dark"></i>
                  </button>

                  <div class="mdl-tooltip  mdl-tooltip--bottom" data-mdl-for="viewmailbtn">
                    View Mail
                  </div>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <label style="color: #67B246; font-size: 12px;" class="mdl-selectfield--floating-label">Company</label><br>
                                        <select id="company" name="company" class="company" style="width:80% !important;">
                                            <option selected value="<?php echo $olieferantID ?>">
                                                <?php echo $olieferant ?>
                                            </option>
                                            <?php
                                            $aeCompanyQ =  mysqli_query($dbhandle, "SELECT companies.id, companies.name FROM companies;") or die(mysqli_error($aeCompanyQ));
                                            while ($row = mysqli_fetch_row($aeCompanyQ)) {
                                              if ($row[0] != $olieferantID) {
                                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                              }
                                            }
                                            ?>
                                        </select>
                                        <span class="mdl-selectfield__error">Select a Company</span>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <label style="color: #67B246; font-size: 12px;" class="mdl-selectfield--floating-label">Deren CID</label><br>
                                        <select style="width:80% !important;" class="dcid3" id="dcid3" name="dcid3" multiple></select>
                                        <span class="mdl-selectfield__error">Select a CID</span>
                                        <script>
                                            $(document).ready(function() {

                                            var dCIDQ = $("#company").val();
                                            $.ajax({
                                                    type: 'GET',
                                                    url: 'api?aedCIDc='+dCIDQ
                                                }).then(function (data) {
                                                $('.dcid3').select2({
                                                    multiple: true,
                                                    placeholder: 'Select CID',
                                                    data: data,
                                                    debug: true
                                                });
                                                });
                                            
                                                $('.company').select2();
                                            });

                                            setTimeout(function() {
                                                var mid = $('#activeMID').val();
                                                var dcidSelect = $('.dcid3');
                                                $.ajax({
                                                    type: 'GET',
                                                    url: 'api?aedCIDc2='+mid
                                                }).then(function (data) {

                                                var IDs1 = data[0].id;
                                                // console.log(IDs1);
                                                var idarray = IDs1.split(",");
                                                // console.log(idarray);
                                                $('.dcid3').select2().val(idarray).trigger('change');
                                                })
                                            },1000);
                                            
                                            $('#company').on('change', function() {
                                            $('.dcid3').val(null);
                                            $(".dcid3 option").remove();
                                            $('.dcid3').select2('destroy');
                                            
                                            var dCIDQ = $("#company").val();
                                            $(function () {
                                                $.getJSON( "api?aedCIDc="+dCIDQ, function(respond) {
                                                    $('.dcid3').select2({
                                                        multiple: true,
                                                        data: respond
                                                    });
                                                });
                                            });
                                            });
                                        </script>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr">
                                            <input type="text" id="sdt0" class="mdl-textfield__input" value="<?php echo $newSDT ?>" data-input>
                                            <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span>
                                            <label class="mdl-textfield__label" for="sdt0">Start Date/Time</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr">
                                            <input type="text" id="edt0" class="mdl-textfield__input" value="<?php echo $newEDT ?>" data-input>
                                            <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span>
                                            <label class="mdl-textfield__label" for="edt0">End Date/Time</label>
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
                                                <?php
                                                if (isset($_GET['update'])) :
                                                  ?>
                                                <option selected value="<?php echo $obearbeitetvon ?>">
                                                    <?php echo $obearbeitetvon ?>
                                                </option>
                                                <option value="<?php echo $workers2[0] ?>">
                                                    <?php echo $workers2[0] ?>
                                                </option>
                                                <option value="<?php echo $workers2[1] ?>">
                                                    <?php echo $workers2[1] ?>
                                                </option>
                                                <option value="<?php echo $workers2[2] ?>">
                                                    <?php echo $workers2[2] ?>
                                                </option>
                                                <?php
                                              else :
                                                ?>
                                                <option value="<?php echo $usernameBV ?>">
                                                    <?php echo $usernameBV ?>
                                                </option>
                                                <option value="<?php echo $workers[0] ?>">
                                                    <?php echo $workers[0] ?>
                                                </option>
                                                <option value="<?php echo $workers[1] ?>">
                                                    <?php echo $workers[1] ?>
                                                </option>
                                                <option value="<?php echo $workers[2] ?>">
                                                    <?php echo $workers[2] ?>
                                                </option>
                                                <?php
                                              endif
                                              ?>
                                            </select>
                                            <label class="mdl-selectfield__label" for="bearbeitet">Bearbeitet Von</label>
                                            <span class="mdl-selectfield__error">Select a value</span>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <label class="aeCancel" for="switch-3">
                                            <input type="checkbox" id="switch-3" class="mdl-checkbox__input" <?php echo $cancelled ?>>
                                            <span class="mdl-checkbox__label">Cancelled</span>
                                        </label>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" value="<?php echo $oimpact ?>" id="mimp0">
                                            <label class="mdl-textfield__label" for="mimp0">Impact</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" value="<?php echo $olocation ?>" id="mloc0">
                                            <label class="mdl-textfield__label" for="mloc0">Location</label>
                                        </div>
                                    </div>
                                    <div style="margin-right: calc(12% - 32px) !important;" class="mdl-cell mdl-cell--12-col">
                                        <div style="width: 100%" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" style="" value="<?php echo $oreason ?>" id="mreas0">
                                            <label class="mdl-textfield__label" for="mreas0">Reason</label>
                                        </div>
                                    </div>
                                    <div style="margin-right: calc(12% - 32px) !important;" id="lastSection" class="mdl-cell mdl-cell--12-col">
                                        <div style="margin-top: -20px;" class="mdl-textfield mdl-js-textfield notesTextArea">
                                            <span class="notesLabel1">Notes</span>
                                            <textarea class="mdl-textfield__input" type="text" rows="4" id="notes"><?php echo $onotes ?></textarea>
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
                                    <input type="hidden" value="<?php if (isset($msgInfo[1])) {
                                                                  echo $msgInfo[1];
                                                                } ?>" id="mailDomain">
                                    <input type="hidden" value="<?php echo $activeID ?>" id="activeMID">
                                </div>
                                <?php
                                        // load reschedules
                                        $rescheduleQuery = mysqli_query($dbhandle, "SELECT * FROM reschedule WHERE reschedule.maintenanceid LIKE '$activeID' AND reschedule.active LIKE 1;");
                                        $rescheduleCount = 1;
                                        if(mysqli_num_rows($rescheduleQuery)!=0) {
                                            while($row = mysqli_fetch_assoc($rescheduleQuery)) {
                                                echo '<div data-val="' . $rescheduleCount . '" class="rescheduleBlock mdl-grid"><div class="mdl-cell mdl-cell--12-col"><span class="rescheduleHeader">Reschedule ' . $rescheduleCount . '</span><span style="float:right"><span class="rescheduleUser rescheduleUser' . $rescheduleCount . '">' . $row['user'] . '</span><span style="font-family:Roboto;font-weight:300;color:#67B246"> at </span><span class="rescheduleTime rescheduleTime' . $rescheduleCount . '">' . $row['datetime'] . '</span><button id="removeReschedule' . $rescheduleCount . '" type="button" style="display: inline; height: 32px; width: 32px; min-width: 32px !important; margin: 0 0 0 10px !important;" class="removeRescheduleBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"> <span class="mdi mdi-18px mdi-trash-can-outline mdi-light"></span> </button> <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="removeReschedule' . $rescheduleCount . '">Delete</div></span></div><div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr' . $rescheduleCount . '"> <input type="text" id="sdt' . $rescheduleCount . '" class="mdl-textfield__input"  value="' . $row['sdt'] . '" data-input> <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span> <label class="mdl-textfield__label" for="sdt' . $rescheduleCount . '">New Start Date/Time</label> </div> </div> <div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr' . $rescheduleCount . '"> <input type="text" id="edt' . $rescheduleCount . '" class="mdl-textfield__input"  value="' . $row['edt'] . '" data-input> <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span> <label class="mdl-textfield__label" for="edt' . $rescheduleCount . '">New End Date/Time</label> </div> </div><div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" value="' . $row['impact'] . '" id="mimp' . $rescheduleCount . '"> <label class="mdl-textfield__label" for="mimp' . $rescheduleCount . '">Impact</label> </div> </div> <div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" value="' . $row['location'] . '" id="mloc' . $rescheduleCount . '"> <label class="mdl-textfield__label" for="mloc' . $rescheduleCount . '">Location</label> </div> </div><div style="margin-right:calc(12% - 32px)!important" class="mdl-cell mdl-cell--12-col"> <div style="width: 100%" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" style="" value="' . $row['reason'] .'" id="mreas' . $rescheduleCount . '"> <label class="mdl-textfield__label" for="mreas' . $rescheduleCount . '">Reason</label> </div> </div></div>';

                                                echo '<script>
                                                      $( \'.flatpickr'. $rescheduleCount.'\' ).flatpickr({
                                                        enableTime: true,
                                                        dateFormat: \'Z\',
                                                        time_24hr: true,
                                                        wrap: true,
                                                        altInput: true,
                                                        altFormat: \'d M Y H:i:S\'
                                                        });
                                                      </script>';
                                                $rescheduleCount = $rescheduleCount + 1;
                                           } 
                                        }
                                    ?>
                            </form>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <div style="display: inline;">
                                <button id="rescheduleBtn" type="button" style="display: inline; height: 44px; width: 44px; min-width: 44px !important; margin: 0 !important;" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                                    <span class="mdi mdi-24px mdi-calendar mdi-light"></span>
                                </button>
                                <div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="rescheduleBtn">
                                    Reschedule Maintenance
                                </div>
                                <label style="display: inline; margin-right: 5px; float: right;width: 150px; margin-left:15px; line-height: 2.8em;" class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                                    <span style="color: #6e6e6e;line-height: 44px !important;" id="confettiSwitch" class="mdl-switch__label">Completed</span>
                                    <input type="checkbox" id="switch-2" class="mdl-switch__input" <?php echo $odone ?>>
                                </label>
                                <div class="mdl-layout-spacer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mailHider">
                        <?php
                        if (isset($msubject)) {
                          echo '<div id="mailDialog" class="mailDialog1" style="">
                                <div class="mailcSelectHeader">
                                <h6 class="labelSelectLabel"><font color="#67B246">Sub:</font> ' . $msubject . '</h6><br>
                                <h6 class="sublabelSelectLabel"><font color="#67B246">From:</font> ' . $mfrom . '</h6><br>
                                <h6 class="sublabelSelectLabel"><font color="#67B246">Date:</font> ' . $mdate . '</h6>';

                                        if (isset($msgInfo[5])) {
                                            $attachmentParts2 = $msgInfo[5];
                                            if ($attachmentParts2[0][1] !== '') {
                                            echo '<div style="margin-top:-30px;float:right;text-align:right;z-index:1000;position:relative;">
                                    <font style="color:#4c4c4c">Attachments:</font><br>';
                                            foreach ($attachmentParts2 as $part) {
                                                echo '<a class="attachmentLink" target="_blank" href="attachments?messageId=' . $oreceivedmail . '&part_id=' . $part[0] . '">' . $part[1] . '</a><br>';
                                            }
                                            } else {
                                            echo '<div style="margin-top:-30px;float:right;text-align:right;z-index:1000;position:relative;">
                                    <font style="color:#4c4c4c"></font><br>';
                                            }
                                        } else {
                                            echo '<div style="margin-top:-30px;float:right;text-align:right;z-index:1000;position:relative;">
                                    <font style="color:#4c4c4c"></font><br>';
                                        }
                                        echo '</div><br><br></div>
                                <div class="mdl-dialog__content">
                                <p>
                                <div class="mailcHR">NT</div>
                                    <div class="mailWrapper0">
                                        <div class="mdl-textfield mdl-js-textfield mailWrapper1">
                                        <div style="display:inline-block !important;height: 100%;margin-top: 20px;" class=" mailWrapper2">';
                                        if(strpos($oreceivedmail,'NT-')==false) {
                                            echo '<iframe onload="resizeIframe(this)" class="frameClass" style="margin-top: 20px;" height="100%" width="100%" frameborder="0"  id="emailBodyFrame" src="https://maintenance.newtelco.de/msg/' . $oreceivedmail . '.html"></iframe>';
                                            }
                                        echo '</div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                </div>';
                        } else {
                          echo '</div>';
                        }
                        ?>
                    </div>
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
                                        <th>Sent</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="snackbarAddedit" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div>

            <dialog id="xlsDialog" class="mdl-dialog">
                <h4 id="xlsTitle" class="mdl-dialog__title"></h4>
                <div class="mdl-dialog__actions">
                    <button tabindex="-1" type="button" class="close2 mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect">
                        <i class="material-icons">close</i>
                    </button>
                </div>
                <div id="gridWrapper" class="mdl-dialog__content">

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
                $(window).resize(function() {
                    $('#timezoneSelector + .select2-container').width($('#mreas0').width());
                })

                function resizeIframe(obj) {
                    obj.height = obj.contentWindow.document.body.scrollHeight;
                    obj.width = obj.contentWindow.document.body.scrollWidth;

                    obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
                    obj.style.width = obj.contentWindow.document.body.scrollWidth + "px";
                }

                $('#btnShowSent').click(function() {

                    var jMailSentAt = $("#mailSentAt").val();
                    var DateTime = luxon.DateTime;
                    var jMailSentAtDate = DateTime.fromSQL(jMailSentAt).toFormat("y-MM-d");
                    // var jMailSentAtDate2 = jMailSentAtDate.local();
                    var jMailSentAtDate3 = DateTime.fromISO(jMailSentAtDate).plus({
                        days: 1
                    }).toISODate();
                    // .add(1, 'days');
                    // .plus({ days: 1 });
                    //console.log(jMailSentAtDate3);

                    table4 = $('#dataTable4').DataTable();
                    var kUnsereCIDs = table4
                        .columns(1)
                        .data()
                        .eq(0) // Reduce the 2D array into a 1D array of data
                        .sort() // Sort data alphabetically
                        .unique() // Reduce to unique values

                    var cidSearch = [];
                    for (i = 0; i < kUnsereCIDs.length; i++) {
                        // var cidSearch = array(); 
                        cidSearch[i] = '(Planned Work Notification on CID: ' + kUnsereCIDs[i] + ')';
                    }
                    if (cidSearch.length > 1) {
                        var cidSearchjoined = cidSearch.join(' OR ');
                    } else {
                        var cidSearchjoined = cidSearch[0];
                    }
                    // before:${jMailSentAtDate3}
                    var activeUser = $(".menumail").html();
                    openInNewTab(`https://mail.google.com/mail/ca/u/0/#search/in:sent+after:${jMailSentAtDate}+before:${jMailSentAtDate3}+from:maintenance@newtelco.de+subject:${cidSearchjoined}`);
                });

                $('#addCalbtn').click(function() {

                    // ajax save when making cal 

                    var activeID = $('#activeMID').val();
                    if ($('#switch-2:checked').val() == 'on') {
                        var odone = '1';
                        const button = document.querySelector("#confettiSwitch");
                        confetti(button);
                    } else {
                        var odone = '0';
                    }
                    var mailSentAt = $('#mailSentAt').val();
                    var rmail = $('#rmail').val();

                    $.ajax({
                        type: "POST",
                        url: "api?doneEvent=1&d=" + odone + "&msa=" + mailSentAt + "&id=" + activeID + "&gid=" + rmail,
                        cache: "false",
                        dataType: "json",
                        success: function(data) {
                            if (data.updated === 1) {
                                var snackbarContainer2 = document.querySelector('#snackbarAddedit');
                                var dataME3 = {
                                    message: 'Maintenance Status Saved',
                                    timeout: 2000
                                };
                                snackbarContainer2.MaterialSnackbar.showSnackbar(dataME3);
                            }
                        },
                        error: function(err) {
                            console.log('Error', err);
                        }
                    });

                    // create Calendar URL to click

                    var calSDT = $('#sdt0').val();
                    var calSDTISO = moment(calSDT).toISOString().replace(/[^a-z0-9s]/gi, '');
                    var calSDTISO2 = calSDTISO.replace('000Z', 'Z');

                    var calEDT = $('#edt0').val();
                    var calEDTISO = moment(calEDT).toISOString().replace(/[^a-z0-9\s]/gi, '');;
                    var calEDTISO2 = calEDTISO.replace('000Z', 'Z');

                    var selectedDCID = $("#dcid3 option:selected").text().trim();

                    var selectedDCIDAr = $('#dcid3').select2('data');
                    var selectedDCIDar2 = [];

                    for (var i = 0; i < Object.keys(selectedDCIDAr).length; i++) {
                        var dcidtext1 = selectedDCIDAr[i].text;
                        // console.log(dcidtext1);
                        selectedDCIDar2.push(dcidtext1);
                    }
                    var selectedDCIDjoin = selectedDCIDar2.join(', ').trim().replace(/\s/g, '%20');

                    // console.log(selectedDCIDjoin);

                    var selectedCompanyAr = $('#company').select2('data');
                    var selectedCompany = selectedCompanyAr[0].text.trim();

                    var activeID = $('#activeMID').val();

                    table4 = $('#dataTable4').DataTable();
                    var data = table4.row($('tr')).data();

                    // concat all visible 'unsere CIDs' from kunden table aka selected 'deren CIDs'
                    var kIDsconcat = table4
                        .columns(1)
                        .data()
                        .eq(0) // Reduce the 2D array into a 1D array of data
                        .sort() // Sort data alphabetically
                        .unique() // Reduce to unique values
                        .join(', ')
                        .replace(/\s/g, '%20');

                    varCalLink = `http://www.google.com/calendar/event?action=TEMPLATE&dates=${calSDTISO2}%2F${calEDTISO2}&src=newtelco.de_hkp98ambbvctcn966gjj3c7dlo@group.calendar.google.com&text=Maintenance%20${selectedCompany}%20CID%20${kIDsconcat}&add=service@newtelco.de&details=Maintenance%20for%20<b>${selectedCompany}</b>%20on%20deren%20CID:%20"<b>${selectedDCIDjoin}</b>".<br><br>Affected%20Newtelco%20CIDs:%20<b>${kIDsconcat}</b><br><br>Source%20-%20<a href="https://maintenance.newtelco.de/addedit?mid=${activeID}">NT-M_${activeID}</a>&trp=false`;
                    console.log(varCalLink);
                    openInNewTab(varCalLink);
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

                $('#dcid3').on('change', function(e) {
                    if ($.fn.dataTable.isDataTable('#dataTable4')) {
                        table3 = $('#dataTable4').DataTable();
                        table3.destroy();
                    }

                    // var data3 = $('#dcid3').val();
                    var data3 = $("#dcid3").find(":selected").val();

                    var selectedIDs = $("#dcid3").find(":selected");

                    var data4 = $("option:selected", this).map(function() {
                        return $(this).val();
                    }).toArray().join(", ");

                    data4 = data4.trim();

                    $('#kundenCard').addClass('display').removeClass('hidden');
                    //filter by selected value on second column
                    var table4 = $('#dataTable4').DataTable({
                        ajax: {
                            url: "api?dCID=" + data4,
                            dataSrc: ""
                        },
                        columns: [{
                                title: "Notification"
                            },
                            {
                                data: "kundenCID"
                            },
                            {
                                data: "protected"
                            },
                            {
                                data: "name"
                            },
                            {
                                data: "kunde"
                            },
                            {
                                data: "maintenanceRecipient"
                            },
                            {
                                title: "Sent",
                                data: ''
                            }
                        ],
                        columnDefs: [{
                            "targets": [4],
                            "visible": false,
                            "searchable": false
                        }, {
                            "targets": 0,
                            "data": null,
                            "defaultContent": "<button style='margin-left:3px;text-align:center;' id='sendMailbtn' type='button' class='mdl-color--light-green-nt mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored button40'><span class='mdi mdi-send mdi-24px'></span></button><div class='mdl-tooltip  mdl-tooltip--bottom' data-mdl-for='sendMailbtn'> Send Notification </div>",
                            className: 'mdl-data-table__cell--non-numeric text-center'
                        }, {
                            targets: -1,
                            data: null,
                            <?php
                            if ($odoneVal == '1') :
                              ?>
                            defaultContent: "<span id='sentIndicator' class='mdi mdi-24px mdi-check-decagram mdi-dark'></span>",
                            <?php
                          else :
                            ?>
                            defaultContent: "<span id='sentIndicator' class='mdi mdi-24px mdi-checkbox-blank-circle-outline mdi-dark mdi-inactive'></span>",
                            <?php
                          endif;
                          ?>
                            className: 'mdl-data-table__cell--non-numeric'
                        }, {
                            targets: [1, 5],
                            className: "datatablesWraptext"
                        }, {
                            targets: [1, 2, 3, 5],
                            className: 'mdl-data-table__cell--non-numeric'
                        }, {
                            targets: [2],
                            render: function(a, b, data, d) {
                                if (data['protected'] == '0') {
                                    return 'Unprotected'
                                } else if (data['protected'] == '1') {
                                    return 'Protected';
                                } else {
                                    return data['protected'];
                                }
                            }
                        }, {
                            targets: [1],
                            render: function(a, b, data, d) {
                                return '<b>' + data['kundenCID'] + '</b>';
                            }
                        }, {
                            targets: [3],
                            render: function(a, b, data, d) {
                                return '<b style="color:#67B246">' + data['name'] + '</b>';
                            }
                        }, {
                            targets: [5],
                            render: function(a, b, data, d) {
                                if (data['maintenanceRecipient'] != '') {
                                    // var mrLowercase = data['maintenanceRecipient'].toLowerCase();
                                    // return mrLowercase;
                                    return data['maintenanceRecipient'];
                                } else {
                                    return data['maintenanceRecipient'];
                                }
                            }
                        }, {
                            responsivePriority: 1,
                            targets: [0, 1, 3]
                        }],
                        responsive: true
                    });

                });


                /***********************
                 * Complete Switch Event
                 ***********************/

                $("#switch-2").click(function() {
                    var activeID = $('#activeMID').val();
                    if ($('#switch-2:checked').val() == 'on') {
                        var odone = '1';
                        const button = document.querySelector("#confettiSwitch");
                        confetti(button);
                    } else {
                        var odone = '0';
                    }
                    var mailSentAt = $('#mailSentAt').val();
                    var rmail = $('#rmail').val();

                    $.ajax({
                        type: "POST",
                        url: "api?doneEvent=1&d=" + odone + "&msa=" + mailSentAt + "&id=" + activeID + "&gid=" + rmail,
                        cache: "false",
                        dataType: "json",
                        success: function(data) {
                            if (data.updated === 1) {
                                var snackbarContainer2 = document.querySelector('#snackbarAddedit');
                                var dataME3 = {
                                    message: 'Maintenance Status Saved',
                                    timeout: 2000
                                };
                                snackbarContainer2.MaterialSnackbar.showSnackbar(dataME3);
                            }
                        },
                        error: function(err) {
                            console.log('Error', err);
                        }
                    });
                });
                /************************
                 * RESCHEDULE BTN EVENT
                 ************************/

                function removeRescheduleEvent() {
                     var rescheduleNum = $(this).closest('.rescheduleBlock').attr('data-val');
                     var activeMID = $('#activeMID').val();

                     $('.rescheduleBlock[data-val='+rescheduleNum+']').css('display','none');

                     $.ajax({
                         type: "GET",
                         url: "api?rmReschedule="+rescheduleNum+"&mid="+activeMID,
                         cache: "false",
                         dataType: "json",
                         success: function(data) {
                            if(data.removed == 1) {
                                var snackbarContainer4 = document.querySelector('#snackbarAddedit');
                                var dataRM1 = {
                                    message: 'Reschedule Entry Removed',
                                    timeout: 2000
                                };
                                snackbarContainer4.MaterialSnachbar.showSnackbar(dataRM1);
                            }
                         },
                         error: function(e) {
                            console.log('Reschedule Remove Error: ', e);
                         }
                     })
                }

                /*********************
                 * RESCHEDULE BTN 
                 *********************/
                var rescheduleCount = '1';
                $('#rescheduleBtn').on('click', function() {
                    var itemToAppendTo = $('#gridAppend');
                    if($('.rescheduleBlock')) {
                        var existingRScount = $('.rescheduleBlock').length;
                        itemToAppendTo = $('.rescheduleBlock[data-val=' + existingRScount + ']');
                        existingRScount++;
                        rescheduleCount = existingRScount;
                    }
                    var rescheduleUser = $('.menumail').text();
                    moment.locale('de-DE');
                    var rescheduleTime = moment().format('DD.MM.YYYY HH:mm:SS');
                    console.log(itemToAppendTo);
                    $('#gridAppend').append('<div data-val="' + rescheduleCount + '" class="rescheduleBlock mdl-grid"><div class="mdl-cell mdl-cell--12-col"><span class="rescheduleHeader">Reschedule ' + rescheduleCount + '</span><span style="float:right"><span class="rescheduleUser rescheduleUser' + rescheduleCount + '">' + rescheduleUser + '</span><span style="font-family:Roboto;font-weight:300;color:#67B246"> at </span><span class="rescheduleTime rescheduleTime' + rescheduleCount + '">' + rescheduleTime + '</span><button id="removeReschedule' + rescheduleCount + '" type="button" style="display: inline; height: 32px; width: 32px; min-width: 32px !important; margin: 0 0 0 10px !important;" class="removeRescheduleBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"> <span class="mdi mdi-18px mdi-trash-can-outline mdi-light"></span> </button> <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="removeReschedule' + rescheduleCount + '">Delete</div></span></div><div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr' + rescheduleCount + '"> <input type="text" id="sdt' + rescheduleCount + '" class="mdl-textfield__input"  value="" data-input> <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span> <label class="mdl-textfield__label" for="sdt' + rescheduleCount + '">New Start Date/Time</label> </div> </div> <div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label flatpickr' + rescheduleCount + '"> <input type="text" id="edt' + rescheduleCount + '" class="mdl-textfield__input"  value="" data-input> <span class="mdl-textfield__label__icon mdi mdi-24px mdi-calendar-clock" title="toggle" data-toggle></span> <label class="mdl-textfield__label" for="edt' + rescheduleCount + '">New End Date/Time</label> </div> </div><div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" value="" id="mimp' + rescheduleCount + '"> <label class="mdl-textfield__label" for="mimp' + rescheduleCount + '">Impact</label> </div> </div> <div class="mdl-cell mdl-cell--6-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" value="" id="mloc' + rescheduleCount + '"> <label class="mdl-textfield__label" for="mloc' + rescheduleCount + '">Location</label> </div> </div><div style="margin-right:calc(12% - 32px)!important" class="mdl-cell mdl-cell--12-col"> <div style="width: 80%" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" type="text" id="mreas' + rescheduleCount + '"> <label class="mdl-textfield__label" for="mreas' + rescheduleCount + '">Reason</label> </div> </div></div>');
                    
                    flatpickr('.flatpickr'+rescheduleCount);

                    var preRescheduleCount = rescheduleCount - 1;
                    $('#sdt' + rescheduleCount).val($('#sdt' + preRescheduleCount).val());
                    $('#edt' + rescheduleCount).val($('#edt' + preRescheduleCount).val());
                    $('#mimp' + rescheduleCount).val($('#mimp' + preRescheduleCount).val());
                    $('#mreas' + rescheduleCount).val($('#mreas' + preRescheduleCount).val());
                    $('#mloc' + rescheduleCount).val($('#mloc' + preRescheduleCount).val());
                    $('#removeReschedule'+rescheduleCount).on('click',removeRescheduleEvent);

                    $('.flatpickr' + rescheduleCount).flatpickr({
                        enableTime: true,
                        dateFormat: 'Z',
                        time_24hr: true,
                        wrap: true,
                        altInput: true,
                        altFormat: 'd M Y H:i:S'
                    });

                    $('.flatpickr3').flatpickr({
                        enableTime: true,
                        dateFormat: 'Z',
                        time_24hr: true,
                        wrap: true,
                        altInput: true,
                        altFormat: 'd M Y H:i:S'
                    });

                    // componentHandler.upgradeElements($('#edt'+rescheduleCount).get());
                    // componentHandler.upgradeElements($('#sdt'+rescheduleCount).get());
                    componentHandler.upgradeElements($('#mimp'+rescheduleCount).parent().get());
                    componentHandler.upgradeElements($('#mloc'+rescheduleCount).parent().get());
                    componentHandler.upgradeElements($('#mreas'+rescheduleCount).parent().get());
                    componentHandler.upgradeAllRegistered();

                    rescheduleCount++;
                })
                
                /****************************
                 * Remove Reschedule Button
                 ****************************/
               

                $('.removeRescheduleBtn').on('click',removeRescheduleEvent);

                /*********************
                 * Save Button Event
                 *********************/

                $('#btnSave').on('click', function(e) {

                    e.preventDefault();

                    // Some formatting before we push to mysql
                    var DateTime = luxon.DateTime;

                    // console.log($('#medt').val());
                    if ($('#medt').val() != '') {
                        var medt = $('#medt').val();
                        var medtUTC = moment.parseZone(medt).utc().format();
                        var medtISO = moment(medtUTC).toISOString();
                    } else {
                        var medtISO = moment().format();
                    }

                    var mdtTZ = $('#timezoneSelector').val();

                    var mSDT = $('#sdt0').val();
                    var mSDT = moment(mSDT).format('YYYY-MM-DD\THH:mm:ss');
                    var zOffset = moment.tz(mdtTZ).format('Z');
                    var tzConcat = mSDT.concat(zOffset);
                    var sdtUTC = moment(tzConcat).utc().format();
                    var mEDT = $('#edt0').val();
                    var mEDT = moment(mEDT).format('YYYY-MM-DD\THH:mm:ss');
                    var tzConcat2 = mEDT.concat(zOffset);
                    var edtUTC = moment(tzConcat2).utc().format();

                    if ($('#switch-2:checked').val() == 'on') {
                        var odone = '1';
                    } else {
                        var odone = '0';
                    }
                    if ($('#switch-3:checked').val() == 'on') {
                        var cancelled = '1';
                    } else {
                        var cancelled = '0';
                    }

                    table4 = $('#dataTable4').DataTable();
                    var kCompaniesConcat = table4
                        .columns(3)
                        .data()
                        .eq(0) // Reduce the 2D array into a 1D array of data
                        .sort() // Sort data alphabetically
                        .unique() // Reduce to unique values
                        .join(',');
                    // console.log('kCompaniesConcat: ' + kCompaniesConcat);

                    var kCIDsConcat = table4
                        .columns(1)
                        .data()
                        .eq(0) // Reduce the 2D array into a 1D array of data
                        .sort() // Sort data alphabetically
                        .unique() // Reduce to unique values
                        .join(',');
                    // console.log('kCIDsConcat: ' + kCIDsConcat);

                    var getSelected = $('#dcid3').val();
                    var selectedNums = [];
                    for (var i = 0; i < getSelected.length; i++) {
                        selectedNums.push(getSelected[i]);
                    }
                    var dcid = selectedNums.join(',');

                    if($('#mimp0').val().length > 64) {
                        alert('Impact must be less than 64 characters!');
                        return;
                    }

                    if($('#mloc0').val().length > 64) {
                        alert('Location must be less than 64 characters!');
                        return;
                    }
                    console.log($('#mreas0').val().length);

                    if($('#mreas0').val().length > 128) {
                        alert('Reason must be less than 128 characters!');
                        return;
                    }

                    var TableData = new Array();
                    TableData[0] = {
                        "omaintid": $('#maintid').val(),
                        "omaileingang": medtISO,
                        "oreceivedmail": $('#rmail').val(),
                        "olieferant": $('#company option:selected').text(),
                        "olieferantid": $("#company").val(),
                        "oderenCIDid": dcid,
                        "obearbeitetvon": $('#bearbeitet').val(),
                        "omaintenancedate": $('#mdt').val(),
                        "ostartdatetime": sdtUTC,
                        "oenddatetime": edtUTC,
                        "opostponed": $('#pponed').val(),
                        "onotes": $('#notes').val(),
                        "oimp": $('#mimp0').val(),
                        "oloc": $('#mloc0').val(),
                        "oreas": $('#mreas0').val(),
                        //"omailankunde" : makdtUTC.toString(),
                        "mailSentAt": $('#mailSentAt').val(),
                        "odone": odone,
                        "cancelled": cancelled,
                        "update": $('#update').val(),
                        "updatedBy": $('.menumail').text(),
                        "gmailLabel": $('#gmailLabel').val(),
                        "mailDomain": $('#mailDomain').val(),
                        "kundenCompanies": kCompaniesConcat,
                        "kundenCIDs": kCIDsConcat
                    }

                    var rescheduleCounts = $('.rescheduleBlock').length;
                    for (i = 0; i < rescheduleCounts; i++) {
                        i++;
                        var newUser = $('.rescheduleUser'+i).text().trim();
                        var newEditTime = $('.rescheduleTime'+i).text();
                        var newSdt = $('#sdt'+i).val();
                        var newEdt = $('#edt'+i).val();
                        var newReas = $('#mreas'+i).val();
                        var newLoc = $('#mloc'+i).val();
                        var newImp = $('#mimp'+i).val();
                        TableData.push({
                          'rUser': newUser,
                          'rEditTime' : newEditTime,
                          'rSdt' : newSdt,
                          'rEdt' : newEdt,
                          'rReas' : newReas,
                          'rLoc' : newLoc,
                          'rImp' : newImp 
                        });
                    }

                    $.ajax({

                        type: "POST",
                        url: "api",
                        cache: "false",
                        dataType: "json",
                        data: {
                            data: TableData
                        },
                        success: function(result1) {
                            var obj = JSON.stringify(result1);

                            var snackbarContainer = document.querySelector('#snackbarAddedit');
                            if (result1.exist === 1) {
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
                            } else if (result1.added === 1) {
                                var dataME2 = {
                                    message: 'Maintenance Successfully Saved',
                                    timeout: 2000
                                };
                                snackbarContainer.MaterialSnackbar.showSnackbar(dataME2);
                                
                            } else if (result1.updated === 1) {
                                var dataME3 = {
                                    message: 'Maintenance Successfully Updated',
                                    timeout: 2000
                                };
                                snackbarContainer.MaterialSnackbar.showSnackbar(dataME3);
                            } else {
                                var dataME4 = {
                                    message: 'Invalid Response',
                                    timeout: 2000
                                };
                                snackbarContainer.MaterialSnackbar.showSnackbar(dataME4);
                            }
                            if (result1.updatedID != '') {
                                var newID = result1.updatedID;
                                window.location.href = "https://maintenance.newtelco.de/addedit?gmid=" + $('#rmail').val() + "&mid=" + newID + "&update=1";
                            }
                        }
                    });
                }); // clicking orderSave button
            </script>
            <script>
                if ($("#viewmailbtn").length > 0) {

                    var mailID = $('#rmail').val();

                    $("#emailBodyFrame").attr('src', "msg/" + mailID + ".html");
                    $("#emailBodyFrame").attr('src', function(i, val) {
                        return val;
                    });

                    /*********************
                     *  Mail preview
                     *********************/

                    var showDialogButton = document.querySelector('#viewmailbtn');
                    var dialog = $('#mailDialog').get(0).outerHTML;

                    showDialogButton.addEventListener('click', function() {
                        var msgPanel = jsPanel.create({
                            theme: 'rgba(66,66,66,.7)',
                            border: "3px solid",
                            borderRadius: 8,
                            closeOnEscape: true,
                            boxShadow: 4,
                            headerTitle: 'Mail Preview',
                            position: 'right-center -20 0',
                            contentSize: '48% 75%',
                            overflow: {
                                vertical: 'scroll',
                                horizontal: 'scroll'
                            },
                            content: dialog,
                            animateIn: 'animated fadeIn',
                            animateOut: 'animated zoomOut',
                            callback: function() {
                                this.content.style.padding = '20px';
                                $('.attachmentLink').on('click', function(e) {
                                    var targetText = $('.attachmentLink').text();
                                    if (targetText.indexOf("xls") >= 0) {
                                        var xlsDialog = $('#gridWrapper').get(0).outerHTML;
                                        var xlsWrapper = document.createElement('div');
                                        xlsWrapper.id = 'xlsWrapper';
                                        e.preventDefault();
                                        if ($('canvas-datagrid').length == '0') {
                                            var url = $('.attachmentLink').attr('href');
                                            $('.xlsDownload').attr('href', url);
                                            var req = new XMLHttpRequest();
                                            req.open("GET", url, true);
                                            req.responseType = "arraybuffer";
                                            req.onload = function(e) {
                                                /* parse the data when it is received */
                                                var data = new Uint8Array(req.response);
                                                var workbook = XLSX.read(data, {
                                                    type: "array"
                                                });
                                                /* DO SOMETHING WITH workbook HERE */
                                                var grid = canvasDatagrid({
                                                    parentNode: document.getElementById('gridctr'),
                                                    data: []
                                                });
                                                var ws = workbook.Sheets[workbook.SheetNames[0]];
                                                grid.data = XLSX.utils.sheet_to_json(ws, {
                                                    header: 1
                                                });
                                                // grid.style.height = auto;
                                                grid.style.width = '100%';
                                                $('#gridctr').height('180px');
                                            };
                                            req.send();
                                        }
                                        setTimeout(function() {
                                            var xlsPanel = jsPanel.create({
                                                theme: 'rgba(66,66,66,.7)',
                                                border: "3px solid",
                                                borderRadius: 8,
                                                closeOnEscape: true,
                                                boxShadow: 4,
                                                headerTitle: 'Excel Content',
                                                position: 'right-center -20 0',
                                                contentSize: '38% 35%',
                                                content: xlsWrapper,
                                                animateIn: 'animated fadeIn',
                                                animateOut: 'animated zoomOut',
                                                callback: function() {
                                                    var e = document.getElementById('xlsWrapper');
                                                    var s = document.getElementById('gridctr');
                                                    e.appendChild(s);
                                                }
                                            });

                                            xlsPanel.dock({
                                                master: msgPanel,
                                                position: {
                                                    my: 'right-top',
                                                    at: 'left-top',
                                                    offsetX: -5
                                                },
                                                linkSlaveHeight: false,
                                                linkSlaveWidth: false
                                            });

                                        }, 800);

                                    }
                                });
                            }
                        });

                        OverlayScrollbars(document.getElementsByClassName("jsPanel-content"), {
                            className: "os-theme-minimal-dark",
                            resize: "vertical"
                        });
                    });

                }

                $('#edt0').on('change', function() {
                    var start = moment($('#sdt0').val());
                    var end = moment($('#edt0').val());
                    if (start != '') {
                        var ms = moment(end).diff(moment(start));
                        var d = moment.duration(ms).asMinutes();
                        document.getElementById('mimp0').parentElement.MaterialTextfield.change(d + ' minutes');
                    }
                })

                document.addEventListener("DOMContentLoaded", function() {

                    // Adjusting Timezones and Date/Time Format
                    var mEingangVal = moment($('#medt').val()).format("DD MMM YYYY HH:mm:SS ZZ");
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

                    $('#dataTable4').on('click', '#sendMailbtn', function() {
                        table3 = $('#dataTable4').DataTable();
                        var data = table3.row($(this).parents('tr')).data();

                        var impact = $('#mimp0').val();
                        var location = $('#mloc0').val();
                        var reason = $('#mreas0').val();


                        var start = moment($('#sdt0').val());
                        var end = moment($('#edt0').val());

                        var startTimeLabel = start.format("DD MMM YYYY HH:mm:SS");
                        var endTimeLabel = end.format("DD MMM YYYY HH:mm:SS");

                        var tzSuffix = $("#timezoneSelector option:selected").text();
                        var regExp = /\(([^)]+)\)/;
                        var matches = regExp.exec(tzSuffix);
                        var tzSuffixRAW = matches[1];
                        tzSuffixRAW = tzSuffixRAW.replace("+", "%2B");

                        var rescheduleText = '';
                        var rescheduleHeader = '';

                        if($('.rescheduleBlock').length) {
                            var rescheduleMaxCount = $('.rescheduleBlock').length;
                            var rescheduleNewSDT = $('#sdt'+rescheduleMaxCount).val(); 
                            rescheduleNewSDT = moment(rescheduleNewSDT).format('DD MMM YYYY HH:mm:SS');
                            var rescheduleNewEDT = $('#edt'+rescheduleMaxCount).val(); 
                            rescheduleNewEDT = moment(rescheduleNewEDT).format('DD MMM YYYY HH:mm:SS');
                            var rescheduleNewImp = $('#mimp'+rescheduleMaxCount).val(); 
                            var rescheduleNewLoc = $('#mloc'+rescheduleMaxCount).val(); 
                            var rescheduleNewReas = $('#mreas'+rescheduleMaxCount).val(); 

                            rescheduleHeader = '[RESCHEDULED] ';

                            rescheduleText = 'Dear Colleagues,<p>We regret to inform you the below mentioned scheduled maintenance has been reschedule.</p><p>The new details are as follows:</p><b class="gray">New Start Date/Time:</b> ' + rescheduleNewSDT + ' (' + tzSuffixRAW + ')<br><b class="gray">New End Date/Time:</b> ' + rescheduleNewEDT + ' (' + tzSuffixRAW + ')<br>';

                            if(rescheduleNewImp != '') {
                                rescheduleText += '<b class="gray">New Impact:</b> ' + rescheduleNewImp + '<br>';
                            }

                            if(rescheduleNewLoc != '') {
                                rescheduleText += '<b class="gray">New Location:</b> ' + rescheduleNewLoc + '<br>';
                            }

                            if(rescheduleNewReas != '') {
                                rescheduleText += '<b class="gray">New Reason:</b> ' + rescheduleNewReas + '<br>';
                            }

                            rescheduleText += '<br>Thanks,<br><b class="gray">Newtelco Maintenance Team</b><br><br><hr><br>';
                            
                            rescheduleBuffer = '<table border="0 " cellspacing="0 " cellpadding="0" width="775 style="width:581.2pt;border-collapse:collapse;border:none"> <tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"> <span class="grayText10">Start date and time:</span></p></td><td class="tdSizing"> <p style="margin-bottom:12.0pt;text-align:justify"><b><span class="grayText10">' + rescheduleNewSDT + ' (' + tzSuffixRAW + ')</span></b></p></td></tr><tr> <td class="tdSizing"> <p style="margin-​​bottom:12.0pt"><span class="grayText10">Finish date and time:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><b><span​​ class="grayText10">​​' + rescheduleNewEDT + ' (' + tzSuffixRAW + ')</span></b></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Impact:</span></p></td><td class="tdSizing2"> <p style="margi​​n-bottom:12.0pt;text-align:justify"><span class="grayText10">' + rescheduleNewImp + '</span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Location:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span class="grayText10">' + rescheduleNewLoc + '</span></p></td></tr><tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Reason:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span class="grayText10">' + rescheduleNewReas + '</span></p></td></tr></table><br><hr><br>';
                            // rescheduleText = '';
                        }

                        var body = '<style>.grayText10{​​font-size:10pt;font-family:\'Arial\',sans-serif;color:#636266}.tdSizing{width:140px;padding:0cm 5.4pt 0cm 5.4pt;vertical-align:text-top;width:131px}.tdSizing2{width:140px;padding:0cm 5.4pt 0cm 5.4pt;vertical-align:text-top;width:624px}b{color:#636266}</style><body style="​​padding:0;margin:0;​​​" class="grayText10"><div​​ ​style="​font-size:10pt;font-family:\'Arial\',sans-serif;color:#636266" class="grayText10"​​>' + rescheduleText + 'Dear Colleagues,​​<p><span>We would like to inform you about planned work on the CID ​' + data['kundenCID'] + '. The maintenance work is with the following details</span></p><table border="0 " cellspacing="0 " cellpadding="0" width="775 style="width:581.2pt;border-collapse:collapse;border:none"> <tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"> <span class="grayText10">Start date and time:</span></p></td><td class="tdSizing"> <p style="margin-bottom:12.0pt;text-align:justify"><b><span class="grayText10">' + startTimeLabel + ' (' + tzSuffixRAW + ')</span></b></p></td></tr><tr> <td class="tdSizing"> <p style="margin-​​bottom:12.0pt"><span class="grayText10">Finish date and time:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><b><span​​ class="grayText10">​​' + endTimeLabel + ' (' + tzSuffixRAW + ')</span></b></p></td></tr>'

                        if (impact != '') {
                            body += '<tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Impact:</span></p></td><td class="tdSizing2"> <p style="margi​​n-bottom:12.0pt;text-align:justify"><span class="grayText10">' + impact + '</span></p></td></tr>';
                        }

                        if (location != '') {
                            body += '<tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Location:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span class="grayText10">' + location + '</span></p></td></tr>';
                        }

                        if (reason != '') {
                            body += '<tr> <td class="tdSizing"> <p style="margin-bottom:12.0pt"><span class="grayText10">Reason:</span></p></td><td class="tdSizing2"> <p style="margin-bottom:12.0pt;text-align:justify"><span class="grayText10">' + reason + '</span></p></td></tr>';
                        }

                        body += '</table><p><span>We sincerely regret causing any inconveniences by this and hope for your understanding and the further mutually advantageous cooperation.</span></p><p><span>If you have any questions feel free to contact us at maintenance@newtelco.de.</span></p>​​</body>​​<footer>​<style>.sig{font-family: Century Gothic, sans-serif;font-size: 9pt;color: #636266 !important;}b{color: #4ca702;}.gray{color: #636266 !important;}a{text-decoration: none;color: #636266 !important;}</style><div class="sig"><br><div>Best regards | Mit freundlichen Grüßen</div><br><div><b class="gray">Newtelco Maintenance Team</b></div><br><div>NewTelco GmbH <b>|</b> Moenchhofsstr. 24 <b>|</b> 60326 Frankfurt a.M. <b>|</b> DE <br>www.newtelco.com <b>|</b> 24/7 NOC  49 69 75 00 27 30 ​​<b>|</b> <a style="color:#" href="mailto:service@newtelco.de">service@newtelco.de</a><br><br><div><img src="https://home.newtelco.de/sig.png" alt="" height="29" width="516"></div></div>​</footer>';

                        console.log(body.length); 
                        openInNewTab2('mailto:' + data['maintenanceRecipient'] + '?from=maintenance@newtelco.de&subject=' + rescheduleHeader +'Planned Work Notification on CID: ' + data['kundenCID'] + '&cc=service@newtelco.de;maintenance@newtelco.de&body=​​​​' + body);

                        var DateTime = luxon.DateTime;
                        var now = DateTime.local().toFormat("y-MM-dd HH:mm");
                        $("#mailSentAt").val(now);
                        var clickedRow = $(this).parents('tr').index();
                        table3.cell(clickedRow, 6).data('<span id="sentIndicator" class="mdi mdi-24px mdi-check-decagram mdi-dark"></span>').draw();
                    });

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


                    // Pretty Scrollbars
                    $(".mdl-layout__content").overlayScrollbars({
                        className: "os-theme-minimal-dark",
                        overflowBehavior: {
                            x: "hidden"
                        },
                        scrollbars: {
                            visibility: "auto",
                            autoHide: "move",
                            autoHideDelay: 500
                        }
                    });
                    var mailElement = document.getElementById("emailBodyFrame");
                    if (mailElement) {
                        OverlayScrollbars(document.getElementById("mailDialog"), {
                            className: "os-theme-minimal-dark",
                            resize: "both",
                            sizeAutoCapable: true
                        });
                    }
                    OverlayScrollbars(document.getElementById("notes"), {
                        className: "os-theme-dark",
                        resize: "vertical",
                        sizeAutoCapable: true
                    });
                });

                $(window).on('load', function() {
                    setTimeout(function() {
                        $('#loading').hide()
                    }, 500);
                });

                $('#dataTable4').on('responsive-resize.dt', function(e) {
                    console.log('Table Redrawn - Draw');
                    // console.log(e);
                    // console.log(e.currentTarget.childNodes);
                    var tbody = e.currentTarget.childNodes[3];
                    // console.log(tbody.children);
                    var tbodyChild = tbody.children;
                    var rowStyle = $('<style />').appendTo('head');
                    var fullstyle = '';

                    if (typeof tbodyChild !== 'undefined') {
                        for (i = 0; i < tbody.children.length; i++) {
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

                $('#dataTable4').on('draw.dt', function(e) {
                    console.log('Table Redrawn - Draw');
                    // console.log(e);
                    // console.log(e.currentTarget.childNodes);
                    var tbody = e.currentTarget.childNodes[3];
                    // console.log(tbody.children);
                    var tbodyChild = tbody.children;
                    var rowStyle = $('<style />').appendTo('head');
                    var fullstyle = '';

                    if (typeof tbodyChild !== 'undefined') {
                        for (i = 0; i < tbody.children.length; i++) {
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

                    // if ($('span.dtr-title').text == 'Sent') {
                    //   $(this).css('margin-right','30px');
                    // }
                    // var sentTitles = document.getElementsByClassName('dtr-title');
                    // document.querySelectorAll('.dtr-title').forEach(function(e) {
                    //   console.log(e);
                    // })
                    // for(i=0; i < sentTitles.length; i++) {
                    //   console.log(sentTitles.item(i));
                    // }
                    // $('.dtr-title').each(function(e) {
                    //   console.log(e);
                    //   if($(this).text == 'Sent') {
                    //     $(this).css('margin-right','30px');
                    //   }
                    // })
                });
            </script>
        </main>

        <canvas id="canvas"></canvas>
        <!-- confetti.js -->
        <script rel="preload" as="script" type="text/javascript" src="dist/js/confetti.js"></script>
        <?php echo file_get_contents("views/footer.html"); ?>

    </div>

    <!-- Google font-->
    <link rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

    <!-- mdl-selectfield css -->
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/mdl-selectfield.min.css" onload="this.rel='stylesheet'">

    <!-- select 2 css -->
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/select2.min.css" onload="this.rel='stylesheet'">

    <!-- animate css -->
    <link type="text/css" rel="stylesheet" href="dist/css/animate.css" />

    <!-- jspanel -->
    <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/jspanel.css" onload="this.rel='stylesheet'">

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
    <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">

</body>


</html> 