<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

require_once('config.php');

include_once "base.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=configs/maintenanceapp-1dd9507b2c22.json');

$serviceUser = mysqli_query($dbhandle, "SELECT serviceuser from persistence where id like 0");
if ($fetch = mysqli_fetch_array($serviceUser)) {
  $user = $fetch[0];
}
function getGoogleClient() {
    return getServiceAccountClient();
}

function getServiceAccountClient() {
  //$user = 'ndomino@newtelco.de';
    global $user;

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
   $client->revokeToken();
   header('Location: https://maintenance.newtelco.de');
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

//var_dump($_SESSION['access_token']);

if(isset($_COOKIE['rtoken'])) {
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
} else if(isset($_COOKIE['mail1'])) {
  $requestedMail = $_COOKIE['mail1'];
    if($client->isAccessTokenExpired()){
      $rtoken_query = mysqli_query($dbhandle, "SELECT refreshToken from authentication where email like '$requestedMail' ");
      if ($fetch = mysqli_fetch_array($rtoken_query)) {
        $fetch = mysqli_fetch_array($rtoken_query);
        $rtoken = $fetch[0];
        $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/admin.directory.user','https://www.googleapis.com/auth/admin.directory.user.readonly','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/calendar'));
        $client->refreshToken($rtoken);
        $client->fetchAccessTokenWithRefreshToken($rtoken);
        $client->setApprovalPrompt('auto');
        $client->setAccessType('offline');
        $client->authenticate($rtoken);
        $accessToken=$client->getAccessToken();
        $_SESSION['access_token'] = $accessToken;
        //var_dump($accessToken);
        //$client->setAccessToken($_SESSION['access_token']);
        $token_data = $client->verifyIdToken();
        // $mail = $token_data['email'];
      }
    }
}
// var_dump($token_data['email']);
if($client->isAccessTokenExpired() && isset($rtoken)){
  $rtoken_insertquery = mysqli_query($dbhandle, "UPDATE authentication set refreshToken = '$rtoken' where email like '$tokenemail'");
}

// $q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $_SESSION['access_token']['access_token'];
// $json = file_get_contents($q);
// $token_data=json_decode($json,true);

// if (isset($token_data['email'])) {
//   setcookie("mail1",$token_data['email']);
// }

if (!isset($_SESSION['access_token']['id_token'])):
  unset($_SESSION['access_token']);
?>
<!DOCTYPE html>
<html lang="en">
<style>
<?php echo file_get_contents("dist/css/material.min.css"); ?>
<?php echo file_get_contents("dist/css/style.min.css"); ?>
</style>
<div class="loginBG">
<head>
    <title>Newtelco Maintenance | Login</title>

    <link id="favicon2" rel="shortcut icon" type="image/png" src="dist/images/fav-32x32.png">
    <?php echo file_get_contents("views/meta.html"); ?>

    <!-- jquery -->
    <script rel="preload" as="script" src="dist/js/jquery-3.3.1.min.js"></script>

    <!-- material design -->
    <script rel="preload" as="script" src="dist/js/material.min.js"></script>

    <!-- particle.js -->
    <script rel="preload" as="script" src="dist/js/particle.js"></script>
    <script>
    $(document).ready(function() {

      setTimeout(function() {
        particlesJS("particles-js", {
        "particles": {
          "number": {
            "value": 120,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#67B246"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 1,
              "color": "#67B246"
            },
            "polygon": {
              "nb_sides": 5
            }
          },
          "opacity": {
            "value": 0.6,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 3,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#67B246",
            "opacity": 0.6,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 2,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": false,
              "mode": "repulse"
            },
            "resize": true
          },
          "modes": {
            "repulse": {
              "distance": 50,
              "duration": 0.2
            }
          }
        }
      })
      }, 149)
      setTimeout(function() {window.dispatchEvent(new Event('resize'))}, 150);

    });
  </script>
  <style>
    canvas {
      width: 100%;
      height: 100%;
    }
  </style>
  </head>

  <body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">

        <main id="particles-js" class="mdl-layout__content">
            <div class="demo-card-wide2 mdl-card mdl-shadow--6dp">
              <div class="mdl-card__title mdl-card__title__login">
                <h2 class="mdl-card__title-text"><img height="27px" width="200px" src="dist/images/newtelco_full2_lightgray2.png"/></h2>
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
                    <a class='login' href='<?= $authUrl ?>' data-onsuccess="onSignIn"><img class="hvr-grow signin_btn" src="dist/images/btn_google_signin_light_normal_web.png"
onmouseover="this.src='dist/images/btn_google_signin_light_focus_web.png'"
onmouseout="this.src='dist/images/btn_google_signin_light_normal_web.png'"
border="0" alt=""/></a>
                  </div>
                <?php
              else: var_export($access_token);
                endif
                ?>
                </div>
              </div>
            </div>
        </main>
        <?php echo file_get_contents("views/footer.html"); ?>
      </div>
</body>
</div>

<!-- Google font-->
<link prefetch rel="preload stylesheet" as="style" href="dist/fonts/GFonts_Roboto.css" type="text/css" onload="this.rel='stylesheet'">

<!-- material design -->
<link rel="preload stylesheet" as="style" href="dist/fonts/materialicons400.css">

<!-- hover css -->
<link type="text/css" rel="stylesheet" href="dist/css/hover.css" />

<!-- animate css -->
<link type="text/css" rel="stylesheet" href="dist/css/animate.css" />

<!-- favicon.js -->
<script rel="preload" as="script" src="dist/js/favicon.js"></script>

<!-- google api.js -->
<!-- <script src="https://apis.google.com/js/api.js"></script> -->

<script>
$(document).ready(function() {

// https://github.com/daneden/animate.css

//animate in 
const loginBox1 =  document.querySelector('.demo-card-wide2');
$(loginBox1).css('opacity','1');
loginBox1.classList.add('animated', 'fadeIn');

// initial favicon
var favicon=new Favico();
var image=document.getElementById('favicon2');
favicon.image(image);

})

// function start() {
//   // 2. Initialize the JavaScript client library.
//   gapi.client.init({
//     'apiKey': 'YOUR_API_KEY',
//     // Your API key will be automatically added to the Discovery Document URLs.
//     'discoveryDocs': ['https://people.googleapis.com/$discovery/rest'],
//     // clientId and scope are optional if auth is not required.
//     'clientId': 'YOUR_WEB_CLIENT_ID.apps.googleusercontent.com',
//     'scope': 'profile',
//   }).then(function() {
//     // 3. Initialize and make the API request.
//     return gapi.client.people.people.get({
//       'resourceName': 'people/me',
//       'requestMask.includeField': 'person.names'
//     });
//   }).then(function(response) {
//     console.log(response.result);
//   }, function(reason) {
//     console.log('Error: ' + reason.result.error.message);
//   });
// };
// // 1. Load the JavaScript client library.
// gapi.load('client', start);
</script>
</html>
<?php
  exit();
endif;
?>
