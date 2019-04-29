<!DOCTYPE html>
<?php
require('authenticate_google.php');

if (isset($_POST['label']) || isset($_SESSION['label'])) {
  if (isset($_POST['label'])) {
    $labelID2 = $_POST['label'];
  } else {
    $labelID2 = $_SESSION['label'];
  }
  setcookie("label", $labelID2, strtotime('+30 days'));
}
if (isset($_POST['label_name'])) {
  $labelID5 = $_POST['label_name'];
  setcookie("label_name", $labelID5, strtotime('+30 days'));
}
if (isset($_POST['endlabel'])) {
  $labelID3 = $_POST['endlabel'];
  $_SESSION['endlabel'] = $labelID3;
  setcookie("endlabel", $labelID3, strtotime('+30 days'));
}

?>

<html>
<head>
  <title>Newtelco Maintenance | Settings</title>

  <!-- jquery -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/jquery-3.3.1.min.js"></script>

  <?php echo file_get_contents("views/meta.html"); ?>

  <!-- toastify.js -->
  <script rel="preload" as="script" src="dist/js/toastify.js"></script>

  <!-- modalEffects.js -->
  <script rel="preload" as="script" src="dist/js/modalEffects.js"></script>


  <!-- handsontable -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/handsontable.min.js"></script>

  <!-- tabulator -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/tabulator/tabulator.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/tabulator/edit.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/tabulator/filter.js"></script>
  <script rel="preload" as="script" type="text/javascript" src="dist/js/tabulator/responsive_layout.js"></script>

  <!-- material design -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/material.min.js"></script>

  <!-- pace -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/pace.js"></script>

  <!-- select2 -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/select2_4.0.6-rc1.min.js"></script>

  <!-- mdl modal -->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/mdl-jquery-modal-dialog.js"></script>

  <!--getmdl-select-->
  <script rel="preload" as="script" type="text/javascript" src="dist/js/mdl-selectfield.min.js"></script>

  <!-- OverlayScrollbars -->
  <link type="text/css" href="dist/css/OverlayScrollbars.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <link type="text/css" href="dist/css/os-theme-minimal-dark.css" rel="preload stylesheet" as="style" onload="this.rel='stylesheet'">
  <script rel="preload" as="script" type="text/javascript" src="dist/js/OverlayScrollbars.min.js"></script>

  <style>
    <?php echo file_get_contents("dist/css/style.min.css"); ?>
    <?php echo file_get_contents("dist/css/material.min.css"); ?>
  </style>
