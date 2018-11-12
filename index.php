<!DOCTYPE html>
<?php
require('authenticate_google.php');

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
  <link rel="manifest" href="manifest.json"></link>
  <meta name="application-name" content="Newtelco Maintenance">
  <title>Newtelco Maintenance | Welcome</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel='stylesheet' href='assets/css/style.css'>

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
            <img class="menu_userphoto" src="<?php echo $token_data['picture'] ?>"/>
          </div>
              
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Maintenance</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php"><i class="fas fa-home"></i>  Home</a>
          <a class="mdl-navigation__link" href="overview.php"><i class="fas fa-book-open"></i>  Overview</a>
          <a class="mdl-navigation__link" href="incoming.php"><i class="fas fa-folder-plus"></i>  Incoming</a>
          <a class="mdl-navigation__link" target="_blank" href="https://crm.newtelco.de"><i class="fas fa-users"></i>  CRM</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link menu_logout" href="?logout">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Logout</button>
          </a>
        </nav>

      </div>
        <main class="mdl-layout__content">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
              <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone">
                <!-- Wide card with share menu button -->
                  <style>
                  .demo-card-wide.mdl-card {
                    width: 562px;
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
                      <h2 class="mdl-card__title-text">Welcome <?php echo $token_data['name'] ?></h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Mauris sagittis pellentesque lacus eleifend lacinia...<br><br>
                      <b>Debug:</b>
                      <pre><?php 
                      var_export($token_data);
                      ?></pre>
                      
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <a href="overview.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Overview
                      </a>
                      <a href="incoming.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--light-green-nt">
                        Incoming
                      </a>
                    </div>
                  </div>
              </div>
              <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
            </div>
        </main>
        <footer class="mdl-mini-footer">
            <div class="mdl-mini-footer__left-section">
              <span class="mdl-logo">Newtelco GmbH</span>
              <ul class="mdl-mini-footer__link-list">
                <li><a href="#">Help</a></li>
                <li><a href="#">Privacy & Terms</a></li>
              </ul>
            </div>
            <div class="mdl-mini-footer__right-section">
              <div>
                built with <span class="love">&hearts;</span> by <a target="_blank" class="footera" href="https://github.com/ndom91">ndom91</a> &copy;
              </div>
            </div>
        </footer>
      </div>
</body>
</html>

