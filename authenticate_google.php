<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

include_once "base.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=maintenanceapp-1dd9507b2c22.json');

$user = 'ndomino@newtelco.de';

function getGoogleClient() {
    return getServiceAccountClient();
}

function getServiceAccountClient() {
  $user = 'ndomino@newtelco.de';
    try {
        // Create and configure a new client object.
        $client2 = new Google_Client();
        $client2->useApplicationDefaultCredentials();
        $client2->setScopes(['https://mail.google.com/','https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.modify','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/gmail.labels']);
        $client2->setAccessType('offline');
        $client2->setSubject($user);
        return $client2;
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

$clientService = getGoogleClient();


 /*************************************************
  * Ensure you've downloaded your oauth credentials
  ************************************************/
 if (!$oauth_credentials = getOAuthCredentialsFile()) {
   echo missingOAuth2CredentialsWarning();
   return;
 }
 /************************************************
  * NOTICE:
  * The redirect URI is to the current page, e.g:
  * http://localhost:8080/idtoken.php
  ************************************************/
 $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
 $client = new Google_Client();
 // USER AUTH
 $client->setAccessType('offline');
 $client->setAuthConfig($oauth_credentials);
 $client->setRedirectUri($redirect_uri);
 $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly'));
 $client->setApprovalPrompt('force');
 $client->setLoginHint('@newtelco.de');
 $plus = new Google_Service_Plus($client);

 /************************************************
  * If we're logging out we just need to clear our
  * local access token in this case
  ************************************************/
 if (isset($_REQUEST['logout'])) {
   unset($_SESSION['access_token']);
 }
 /************************************************
  * If we have a code back from the OAuth 2.0 flow,
  * we need to exchange that with the
  * Google_Client::fetchAccessTokenWithAuthCode()
  * function. We store the resultant access token
  * bundle in the session, and redirect to ourself.
  ************************************************/
 if (isset($_GET['code'])) {
   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
   // store in the session also
   $_SESSION['access_token'] = $token;
   // redirect back to the example
   header('Location: https://maintenance.newtelco.de/index.php');
   // return;
 }

  //print_r($_SESSION['access_token']);

  if (isset($_SESSION['access_token']['refresh_token'])) {
    setcookie("rtoken",$_SESSION['access_token']['refresh_token']);
  }
 /************************************************
   If we have an access token, we can make
   requests, else we generate an authentication URL.
  ************************************************/
 if (!empty($_SESSION['access_token']) && isset($_SESSION['access_token']['refresh_token'])) {
   $client->setAccessToken($_SESSION['access_token']);
 } else {
   $authUrl = $client->createAuthUrl();
   //header('Location: ' . $authUrl);
 }
 /************************************************
   If we're signed in we can go ahead and retrieve
   the ID token, which is part of the bundle of
   data that is exchange in the authenticate step
   - we only need to do a network call if we have
   to retrieve the Google certificate to verify it,
   and that can be cached.
  ************************************************/
 if ($client->getAccessToken()) {
   $token_data = $client->verifyIdToken();
 }

if($_COOKIE['rtoken']) {
 if($client->isAccessTokenExpired()){  // if token expired
      $refreshtoken = $_COOKIE['rtoken'];
     //var_dump($refreshtoken);
     $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/admin.directory.user','https://www.googleapis.com/auth/admin.directory.user.readonly','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/calendar'));
     $client->refreshToken($refreshtoken);
     $client->fetchAccessTokenWithRefreshToken($refreshtoken);
     $client->setApprovalPrompt('auto');
     $client->setAccessType('offline');
     $client->authenticate($refreshtoken);
     $accessToken=$client->getAccessToken();
     $_SESSION['access_token'] = $accessToken;
     //var_dump($accessToken);
     //$client->setAccessToken($_SESSION['access_token']);
     $token_data = $client->verifyIdToken();
 }
}
 $q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $_SESSION['access_token']['access_token'];
 $json = file_get_contents($q);
 $token_data=json_decode($json,true);

if ($_SESSION['access_token']['id_token'] === NULL):
  unset($_SESSION['access_token']);
?>

<!DOCTYPE html>
<html lang="en">
<div class="loginBG">
<head>
    <title>Newtelco Maintenance | Login</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="assets/images/favicon/favicon.ico">
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

      <!-- jquery -->
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

      <!-- Google font-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:200,400,500,700" type="text/css">

      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <!-- material design -->
      <link rel="stylesheet" href="assets/css/material.css">
      <script src="assets/js/material.min.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  </head>

  <body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">

        <main class="mdl-layout__content">

            <div class="demo-card-wide2 mdl-card mdl-shadow--6dp">
              <div class="mdl-card__title mdl-card__title__login">
                <h2 class="mdl-card__title-text"><img height="27px" width="200px" src="assets/images/newtelco_full2_lightgray2.png"/></h2>
              </div>
              <div class="mdl-card__supporting-text">
              <!-- login form -->
                <h5>Welcome to the Newtelco Maintenance Portal</h5>
                Please continue below with Google Sign-in:
              </div>

              <div class="mdl-card__actions mdl-card--border">

                <div class="signin_box">
                <?php if (isset($authUrl)): ?>
                  <div class="request">
                    <a class='login' href='<?= $authUrl ?>' data-onsuccess="onSignIn"><img class="signin_btn" src="assets/images/btn_google_signin_light_normal_web.png"
onmouseover="this.src='assets/images/btn_google_signin_light_focus_web.png'"
onmouseout="this.src='assets/images/btn_google_signin_light_normal_web.png'"
border="0" alt=""/></a>
                  </div>
                <?php
              else: var_export($access_token);
                endif
                ?>
                </div>
              </div>
            </div>
            </form>

        </main>
        <footer class="mdl-mini-footer">
          <div class="mdl-mini-footer__left-section">
            <div class="mdl-logo">Newtelco GmbH</div>
            <ul class="mdl-mini-footer__link-list">
              <li><a href="#">Help</a></li>
              <li><a href="#">Privacy & Terms</a></li>
            </ul>
          </div>
          <div class="mdl-layout-spacer"></div>
            <div class="mdl-mini-footer__right-section mdl-cell mdl-cell--4-col mdl-cell--middle mdl-typography--text-right">
              <div class="footertext">
                built with <span class="love">&hearts;</span> by <a target="_blank" class="footera" rel="noreferrer  href="https://github.com/ndom91">ndom91</a> &copy;
              </div>
            </div>
        </footer>
      </div>
</body>
</div>
</html>

<?php
  exit();
endif;
?>