</head>
<body>
  <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
      <header class="mdl-layout__header mdl-color--light-green-nt">
        <div class="mdl-layout__header-row">
          <div class="col">
            <div class="con">
              <div class="bar arrow-top"></div>
              <div class="bar arrow-middle"></div>
              <div class="bar arrow-bottom"></div>
            </div>
          </div>
          <div class="mdl-layout-title2 hvr-grow"> 
            <a href="index.php"><img style="margin-right: 10px" src="dist/images/nt_square32_2_light2.png"/></a>
            <span class="mdl-layout-title">Maintenance</span>
          </div>
          <script>
            $(".mdl-layout-title2").click(function(){
              window.location.replace("https://"+window.location.hostname+"/index");
            });
          </script>
          <div class="mdl-layout-spacer"></div>
          <div class="menu_userdetails">
            <button id="user-profile-menu" class="mdl-button mdl-js-button mdl-userprofile-button">
              <img class="hvr-rotate menu_userphoto" src="
              <?php 
                // var_dump($token_data['email']);
                if ($token_data['email'] == 'alissitsin@newtelco.de') {
                  echo '/dist/images/icons/ali_round.png';
                } else if ($token_data['email'] == 'fwaleska@newtelco.de') {
                  echo '/dist/images/icons/fwa_round.png';
                } else if ($token_data['email'] == 'sstergiou@newtelco.de') {
                  echo '/dist/images/icons/sst_round.png';
                } else if ($token_data['email'] == 'ndomino@newtelco.de') {
                  echo '/dist/images/icons/ndo_round.png';
                }        
                // for echoing google picture directly
                // echo $token_data['picture'] 
                ?>"/>
              <span class="mdl-layout-subtitle menumail"> <?php echo $token_data['email'] ?>
                <i class="fas fa-angle-down menuangle"></i>
              </span>              
            </button>
              <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                  for="user-profile-menu">
                <a class="usermenuhref" href="calendar">
                  <li class="mdl-menu__item">
                    Calendar
                    <span class="mdi mdi-24px mdi-calendar-text mdi-dark mdi-inactive"></span>
                  </li>
                </a>
                <a class="usermenuhref" href="settings">
                  <li class="mdl-menu__item">
                    Settings
                    <span class="mdi mdi-24px mdi-settings-outline mdi-dark mdi-inactive"></span>
                  </li>
                </a>
                <li>
                  <div class="mailcHR3"></div>
                </li>
                <a class="usermenuhref" href="?logout">
                  <li class="mdl-menu__item">
                    Logout
                    <span class="mdi mdi-24px mdi-logout mdi-dark mdi-inactive"></span>
                  </li>
                </a>
              </ul>
          </div>

        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a id="emailsTab" href="#emailsTab" class="mdl-layout__tab is-active">Emails</a>
          <a id="firmenTab" href="#firmenTab" class="mdl-layout__tab">Firmen</a>
          <a id="lieferantenTab" href="#lieferantenTab" class="mdl-layout__tab">Lieferanten</a>
          <a id="kundenTab" href="#kundenTab" class="mdl-layout__tab">Kunden</a>
        </div>
      </header>
      <?php
      ob_start();
      include "views/menu.php";
      $content_menu = ob_get_clean();
      echo $content_menu;
      ?>
      <main class="mdl-layout__content">
        <section class="mdl-layout__tab-panel is-active" id="emailsTab">
          <div class="page-content">

            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--2-col mdl-cell--4-col-phone"></div>
              <div class="mdl-cell mdl-cell--8-col mdl-cell--4-col-phone">
                <!-- Square card -->
                <style>
                .demo-card-square.mdl-card {
                  width: 775px;
                  height: auto;
                  margin-left: auto;
                  margin-right: auto;
                }
                .demo-card-square > .mdl-card__title {
                  color: #fff;
                  max-height: 70px;
                  background:
                  url('') bottom right 15% no-repeat #4d4d4d;
                }
                </style>
                <div class="demo-card-square mdl-card mdl-shadow--2dp">
                  <div class="mdl-card__title mdl-card--expand">
                    <h2 class="mdl-card__title-text">Settings</h2>
                  </div>
                  <div class="mdl-card__supporting-text">
                    <div class="mdl-grid">
                      <div class="settingWrapper">
                        <div class="mdl-cell mdl-cell--10-col mdl-cell--3-col-phone" style="line-height: 60px;">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which label contains the <b>incoming maintenance</b> emails?<span style="color:red"> *</span></font>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone">
                          <button id="showdialog2" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectLabelSettings" style="margin-right:5px">
                            <i class="material-icons">mail</i>
                          </button>
                          <div class="mdl-tooltip mdl-tooltip--left" for="showdialog2">
                          Select your Incoming Label
                          </div>
                        </div>
                      </div>
                      <div class="settingWrapper">
                        <div class="mdl-cell mdl-cell--10-col mdl-cell--3-col-phone" style="line-height: 60px;">
                          <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which label should <b>completed maintenances</b> be moved to?<span style="color:red"> *</span></font>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone">
                          <button id="showdialog22" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect selectLabelSettings" style="margin-right:5px">
                            <i class="material-icons">mail</i>
                          </button>
                          <div class="mdl-tooltip mdl-tooltip--left" for="showdialog22">
                          Select your Completed Label
                          </div>
                        </div>
                      </div>
                      <div class="settingWrapper">
                      <div class="warningWrapper">
                        <div class="hoverHide">
                          <div class="innerHide">
                            <div class="innerHide1">
                              <button id="hideBasedOnWarning" type="button" style="margin:5px;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                              <span id="hideWarningIcon" class="mdi mdi-24px mdi-eye mdi-inactive"></span>
                              </button>
                              <div class="mdl-tooltip mdl-tooltip--left" for="hideBasedOnWarning">
                              Hide Warning
                              </div>
                              <span id="emailUserHelp2" class="mdi mdi-36px mdi-help-circle mdi-inactive"></span>
                                <div class="mdl-tooltip mdl-tooltip--large mdl-tooltip--left" for="emailUserHelp2">
                                  This is valid for ALL users.<br><br>
                                  This will determine much backend functionality like available labels, etc. So please do not change this back and forth.<br><br>
                                  Once one user is set, the mail IDs will be based on their account and will not be available if switched to another account.</font>
                                </div>
                            </div>
                            <div class="innerHide2">
                              <div class="mdl-cell mdl-cell--7-col mdl-cell--3-col-phone" style="margin-top:4%; display: inline-block">
                                <font class="mdl-dialog__subtitle labelSelectLabelSettings">Which account should the incoming mail be <b>based</b> on?</font>
                              </div>
                              <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-phone" style="margin-top:2%; display: inline-block">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <input class="mdl-textfield__input userEmail" type="text" placeholder="@newtelco.de" id="userEmail">
                                  <label class="mdl-textfield__label" for="userEmail">Email Address</label>
                                </div>
                              </div>
                              <div class="mdl-cell mdl-cell--1-col mdl-cell--1-col-phone" style="margin-top:5%; display: inline-block">
                                <span id="emailUserHelp" class="mdi mdi-24px mdi-help-circle mdi-dark mdi-inactive"></span>
                                <div class="mdl-tooltip mdl-tooltip--left" for="emailUserHelp">
                                  This is valid for ALL users.<br><br>
                                  This will determine much backend functionality like available labels, etc. So please do not change this back and forth.<br><br>
                                  Once one user is set, the mail IDs will be based on their account and will not be available if switched to another account.</font>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mdl-card__actions mdl-card--border">
                    <div></div>
                    <div class="mdl-layout-spacer"></div>
                    <button id="settingSave" type="button" style="float: right;margin:5px;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                      <i class="material-icons">save</i>
                    </button>
                    <div class="mdl-tooltip mdl-tooltip--left" for="settingSave">
                    Save Settings
                    </div>
                  </div>
                </div>

              </div>
              <div class="mdl-cell mdl-cell--2-col mdl-cell--4-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="firmenTab">
          <div class="page-content">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Company Details</h4><br><br>
                  <h6>Companies can then be assigned as suppliers and customers!</h6>
                  <button id="btnAddF" style="" class="settingsSearchBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                    <i class="material-icons md-36">add</i>
                  </button>
                  <div class="searchWrapper">
                    <input type="search" placeholder="Search" id="firmenSearch"/>
                  </div>
                  <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnAddF">
                    Add Company
                  </div>
                </div>
                <div class="tableWrapper1">
                  <div id="firmenTable" class="hot handsontable htRowHeaders htColumnHeaders"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="lieferantenTab">
          <div class="page-content">
            <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Lieferanten Details</h4><br><br>
                  <h6>Connection between companies and their connection ID's</h6>
                  <button id="btnAddL" class="settingsSearchBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                    <i class="material-icons">add</i>
                  </button>
                  <div class="searchWrapper">
                    <input type="search" placeholder="Search" id="lieferantenSearch"/>
                  </div>
                  <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnAddL">
                    Add Lieferant CID
                  </div>
                </div>
                <br>
                <br>

                <div class="tableWrapper2">
                  <div id="lieferantenTable" class="hot handsontable htRowHeaders htColumnHeaders"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
        <section class="mdl-layout__tab-panel" id="kundenTab">
          <div class="page-content">
            <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--10-col mdl-cell--0-col-phone">
                <div class="settingsFirmenHeader">
                  <h4 class="selectGoogleLabel">Kunden Details</h4><br><br>
                  <h6>Connection between companies and our CID's</h6>
                  <button id="btnAddK" class="settingsSearchBtn mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                    <i class="material-icons">add</i>
                  </button>
                  <div class="searchWrapper">
                    <input type="search" placeholder="Search" id="kundenSearch"/>
                  </div>
                  <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="btnAddK">
                    Add Kunden CID
                  </div>
                </div>
                <br>
                <br>
                <div class="tableWrapper3">
                  <div id="kundenTable" class="hot handsontable htRowHeaders htColumnHeaders"></div>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--1-col mdl-cell--0-col-phone"></div>
            </div>
          </div>
        </section>
      </main>
      <div id="settingsOutput" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text" style="text-align:center;width:100%"></div>
        <button type="button" style="display:none" class="mdl-snackbar__action"></button>
      </div>
      <div id="firmenUpdated" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
      </div>
      <dialog style="width: 900px;" id="dialog3" class="mdl-dialog">
        <div class="labelSelectHeader">
          <h6 class="mdl-dialog__title labelSelectLabel">Which label are your maintenance emails in?</h6>
        </div>
        <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close1 labelSelectClose">
          <i class="material-icons">close</i>
        </button>
        <div class="mdl-dialog__content">
          <p>

            <?php
            $service = new Google_Service_Gmail($clientService);

            $results = $service->users_labels->listUsersLabels($user);

            if (count($results->getLabels()) == 0) {
              print "No labels found.\n";
            } else {
              echo '<form action="settings" method="post">';
              echo '<div class="mdl-grid">';
              foreach ($results->getLabels() as $label) {
                $labelColor = $label->getColor();
                if ($labelColor['backgroundColor'] != '') {
                  echo '<div class="mdl-cell mdl-cell--3-col labelColors">' . $label->getName() . '</div>';
                } else {
                  echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . ';">' . $label->getName() . '</div>';
                }
                echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="label" value="' . $label->getId() . '"><i class="material-icons">check</i></button></div>
                  <input type="hidden" value="' . $label->getName() . '" name="label_name">';
              }
              echo '</div></form>';
            }

            ?>
            </p>
          </div>
        </dialog>

        <dialog style="width: 900px;" id="dialog32" class="mdl-dialog">
          <div class="labelSelectHeader">
            <h6 class="mdl-dialog__title labelSelectLabel">Which label should <b>completed maintenances be moved to</b>?</h6>
          </div>
          <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect close2 labelSelectClose">
            <i class="material-icons">close</i>
          </button>
          <div class="mdl-dialog__content">
            <p>

              <?php
              $service = new Google_Service_Gmail($clientService);

              $results = $service->users_labels->listUsersLabels($user);

              if (count($results->getLabels()) == 0) {
                print "No labels found.\n";
              } else {

                echo '<form action="settings" method="post">';
                echo '<div class="mdl-grid">';
                foreach ($results->getLabels() as $label) {
                  $labelColor = $label->getColor();
                  if ($labelColor['backgroundColor'] != '') {
                    echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="">' . $label->getName() . '</div>';
                  } else {
                    echo '<div class="mdl-cell mdl-cell--3-col labelColors" style="color: ' . $labelColor['textColor'] . ';">' . $label->getName() . '</div>';
                  }
                  echo '<div class="mdl-cell mdl-cell--1-col"><button type="submit" style="background-color: ' . $labelColor['backgroundColor'] . '" class="labelSelectBtn mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" name="endlabel" data-value="' . $label->getId() . '" value="' . $label->getId() . '"><i class="material-icons">check</i></button></div>';
                }
                echo '</form></div>';
              }

              ?>
              </p>
            </div>
          </dialog>

          <!-- Add Lieferanten Dialog -->

          <dialog id="sAddL_dialog" class="mdl-dialog mailDialog2" style="width: 400px !important;">
          <div class="labelSelectHeader">
            <h5 class="mdl-dialog__title labelSelectLabel" style="color: rgba(0,0,0,.5)">Add Lieferant CID</h5>
          </div>
          <div class="mdl-grid grayBorder1">
            <div class="mdl-cell mdl-cell--12-col">

                <script>
                $('#sAddL_dialog').ready(function(){
                  $('.sAddL_cid').select2({
                    dropdownParent: $("#sAddL_dialog")
                  });
                });
              </script>     

              <div class="sAddK">
              <label class="mdl-selectfield--floating-label" style="color:#67B246">Company</label>
                <select id="sAddL_cid" name="sAddL_cid" class="sAddL_cid" style="width:60% !important;">
                  <option value=""></option>
                  <?php
                    $sAddLQ =  mysqli_query($dbhandle, "SELECT companies.id, companies.name FROM companies;") or die(mysqli_error($sAddLQ));
                    while ($row = mysqli_fetch_row($sAddLQ)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                  ?>
                </select>
                <span class="mdl-selectfield__error">Select a Company</span>
              </div>


              <div class="mAddSubtitle">Company must already exist.</div>
            </div>
            <div class="mdl-cell mdl-cell--12-col">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"  style="width: 90% !important;" type="text" value="" id="sAddL_cid2">
                <label class="mdl-textfield__label" for="sAddL_cid2">Their CID</label>
              </div>
              <div class="mAddSubtitle">Please only add one Lieferanten CID here<br> For multiple Lieferanten CIDs, run this wizard again</div>
            </div>
            <button tabindex="-1" type="button" style="position: absolute; right: 90px; bottom: 20px; color: rgba(0,0,0,.54)" class="mdl-button mdl-js-button  mdl-js-ripple-effect mdl-button--colored close1">
              <!-- <i class="material-icons">close</i> -->
              Cancel
            </button>

            <button tabindex="-1" id="sAddL_save" type="button" style="position: absolute; right: 20px; bottom: 20px;" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored">
              <!-- <i class="material-icons">save</i> -->
              Save
            </button>
          </div>
          </dialog>

          <!-- Add Kunden Dialog -->

          <dialog id="sAddK_dialog" class="mdl-dialog mailDialog2" style="width: 400px !important;">
          <div class="labelSelectHeader">
            <h5 class="mdl-dialog__title labelSelectLabel" style="color: rgba(0,0,0,.5)">Add Kunden/Newtelco CID</h5>
          </div>
          <div class="mdl-grid grayBorder1">
            <div class="mdl-cell mdl-cell--12-col">

              <script>
                $('#sAddK_dialog').ready(function(){
                  $('.sAddK_cid1').select2({
                    dropdownParent: $("#sAddK_dialog")
                  });
                });
              </script>     

              <div class="sAddK">
              <label class="mdl-selectfield--floating-label" style="color:#67B246">Their CID</label>
                <select id="sAddK_cid1" name="sAddK_cid1" class="sAddK_cid1" style="width:60% !important;">
                  <option value=""></option>
                  <?php
                    $sAddKQ =  mysqli_query($dbhandle, "SELECT lieferantCID.id, lieferantCID.derenCID FROM lieferantCID;") or die(mysqli_error($sAddKQ));
                    while ($row = mysqli_fetch_row($sAddKQ)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                  ?>
                </select>
                <span class="mdl-selectfield__error">Please select the Lieferant CID this Newtelco CID belongs to.</span>
              </div>
            </div>
            <div class="mdl-cell mdl-cell--12-col">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"  style="width: 90% !important;" type="text" value="" id="sAddK_cid2">
                <label class="mdl-textfield__label" for="sAddK_cid2">Newtelco CID</label>
              </div>
              <!-- <div class="mAddSubtitle">Please enter the Newtelco CID.</div> -->
            </div>
            <div class="mdl-cell mdl-cell--12-col">

              
              <label class="mdl-selectfield--floating-label" style="color:#67B246">Protection</label><br>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="prot1">
                <input type="radio" id="prot1" class="mdl-radio__button" value="1" name="protection" />
                <span class="mdl-radio__label">Protected</span>
              </label>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="prot0">
                <input type="radio" id="prot0" class="mdl-radio__button" value="0" name="protection" />
                <span class="mdl-radio__label">Unprotected</span>
              </label>

            </div>
            <div class="mdl-cell mdl-cell--12-col">

              <script>
                $('#sAddK_dialog').ready(function(){
                  $('.sAddK_cid').select2({
                    dropdownParent: $("#sAddK_dialog")
                  });
                });
              </script>     

              <div class="sAddK">
              <label class="mdl-selectfield--floating-label" style="color:#67B246">Company</label>
                <select id="sAddK_cid" name="sAddK_cid" class="sAddK_cid" style="width:60% !important;">
                  <option value=""></option>
                  <?php
                    $sAddLQ =  mysqli_query($dbhandle, "SELECT companies.id, companies.name FROM companies;") or die(mysqli_error($sAddLQ));
                    while ($row = mysqli_fetch_row($sAddLQ)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                  ?>
                </select>
                <span class="mdl-selectfield__error">Please select the Company belonging to this Newtelco CID</span>
              </div>

              <div class="mAddSubtitle">Company must already exist.</div>
            </div>

            <button tabindex="-1" type="button" style="position: absolute; right: 90px; bottom: 20px; color: rgba(0,0,0,.54)" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored close3">
              <!-- <i class="material-icons">close</i> -->
              Cancel
            </button>

            <button tabindex="-1" id="sAddK_save" type="button" style="position: absolute; right: 20px; bottom: 20px;" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored">
              <!-- <i class="material-icons">save</i> -->
              Save
            </button>
          </div>
          </dialog>

          <!-- Settings Snackbar Wrapper -->

          <div id="addResults1" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
          </div>
        <script>
          $(document).on('ready', function() {
            $('__lpform_userEmail_numspan').css('display','none');
          })

          $('#hideBasedOnWarning').on('click', function(e) {
            $('.innerHide1').hide(500);
          });


          /*
           *
           * Add Firmen
           * 
           */
          
            $("#btnAddF").click(function(){
              showDialog({
                title: 'Add New Company',
                text: '<div class="addFirmenWrapper"><div class="mdl-grid"><div class="mdl-cell mdl-cell--12-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" style="width: 100% !important;" type="text" value="" id="cName"> <label class="mdl-textfield__label" for="rmail">Company Name</label></div><div class="mAddSubtitle"></div></div><div class="mdl-cell mdl-cell--12-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" style="width: 100% !important;" type="text" value="" id="cDomain"> <label class="mdl-textfield__label" for="rmail">Mail Domain</label></div><div class="mAddSubtitle">Email Address Domain (i.e. "newtelco.de")</div></div><div class="mdl-cell mdl-cell--12-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input class="mdl-textfield__input" style="width: 100% !important;" type="text" value="" id="cRecipient"> <label class="mdl-textfield__label" for="rmail">Maintenance Recipient(s)</label></div><div class="mAddSubtitle">Multiple recipients should be separated with semicolons ";"</div></div></div></div>',
                negative: {
                    title: 'Cancel'
                },
                positive: {
                    title: 'Add',
                    onClick: function(e) {
                      console.log(e);
                      var cName = $('#cName').val().trim();
                      var cDomain = $('#cDomain').val();
                      var cRecipient = $('#cRecipient').val();
                      $.ajax({
                        url: 'api?sAddF=1&sAddF_n='+cName+'&sAddF_d='+cDomain+'&sAddF_r='+cRecipient,
                        success: function (data) {
                          if (data.added === 1){
                            const cAddedToast = showToaster("Company Added");
                            cAddedToast.showToast();
                            // var snackbarContainer = document.querySelector('#addResults1');
                            // var sbData = {
                            //   message: 'Company Added',
                            //   timeout: 2000
                            // };
                            // snackbarContainer.MaterialSnackbar.showSnackbar(sbData);
                            setTimeout(function() {
                              window.location.reload(); 
                              // window.location.href = 'https://maintenance.newtelco.de/settings#firmenTab';
                            },1000);
                          } 
                        },
                        error: function (err) {
                          console.log('Error', err);
                        }
                      });
                    }
                },
                cancelable: false
                }); 
            }); 


            /*
           *
           * Add Lieferanten
           * 
           */

          $('#sAddL_save').on('click', function() {
            var lAdd_company = $('#sAddL_cid').val();
            var lAdd_dCID = $('#sAddL_cid2').val();
            $.ajax({
              url: 'api?sAddL=1&sAddL_c='+lAdd_company+'&sAddL_i='+lAdd_dCID,
              success: function (data) {
                if (data.added === 1){
                  const lCIDAdded = showToaster("Lieferant CID Added");
                  lCIDAdded.showToast();
                  // var snackbarContainer = document.querySelector('#addResults1');
                  // var sbData = {
                  //   message: 'Lieferant CID Added',
                  //   timeout: 2000
                  // };
                  $('.close1').click();
                  // snackbarContainer.MaterialSnackbar.showSnackbar(sbData);
                  setTimeout(function() {
                    window.location.reload(); 
                  },1000);
                } 
              },
              error: function (err) {
                console.log('Error', err);
              }
            });
          });

          /*
           *
           * Add Kunden
           * 
           */

          $('#sAddK_save').on('click', function() {
            var kAdd_company = $('#sAddK_cid').val();
            var kAdd_dCID = $('#sAddK_cid1').val();
            var kAdd_ntCID = $('#sAddK_cid2').val();

            if ($('#prot0').is(':checked') == true) {
              var kAdd_p = '0';
            } else if ($('#prot1').is(':checked') == true) {
              var kAdd_p = '1';
            }
            
            $.ajax({
              url: 'api?sAddK=1&sAddK_c='+kAdd_company+'&sAddK_dc='+kAdd_dCID+'&sAddK_nt='+kAdd_ntCID+'&sAddK_p='+kAdd_p,
              success: function (data) {
                if (data.added === 1){
                  const kCIDAdded = showToaster("Newtelco / Kunden CID Added");
                  kCIDAdded.showToast();
                  // var snackbarContainer = document.querySelector('#addResults1');
                  // var sbData = {
                  //   message: 'Newtelco/Kunden CID Added',
                  //   timeout: 2000
                  // };
                  $('.close3').click();
                  // snackbarContainer.MaterialSnackbar.showSnackbar(sbData);
                  setTimeout(function() {
                    window.location.reload(); 
                  },1000);
                } 
              },
              error: function (err) {
                console.log('Error', err);
              }
            });
          });

          /*
           * 
           * Save Firmen
           * 
           */

          $('#settingSave').on('click', function(e) {
            var selectedUser = $('#userEmail').val();
            $.ajax({
              type: "GET",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              'url':'api?userMails=' + selectedUser,
              'success': function(result2){
                var obj = JSON.stringify(result2);
                // var snackbarContainer = document.querySelector('#settingsOutput');

                if (result2.updated === 1) {
                  const sSaved = showToaster("Successfully Saved");
                  sSaved.showToast();
                  // var settingsOutput = {
                  //   message: 'Successfully Saved',
                  //   timeout: 4000
                  // };
                } else if (result2.same === 1) {
                  const uSelected = showToaster("User Already Selected");
                  uSelected.showToast();
                  // var settingsOutput = {
                  //   message: 'User already selected',
                  //   timeout: 4000
                  // };
                } else if (result2.empty === 1) {
                  const fullMail = showToaster("Please enter Email Address");
                  fullMail.showToast();
                  // var settingsOutput = {
                  //   message: 'Please enter Email Address',
                  //   timeout: 4000
                  // };
                }
                // snackbarContainer.MaterialSnackbar.showSnackbar(settingsOutput);
              }
            });
          });

          var dialog = document.querySelector('#dialog3');
          var showDialogButton = document.querySelector('#showdialog2');
          if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
          }
          showDialogButton.addEventListener('click', function() {
            dialog.showModal();
          });
          dialog.querySelector('.close1').addEventListener('click', function() {
            dialog.close();
          });

          var dialog2 = document.querySelector('#dialog32');
          var showDialogButton2 = document.querySelector('#showdialog22');
          if (! dialog2.showModal) {
            dialogPolyfill.registerDialog(dialog2);
          }
          showDialogButton2.addEventListener('click', function() {
            dialog2.showModal();
          });
          dialog2.querySelector('.close2').addEventListener('click', function() {
            dialog2.close();
          });


          var dialog3 = document.querySelector('#sAddL_dialog');
          var showDialogButton3 = document.querySelector('#btnAddL');
          if (! dialog3.showModal) {
            dialogPolyfill.registerDialog(dialog3);
          }
          showDialogButton3.addEventListener('click', function() {
            dialog3.showModal();
          });
          dialog3.querySelector('.close1').addEventListener('click', function() {
            dialog3.close();
          });
        

          var dialog4 = document.querySelector('#sAddK_dialog');
          var showDialogButton4 = document.querySelector('#btnAddK');
          if (! dialog4.showModal) {
            dialogPolyfill.registerDialog(dialog3);
          }
          showDialogButton4.addEventListener('click', function() {
            dialog4.showModal();
          });
          dialog4.querySelector('.close3').addEventListener('click', function() {
            dialog4.close();
          });

          function matchAny(data, filterParams){
              //data - the data for the row being filtered
              //filterParams - params object passed to the filter

              var match = false;

              for(var key in data){
                  if(data[key] == filterParams.value){
                      match = true;
                  }
              }

              return match;
          }

          Tabulator.prototype.extendModule("filter", "filters", {
              "===":function(headerValue, rowValue, rowData, filterParams){
                  //headerValue - the value of the header filter element
                  //rowValue - the value of the column in this row
                  //rowData - the data for the row being filtered
                  //filterParams - params object passed to the headerFilterFuncParams property

                  return rowVal === headerValue ? true : false;
              }
          });

          Tabulator.prototype.extendModule("format", "formatters", {
              protected:function(cell, formatterParams){
                if (cell.getValue() == 0) {
                  return 'Unprotected';
                } else {
                  return 'Protected';
                }
                  // return "<img class='fileicon' src='/images/fileicons/" + cell.getValue() + ".png'></img>";
              },
          });
          var protectedMutator = function(value, data, type, params, component){
            //value - original value of the cell
            //data - the data for the row
            //type - the type of mutation occurring  (data|edit)
            //params - the mutatorParams object from the column definition
            //component - when the "type" argument is "edit", this contains the cell component for the edited cell, otherwise it is the column component for the column
            if (value == 0) {
              return "Unprotected";
            } else if (value == 1) {
              return "Protected";
            } else {
              return "N/A";
            }
          }

          var protectedAccessor = function(value, data, type, params, component){
            //value - original value of the cell
            //data - the data for the row
            //type - the type of mutation occurring  (data|edit)
            //params - the mutatorParams object from the column definition
            //component - when the "type" argument is "edit", this contains the cell component for the edited cell, otherwise it is the column component for the column
            if (value == 'Unprotected') {
              return "0";
            } else if (value == 'Protected') {
              return "1";
            } else {
              return "N/A";
            }
          }

         $('#firmenTab').click(function(){

         /*****************
          *
          *  FIRMEN Table
          * 
          ******************/

          if ($('#firmenTable').html() == '') {

            var firmenTable = '';
            var firmenData = $.ajax({
              type: "GET",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
              'url':'api?firmen=1',
              'success': function (data) {
                var firmenTable = new Tabulator("#firmenTable", {
                  data:data,           //load row data from array
                  layout:"fitColumns",      //fit columns to width of table
                  responsiveLayout:"hide",  //hide columns that dont fit on the table
                  tooltips:true,            //show tool tips on cells
                  addRowPos:"top",          //when adding a new row, add it to the top of the table
                  history:true,             //allow undo and redo actions on the table
                  resizableRows:true,       //allow row order to be changed
                  selectable: true,         //allow selection - i.e. for deletion
                  initialSort:[             //set the initial sort order of the data
                    {column:"name", dir:"asc"},
                  ],
                  columns:[                 //define the table columns
                    {title:"ID", field:"id", width:50, editor:false},
                    {title:"name", field:"name", width:195, editor:"input"},
                    {title:"mailDomain", field:"mailDomain", width:250, editor:"input"},
                    {title:"maintenanceRecipient", field:"maintenanceRecipient", editor:"input"}
                  ],
                  cellEdited:function(cell) {
                    $.ajax({
                      url: "api.php?updateFirmen",
                      data: cell.getRow().getData(),
                      type: "get",
                      success: function(response, textstatus, xhr) {
                        const firmenUpdated = showToaster("Firmen Updated");
                        firmenUpdated.showToast();
                      },
                      error: function(XMLHttpRequest, textstatus, error) {
                        const firmenError = showToaster("Firmen Error - " + textstatus + ' - ' + error);
                        firmenError.showToast();
                      }
                    })
                  }
                });

                $('#firmenSearch').on('change', function(data) {
                  var firmenSearchQuery = $('#firmenSearch').val();
                  // $('#firmenTable').tabulator("setFilter",matchAny,{value:firmenSearchQuery});
                  // console.log(data);
                  // console.log(firmenSearchQuery);
                  firmenTable.setFilter([[
                    {field:"name",type:"like",value:firmenSearchQuery},
                    {field:"mailDomain",type:"like",value:firmenSearchQuery},
                    {field:"maintenanceRecipient",type:"like",value:firmenSearchQuery},
                  ]]);
                })

                key('alt+shift+l', function(){ 
                  // var firmenTable = $("#firmenTable").tabulator({});
                  // console.log(firmenTable);
                  var selectedRows = firmenTable.getSelectedRows();
                  var selectedRowNames = '';
                  var selectedRowIDs = [];
                  for(i = 0; i < selectedRows.length; i++) {
                    selectedRowNames += selectedRows[i]._row.data.name + ", ";
                    selectedRowIDs.push(selectedRows[i]._row.data.id);
                  }
                  console.log(selectedRowIDs);
                  selectedRowNames = selectedRowNames.substring(0, selectedRowNames.length -2);
                  showDialog({
                    title: 'Delete Companies',
                    text: '<p>Do you really wish to delete the selected companies: <br><br><b>' + selectedRowNames + '</b><br><br> There is <b>no</b> reversing this decision.</p>',
                    negative: {
                      title: 'Cancel',
                    },
                    positive: {
                      title: 'Delete',
                      onClick: function() {
                        $.ajax({
                          'url':'api?firmenRowDelete',
                          'type': 'post',
                          'datatype': 'json',
                          'data': 'selectedRows=' + JSON.stringify(selectedRowIDs),
                          'success': function(data) {
                            console.log(data);
                            var delRows = [];
                            for(i = 0; i < selectedRows.length; i++) {
                              firmenTable.deleteRow(selectedRows[i]._row).then(function(){
                                const rowDeletedToast = showToaster("Row Deleted");
                                rowDeletedToast.showToast();
                              });
                            }
                          }
                        })
                      }
                    }
                  })
                })
              },
              'error': function () {
                console.log("Loading error");
              }
            });
          };
         });


        $('#lieferantenTab').click(function(){

        /*****************
        *
        *  LIEFERANT Table
        *
        ******************/

        if ($('#lieferantenTable').html() == '') {
          
          var lieferantTableData = $.ajax({
            type: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            'url':'api?lieferanten=1',
            'success': function (data) { 
              var lieferantTable = new Tabulator("#lieferantenTable", {
                data:data,           //load row data from array
                layout:"fitColumns",      //fit columns to width of table
                responsiveLayout:"hide",  //hide columns that dont fit on the table
                tooltips:true,            //show tool tips on cells
                addRowPos:"top",          //when adding a new row, add it to the top of the table
                history:true,             //allow undo and redo actions on the table
                selectable:true,
                resizableRows:true,       //allow row order to be changed
                // initialSort:[             //set the initial sort order of the data
                //   {column:"name", dir:"desc"}
                // ],
                columns:[                 //define the table columns
                  {title:"ID", field:"id", width:90, editor:false},
                  {title:"Name", field:"name", width:295, editor:"select", editorParams:{
                    values:true,
                    sortValuesList:"asc"
                  }},
                  {title:"Deren CID", field:"derenCID", editor:"input"}
                ],
                cellEdited:function(cell) {
                  $.ajax({
                    url: "api.php?updateLieferanten",
                    data: cell.getRow().getData(),
                    type: "get",
                    success: function(response, textstatus, xhr) {
                      const liefUpdated = showToaster("Lieferant Updated");
                      liefUpdated.showToast();
                      // var snackbarContainer3 = document.querySelector('#firmenUpdated');
                      // var dataFirmenUpdated2 = {
                      //   message: 'Lieferanten Updated',
                      //   timeout: 2000
                      // };
                      // snackbarContainer3.MaterialSnackbar.showSnackbar(dataFirmenUpdated2);
                    },
                    error: function(XMLHttpRequest, textstatus, error) {
                      const liefError = showToaster("Lieferant Error - " + textstatus + " - " + error);
                      liefError.showToast();
                      // alert("AJAX error: " + textstatus + "; " + error);
                    }
                  })
                }
              });
              $('#lieferantenSearch').on('change', function(data) {
                var lieferantenSearchQuery = $('#lieferantenSearch').val();
                // $('#firmenTable').tabulator("setFilter",matchAny,{value:firmenSearchQuery});
                // console.log(data);
                // console.log(firmenSearchQuery);
                lieferantTable.setFilter([[
                  {field:"name",type:"like",value:lieferantenSearchQuery},
                  {field:"derenCID",type:"like",value:lieferantenSearchQuery},
                ]]);
              })
              key('alt+shift+l', function(){ 
                // var firmenTable = $("#firmenTable").tabulator({});
                // console.log(firmenTable);
                var selectedRows = lieferantTable.getSelectedRows();
                var selectedRowNames = '';
                var selectedRowIDs = [];
                for(i = 0; i < selectedRows.length; i++) {
                  selectedRowNames += selectedRows[i]._row.data.derenCID + ", ";
                  selectedRowIDs.push(selectedRows[i]._row.data.id);
                }
                console.log(selectedRowIDs);
                selectedRowNames = selectedRowNames.substring(0, selectedRowNames.length -2);
                showDialog({
                  title: 'Delete Lieferanten CIDs',
                  text: '<p>Do you really wish to delete the selected lieferanten CIDs: <br><br><b>' + selectedRowNames + '</b><br><br> There is <b>no</b> reversing this decision.</p>',
                  negative: {
                    title: 'Cancel',
                  },
                  positive: {
                    title: 'Delete',
                    onClick: function() {
                      $.ajax({
                        'url':'api?lieferantenRowDelete',
                        'type': 'post',
                        'datatype': 'json',
                        'data': 'selectedRows=' + JSON.stringify(selectedRowIDs),
                        'success': function(data) {
                          console.log(data);
                          var delRows = [];
                          for(i = 0; i < selectedRows.length; i++) {
                            lieferantTable.deleteRow(selectedRows[i]._row).then(function(){
                              const rowDeletedToast = showToaster("Row Deleted");
                              rowDeletedToast.showToast();
                            });
                          }
                        }
                      })
                    }
                  }
                })
              })
            },
            'error': function () {
              console.log("Loading error");
            }
          });
          
        } else {
          var lieferantTable = $('#lieferantenTable');
          lieferantTable.clearData();
          lieferantTable.getData();
        }

        });

        $('#kundenTab').click(function(){

        /*****************
         *
         *  KUNDEN Table
         *
         ******************/

        if ($('#kundenTable').html() == '') {
         
         
         
          var kundenTableData = $.ajax({
            type: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            'url':'api?kunden=1',
            'success': function (data) { 
              var kundenTable = new Tabulator("#kundenTable", {
                data:data,           //load row data from array
                layout:"fitColumns",      //fit columns to width of table
                responsiveLayout:"hide",  //hide columns that dont fit on the table
                tooltips:true,            //show tool tips on cells
                addRowPos:"top",          //when adding a new row, add it to the top of the table
                history:true,             //allow undo and redo actions on the table
                resizableRows:true,       //allow row order to be changed
                selectable: true,
                layoutColumnsOnNewData: true,
                initialSort:[             //set the initial sort order of the data
                  {column:"derenCID", dir: "desc"},
                  {column:"name", dir:"asc"},
                ],
                columns:[                 //define the table columns
                  {title:"ID", field:"id", width:90, editor:false},
                  {title:"Lieferant CID", field:"derenCID", width:170, editor: false},
                  {title:"Newtelco CID", field:"kundenCID", editor:"input"},
                  {title:"Protection", field:"protected", width:150, editor:"select", mutator:protectedMutator, accessor:protectedAccessor, editorParams:{
                    values:{ "0":"Unprotected","1":"Protected" },
                  }},
                  {title:"Kunde", field:"name", width:170, editor:"select", editorParams: {
                    values:true,
                    sortValuesList:"asc"
                  }},
                ],
                cellEdited:function(cell) {
                  $.ajax({
                    url: "api.php?updateKunden",
                    data: cell.getRow().getData(),
                    type: "get",
                    success: function(response, textstatus, xhr) {
                      const kundenUpdated = showToaster("Kunden Updated");
                      kundenUpdated.showToast();
                      // var snackbarContainer3 = document.querySelector('#firmenUpdated');
                      // var dataFirmenUpdated2 = {
                      //   message: 'Kunden Updated',
                      //   timeout: 2000
                      // };
                      // snackbarContainer3.MaterialSnackbar.showSnackbar(dataFirmenUpdated2);
                    },
                    error: function(XMLHttpRequest, textstatus, error) {
                      const kundenError = showToaster("Lieferant Error - " + textstatus + " - " + error);
                      kundenError.showToast();
                      // alert("AJAX error: " + textstatus + "; " + error);
                    }
                  })
                }
              });
              $('#kundenSearch').on('change', function(data) {
                var kundenSearchQuery = $('#kundenSearch').val();
                // $('#firmenTable').tabulator("setFilter",matchAny,{value:firmenSearchQuery});
                // console.log(data);
                // console.log(firmenSearchQuery);
                  kundenTable.setFilter([[
                    {field:"name",type:"like",value:kundenSearchQuery},
                    {field:"derenCID",type:"like",value:kundenSearchQuery},
                    {field:"kundenCID",type:"like",value:kundenSearchQuery},
                  ]]);
              })
              key('alt+shift+l', function(){ 
                // var firmenTable = $("#firmenTable").tabulator({});
                // console.log(firmenTable);
                var selectedRows = kundenTable.getSelectedRows();
                var selectedRowNames = '';
                var selectedRowIDs = [];
                console.log(selectedRows);
                for(i = 0; i < selectedRows.length; i++) {
                  selectedRowNames += selectedRows[i]._row.data.kundenCID + " (" + selectedRows[i]._row.data.name + ")<br>";
                  selectedRowIDs.push(selectedRows[i]._row.data.id);
                }
                console.log(selectedRowIDs);
                selectedRowNames = selectedRowNames.substring(0, selectedRowNames.length -4);
                showDialog({
                  title: 'Delete Kunden CIDs',
                  text: '<p>Do you really wish to delete the selected kunden CIDs: <br><br><b>' + selectedRowNames + '</b><br><br> There is <b>no</b> reversing this decision.</p>',
                  negative: {
                    title: 'Cancel',
                  },
                  positive: {
                    title: 'Delete',
                    onClick: function() {
                      $.ajax({
                        'url':'api?kundenRowDelete',
                        'type': 'post',
                        'datatype': 'json',
                        'data': 'selectedRows=' + JSON.stringify(selectedRowIDs),
                        'success': function(data) {
                          console.log(data);
                          var delRows = [];
                          for(i = 0; i < selectedRows.length; i++) {
                            kundenTable.deleteRow(selectedRows[i]._row).then(function(){
                              const rowDeletedToast = showToaster("Row Deleted");
                              rowDeletedToast.showToast();
                            });
                          }
                        }
                      })
                    }
                  }
                })
              })
            },
            'error': function () {
              console.log("Loading error");
            }
          });

        }

        });


          document.addEventListener("DOMContentLoaded", function() {
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
          });
        </script>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>

      <?php  
          mysqli_close($dbhandle); 
      ?>

      <!-- mdl modal -->
      <link prefetch rel="preload stylesheet" as="style" href="dist/css/mdl-jquery-modal-dialog.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- Google font-->
      <link prefetch rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

      <!-- material icons -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css" onload="this.rel='stylesheet'">
      <link rel="preload stylesheet" as="style" href="dist/css/materialdesignicons.min.css" onload="this.rel='stylesheet'">

      <!-- font awesome -->
      <link rel="preload stylesheet" as="style" href="dist/fonts/fontawesome5.5.0.min.css" onload="this.rel='stylesheet'">

      <!-- mdl-selectfield css -->
      <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/mdl-selectfield.min.css" onload="this.rel='stylesheet'">

      <!-- hover css -->
      <link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

      <!-- handsontable -->
     <link href="dist/css/handsontable.full.min.css" rel="preload stylesheet" as="style" media="screen" onload="this.rel='stylesheet'">

      <!-- tabulator -->
     <link href="dist/css/tabulator_bootstrap4.min.css" rel="preload stylesheet" as="style" media="screen" onload="this.rel='stylesheet'">

      <!-- toastify css -->
      <link type="text/css" rel="stylesheet" href="dist/css/toastify.css" />

      <!-- select 2 css -->
      <link rel="preload stylesheet" as="style" type="text/css" href="dist/css/select2.min.css" onload="this.rel='stylesheet'">
</body>
</html>
