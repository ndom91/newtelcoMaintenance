<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

include_once "base.php";
// FOR DEBUGGING ONLY
/* $httpClient = new GuzzleHttp\Client([
    'proxy' => '192.168.11.139:8888', // by default, Charles runs on localhost port 8888
    'verify' => false, // otherwise HTTPS requests will fail.
]);*/

/************************************************
 * Create access token ourselves
 ***********************************************

$private_key = openssl_pkey_get_private('maintenanceapp-d1cb8dfbfa7a.p12', 'notasecret');

$header = array("alg" => "RS256", "typ" => "JWT");
$header = base64_encode(utf8_encode(json_encode($header)));
$exp = time() + (60 * 60);


$jwt_cs = array(
   "iss" => "maintenanceacct2@maintenanceapp-221917.iam.gserviceaccount.com",
   "scope" => "https://www.googleapis.com/auth/calendar",
   "aud" => "https://www.googleapis.com/oauth2/v3/token",
   "exp" => $exp,
   "iat" => time(),
   "access_type" => "offline"
);
$jwt_cs = base64_encode(utf8_encode(json_encode($jwt_cs)));

openssl_sign($header.'.'.$jwt_cs, $sign, $private_key, 'sha256WithRSAEncryption');

$sign = base64_encode($sign);

$jwt = $header.'.'.$jwt_cs.'.'.$sign;
$login_data = array(
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => $jwt
);
$url='https://www.googleapis.com/oauth2/v3/token';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($login_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);*/

/*
   $sa = new ServiceAccountCredentials(
       'https://www.googleapis.com/auth/gmail.metadata',
       'maintenanceapp-221917-10f62bc3036f.json'
   );
   $middleware = new AuthTokenMiddleware($sa);
   $stack = HandlerStack::create();
   $stack->push($middleware);

   $clientGuzzle = new Client([
       'handler' => $stack,
       'base_uri' => 'https://www.googleapis.com/taskqueue/v1beta2/projects/',
       'auth' => 'google_auth' // authorize all requests
   ]);
*/

/*
   use Google\Auth\OAuth2;
   use Google\Auth\Middleware\ScopedAccessTokenMiddleware;
   use Google\Auth\Credentials\ServiceAccountCredentials;
   use Google\Auth\Middleware\AuthTokenMiddleware;
   use GuzzleHttp\Client;
   use GuzzleHttp\HandlerStack;

   function make_iap_request($url, $clientId)
   {
       $pathToServiceAccount = 'maintenanceapp-221917-10f62bc3036f.json';
       $serviceAccountKey = json_decode(file_get_contents($pathToServiceAccount), true);
       $oauth_token_uri = 'https://oauth2.googleapis.com/token';
       $iam_scope = 'https://www.googleapis.com/auth/userinfo.email';

       # Create an OAuth object using the service account key
       $oauth = new OAuth2([
           'audience' => $oauth_token_uri,
           'issuer' => $serviceAccountKey['client_email'],
           'signingAlgorithm' => 'RS256',
           'signingKey' => $serviceAccountKey['private_key'],
           'tokenCredentialUri' => $oauth_token_uri,
       ]);
       $oauth->setGrantType(OAuth2::JWT_URN);
       $oauth->setAdditionalClaims(['target_audience' => $clientId]);

       # Obtain an OpenID Connect token, which is a JWT signed by Google.
       $token = $oauth->fetchAuthToken();
       $idToken = $oauth->getIdToken();

       # Construct a ScopedAccessTokenMiddleware with the ID token.
       $middleware = new ScopedAccessTokenMiddleware(
           function () use ($idToken) {
               return $idToken;
           },
           $iam_scope
       );

       $stack = HandlerStack::create();
       $stack->push($middleware);

       # Create an HTTP Client using Guzzle and pass in the credentials.
       $http_client = new Client([
           'handler' => $stack,
           'base_uri' => $url,
           'auth' => 'scoped'
       ]);

       # Make an authenticated HTTP Request
       $response = $http_client->request('GET', '/', []);
       return $response;
   }
*/

/************************************************
 * Service Account Requires
 ***********************************************

  $user_to_impersonate = 'ndomino@newtelco.de';
  $clientService = new Google_Client();
  $clientService->setAuthConfig('maintenanceapp-221917-10f62bc3036f.json');
  $clientService->setApplicationName('MaintenanceServiceAccount1');
  //$clientService->useApplicationDefaultCredentials();
  $clientService->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/calendar'));
  $clientService->setSubject($user_to_impersonate);
  $clientService->authorize();
  $token3 = $clientService->getAccessToken();

  $clienttest2 = new Google_Client();
  $clienttest2->setApplicationName ('Application Name');
  $clienttest2->useApplicationDefaultCredentials();
  $clienttest2->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/calendar'));
  $clienttest2->setAuthConfig('maintenanceapp-221917-10f62bc3036f.json');
  $clienttest2->setSubject('ndomino@newtelco.de');
  $gmailtest2 = new Google_Service_Gmail($clienttest2);*/


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
 $client->setAuthConfig($oauth_credentials);
 $client->setRedirectUri($redirect_uri);
 $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/calendar'));
 $client->setApprovalPrompt('auto');
 $plus = new Google_Service_Plus($client);

 /************************************************
  * If we're logging out we just need to clear our
  * local access token in this case
  ************************************************/
 if (isset($_REQUEST['logout'])) {
   unset($_SESSION['id_token_token']);
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
   $_SESSION['id_token_token'] = $token;
   // redirect back to the example
   header('Location: https://maintenance.newtelco.de/index.php');
   // return;
 }
 /************************************************
   If we have an access token, we can make
   requests, else we generate an authentication URL.
  ************************************************/
 if (
   !empty($_SESSION['id_token_token'])
   && isset($_SESSION['id_token_token']['id_token'])
 ) {
   $client->setAccessToken($_SESSION['id_token_token']);
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


if (!isset($_SESSION['id_token_token'])):
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

      <!-- Google font-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

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
            <!-- Wide card with share menu button -->
            <style>
            .demo-card-wide.mdl-card {
              width: 492px;
              margin-left: auto;
              margin-right: auto;
              margin-top: 12%;
            }
            .demo-card-wide > .mdl-card__title {
              color: #fff;
              height: 176px;
              background: url('assets/images/bg4.jpg') center / cover;
            }
            .demo-card-wide > .mdl-card__menu {
              color: #fff;
            }
            </style>

            <div class="demo-card-wide mdl-card mdl-shadow--6dp">
              <div class="mdl-card__title">
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
                    <a class='login' href='<?= $authUrl ?>' data-onsuccess="onSignIn"><img class="signin_btn"  src="assets/images/btn_signinGoogle.png"/></a>
                  </div>
                <?php
                else: var_export($token_data);
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
        </footer>
      </div>
</body>
</div>
</html>

<?php
  exit();
endif;
?>
