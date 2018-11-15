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

  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">
  <script src="assets/js/material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                    if (isset($_GET['mid'])) {

                      $activeID = $_GET['mid'];

                      // DEBUG
                      //echo '<b>Debug:</b><br>';
                      //echo '<pre>';
                      //echo $tdCID . '<br>';
                      //echo "activeID: " . $activeID . "<br>";
                      // END DEBUG

                      $mID_escape = mysqli_real_escape_string($dbhandle, $activeID);
                      $mID_query = mysqli_query($dbhandle, "SELECT * FROM `maintenancedb` WHERE `id` LIKE $mID_escape");
                      $mIDresult = mysqli_fetch_array($mID_query);
                      
                      // DEBUG
                      //echo "mIDresult: " . $mIDresult['bearbeitetvon'] . "<br>";
                      //$dCIDresult = mysqli_fetch_array($dCID_query);
                      //echo 'Query Result:' . $dCIDresult[0]. '<br>';
                      // END DEBUG

                  ?>
                  
                  <!-- EDIT MODE -->

                  <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
                  <div class="mdl-cell mdl-cell--5-col mdl-cell--4-col-phone">
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
                      <h2 class="mdl-card__title-text"><?php if (isset($_GET['mid'])) { echo "Edit"; } else { echo "Add"; } ?> Maintenance Entry</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                      <form action="#">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['maileingang'] ?>" id="medt">
                          <label class="mdl-textfield__label" for="medt">Maileingang Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['receivedmail'] ?>" id="rmail">
                          <label class="mdl-textfield__label" for="rmail">R Mail</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['lieferant'] ?>" id="company">
                          <label class="mdl-textfield__label" for="company">Company Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['derenCIDid'] ?>" id="dcid">
                          <label class="mdl-textfield__label" for="dcid">Deren CID</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['bearbeitetvon'] ?>" id="bearbeitet">
                          <label class="mdl-textfield__label" for="bearbeitet">Bearbeitet Von</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['maintenancedate'] ?>" id="mdt">
                          <label class="mdl-textfield__label" for="mdt">Maintenance Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['startDateTime'] ?>" id="sdt">
                          <label class="mdl-textfield__label" for="sdt">Start Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['endDateTime'] ?>" id="edt">
                          <label class="mdl-textfield__label" for="edt">End Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['postponed'] ?>" id="pponed">
                          <label class="mdl-textfield__label" for="pponed">Postponed</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['notes'] ?>" id="notes">
                          <label class="mdl-textfield__label" for="notes">Notes</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['mailankunde'] ?>" id="makdt">
                          <label class="mdl-textfield__label" for="makdt">Mail an Kunde Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['mailsend'] ?>" id="smail">
                          <label class="mdl-textfield__label" for="smail">S Mail</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['cal'] ?>" id="cal">
                          <label class="mdl-textfield__label" for="cal">Add to Cal</label>
                        </div>
                              </form>
                              </div>
                              <div class="mdl-card__actions mdl-card--border">
                                <a href="overview.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                                  Save
                                </a>
                                <!-- <a href="incoming.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                                  Back
                                </a> -->
                              </div>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
                      </div>

                        <?php
                      } else {
                        $mIDresult = [
                            "foo" => "bar",
                            "bar" => "foo",
                        ];
                      ?>

                  <!-- ADD MODE -->

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
                    <div class="mdl-cell mdl-cell--5-col mdl-cell--4-col-phone">
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
                      <h2 class="mdl-card__title-text"><?php if (isset($_GET['mid'])) { echo "Edit"; } else { echo "Add"; } ?> Maintenance Entry</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                      <form action="#">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['maileingang'] ?>" id="medt">
                          <label class="mdl-textfield__label" for="medt">Maileingang Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['receivedmail'] ?>" id="rmail">
                          <label class="mdl-textfield__label" for="rmail">R Mail</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['lieferant'] ?>" id="company">
                          <label class="mdl-textfield__label" for="company">Company Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['derenCIDid'] ?>" id="dcid">
                          <label class="mdl-textfield__label" for="dcid">Deren CID</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['bearbeitetvon'] ?>" id="bearbeitet">
                          <label class="mdl-textfield__label" for="bearbeitet">Bearbeitet Von</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['maintenancedate'] ?>" id="mdt">
                          <label class="mdl-textfield__label" for="mdt">Maintenance Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['startDateTime'] ?>" id="sdt">
                          <label class="mdl-textfield__label" for="sdt">Start Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['endDateTime'] ?>" id="edt">
                          <label class="mdl-textfield__label" for="edt">End Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['postponed'] ?>" id="pponed">
                          <label class="mdl-textfield__label" for="pponed">Postponed</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['notes'] ?>" id="notes">
                          <label class="mdl-textfield__label" for="notes">Notes</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['mailankunde'] ?>" id="makdt">
                          <label class="mdl-textfield__label" for="makdt">Mail an Kunde Date/Time</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['mailsend'] ?>" id="smail">
                          <label class="mdl-textfield__label" for="smail">S Mail</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                          <input class="mdl-textfield__input" type="text" value="<?php echo $mIDresult['cal'] ?>" id="cal">
                          <label class="mdl-textfield__label" for="cal">Add to Cal</label>
                        </div>

                                </form>
                              </div>
                              <div class="mdl-card__actions mdl-card--border">
                                <a href="overview.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                                  Save
                                </a>
                                <a onclick="window.history.back()" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                                  Back
                                </a>
                              </div>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
                      </div>
                        <?php
                      } 
                      ?>
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

