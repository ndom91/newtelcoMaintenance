<!DOCTYPE html>
<html >
<?php

// source: https://gist.github.com/frankleromain/2387759
// ldap: https://samjlevy.com/php-ldap-login/

function authenticateldap($user, $password) {
  if(empty($user) || empty($password)) return false;

  // active directory server
  $ldap_host = "ldap://94.249.131.3:389";

  // active directory DN (base location of ldap search)
  $ldap_dn = "OU=Users,OU=Frankfurt,dc=NEWTELCO,dc=LOCAL";

  // active directory user group name
  $ldap_user_group = "Users";

  // active directory manager group name
  $ldap_manager_group = "WebManagers";

  // domain, for purposes of constructing $user
  $ldap_usr_dom = 'NEWTELCOSRV\\';

  // connect to active directory
  $ldap = ldap_connect($ldap_host);


  // verify user and password
  if($bind = @ldap_bind($ldap, $ldap_usr_dom.$user, $password)) {
    // valid
    // check presence in groups
    $filter = "(sAMAccountName=".$user.")";
    $attr = array("memberof");
    $result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
    $entries = ldap_get_entries($ldap, $result);
    ldap_unbind($ldap);

    // check groups
    $access = 0;
    foreach($entries[0]['memberof'] as $grps) {
      // is manager, break loop
      if(strpos($grps, $ldap_manager_group)) { $access = 2; break; }

      // is user
      if(strpos($grps, $ldap_user_group)) $access = 1;
    }

    if($access != 0) {
      // establish session variables
      $_SESSION['user'] = $user;
      $_SESSION['access'] = $access;
      return true;
    } else {
      // user has no rights
      return false;
    }

  } else {
    // invalid name or password
    return false;
  }
}

function writeToLogFile($mssg) {
    $today = date("Y_m_d");
    $logfile = "failed_login.log";
    $dir = 'logs';
    $saveLocation=$dir . '/' . $logfile;
     if  (!$handle = @fopen($saveLocation, "a")) {
          exit;
     }
     else {
          if (@fwrite($handle,"$mssg\r\n") === FALSE) {
               exit;
          }
          @fclose($handle);
     }
}
$error = '';
//require user configuration and database connection parameters
//Start PHP session
session_start();


//require user configuration and database connection parameters
require_once('config.php');

global $dbhandle;

//Check if a user has logged-in
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = FALSE;
}

$loginattempts_username = 0;
$loginattempts_total = 0;

$userhash = "b";
$correcthash = "a";

if (($_SESSION['logged_in']) == TRUE) {
    //valid user has logged-in to the website
      //Check for unauthorized use of user sessions
    $iprecreate = $_SERVER['REMOTE_ADDR'];
    $useragentrecreate = $_SERVER["HTTP_USER_AGENT"];
    $signaturerecreate = $_SESSION['signature'];
      //Extract original salt from authorized signature
    $saltrecreate = substr($signaturerecreate, 0, $length_salt);
      //Extract original hash from authorized signature
    $originalhash = substr($signaturerecreate, $length_salt, 40);
      //Re-create the hash based on the user IP and user agent
        //then check if it is authorized or not
    $hashrecreate = sha1($saltrecreate . $iprecreate . $useragentrecreate);
    if (!($hashrecreate == $originalhash)) {
        //Signature submitted by the user does not matched with the
        //authorized signature
        //This is unauthorized access
        //Block it
        header(sprintf("Location: %s", $forbidden_url));
        exit;
    }
    //Session Lifetime control for inactivity
    //Credits: http://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes
    if ((isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessiontimeout))) {
        session_destroy();
        session_unset();
        //redirect the user back to login page for re-authentication
        $redirectback = $domain . 'index.php';
        header(sprintf("Location: %s", $redirectback));
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}


//Pre-define validation
$validationresults = TRUE;
$registered = TRUE;
$verifiedEmail = TRUE;
//Trapped brute force attackers and give them more hard work by providing a captcha-protected page
$iptocheck = $_SERVER['REMOTE_ADDR'];
$iptocheck = mysqli_real_escape_string($dbhandle, $iptocheck);
$iptocheck_query = mysqli_query($dbhandle, "SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'");
if ($fetch = mysqli_fetch_array($iptocheck_query)) {
    //Already has some IP address records in the database
    //Get the total failed login attempts associated with this IP address
    $resultx = mysqli_query($dbhandle, "SELECT `failedattempts` FROM `ipcheck` WHERE `loggedip`='$iptocheck'");
    $rowx = mysqli_fetch_array($resultx);
    $loginattempts_total = $rowx['failedattempts'];
    If ($loginattempts_total > $maxfailedattempt) {
      //too many failed attempts allowed, redirect and give 403 forbidden.
        header(sprintf("Location: %s", $forbidden_url));
        exit;
    }
}

//Check if the form is submitted
// && ($_SESSION['LAST_ACTIVITY'] == FALSE)
if ((isset($_POST["pass"])) && (isset($_POST["user"])) ) {
//Username and password has been submitted by the user
//Receive and sanitize the submitted information
    function sanitize($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        //$data = mysqli_real_escape_string($dbhandle, $data);
        return $data;
    }

    $user = sanitize($_POST["user"]);
    $pass = sanitize($_POST["pass"]);
    //validate username
    $validateUser = mysqli_query($dbhandle, "SELECT `username` FROM `authentication` WHERE `username`='$user'");
    $validateUserCount = mysqli_num_rows($validateUser);
    if ($validateUserCount == 0) {
      //no records of username in database
      //user is not yet registered
        $registered = FALSE;
    }
    if ($registered == TRUE) {
      //Grab login attempts from MySQL database for a corresponding username
        $result1 = mysqli_query($dbhandle, "SELECT `loginattempt` FROM `authentication` WHERE `username`='$user'");
        $row = mysqli_fetch_array($result1);
        $loginattempts_username = $row['loginattempt'];

        $result3= mysqli_query($dbhandle, "SELECT `user_email_status` FROM `authentication` WHERE `username`='$user'");
        $row3 = mysqli_fetch_array($result3);
        $user_email_status = $row3['user_email_status'];
        if ($user_email_status == 'verified') {
          $verifiedEmail = TRUE;
        } else {
          $verifiedEmail = FALSE;
        }
    }
    /*if (($loginattempts_username > 2) || ($registered == FALSE) || ($loginattempts_total > 2)) {
      //Require those user with login attempts failed records to
      //submit captcha and validate recaptcha

        $gresponseJson = $_POST['g-recaptcha-response'];

        function validateRecaptchav2($gresponse) {
            if(isset($gresponse)){

                 $privatekey = "6LfBa20UAAAAANLBlKD6YnxrgSC62vFe58A7kiYA";
                $captcha=$gresponse;
                $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $captcha . "&remoteip=".$_SERVER['REMOTE_ADDR']);

                return $response;
            }
        }
        $recaptchavalidation = TRUE;
        /*
        if (validateRecaptchav2($gresponseJson)===true) {
          //captcha validation fails
            $recaptchavalidation = TRUE;
        } else {
            $recaptchavalidation = FALSE;
        }

    }*/
    //Get correct hashed password based on given username stored in MySQL database
    if ($registered == TRUE) {

       $result = mysqli_query($dbhandle, "SELECT `password`, `fname`, `lname`, `email` FROM `authentication` WHERE `username`='$user'");
       $row = mysqli_fetch_array($result);

       $correctpassword = $row['password'];
       $salt = substr($correctpassword, 0, 64);
       $correcthash = substr($correctpassword, 64, 64);
       $userhash = hash("sha256", $salt . $pass);

       if (isset($_POST['ldap'])) {

          if(authenticateldap($user, $pass) == TRUE) {
            $userhash = 'abc';
            $correcthash = 'abc';
          } else {
            $userhash = 'abc1';
            $correcthash = 'abc2';
          }
      }

      $_SESSION['fname'] = $row['fname'];
      $_SESSION['lname'] = $row['lname'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['login_user'] = $user;

      }

    if ((!($userhash == $correcthash)) || ($registered == FALSE) || ($verifiedEmail == FALSE)) {
      //user login validation fails
        $validationresults = FALSE;
        //log login failed attempts to database
        if ($registered == TRUE) {
            $loginattempts_username = $loginattempts_username + 1;
            $loginattempts_username = intval($loginattempts_username);
            //update login attempt records
            mysqli_query($dbhandle, "UPDATE `authentication` SET `loginattempt` = '$loginattempts_username' WHERE `username` = '$user'");
            //Possible brute force attacker is targeting registered usernames
            //check if has some IP address records
            if (!($fetch = mysqli_fetch_array(mysqli_query($dbhandle, "SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'")))) {
              //no records
              //insert failed attempts
                $loginattempts_total = 1;
                $loginattempts_total = intval($loginattempts_total);
                mysqli_query($dbhandle, "INSERT INTO `ipcheck` (`loggedip`, `failedattempts`) VALUES ('$iptocheck', '$loginattempts_total')");
            } else {
              //has some records, increment attempts
                $loginattempts_total = $loginattempts_total + 1;
                mysqli_query($dbhandle, "UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");
            }
        }
        //Possible brute force attacker is targeting randomly
        if ($registered == FALSE) {
            if (!($fetch = mysqli_fetch_array(mysqli_query($dbhandle, "SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'")))) {
              //no records
              //insert failed attempts
                $loginattempts_total = 1;
                $loginattempts_total = intval($loginattempts_total);
                mysqli_query($dbhandle, "INSERT INTO `ipcheck` (`loggedip`, `failedattempts`) VALUES ('$iptocheck', '$loginattempts_total')");
            } else {
              //has some records, increment attempts
                $loginattempts_total = $loginattempts_total + 1;
                mysqli_query($dbhandle, "UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");
            }
        }
    } else {
      //user successfully authenticates with the provided username and password
      //Reset login attempts for a specific username to 0 as well as the ip address
        $loginattempts_username = 0;
        $loginattempts_total = 0;
        $loginattempts_username = intval($loginattempts_username);
        $loginattempts_total = intval($loginattempts_total);
        mysqli_query($dbhandle, "UPDATE `authentication` SET `loginattempt` = '$loginattempts_username' WHERE `username` = '$user'");
        mysqli_query($dbhandle, "UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");

        // set last login time and increase total_loginAttempts by one
        $result2 = mysqli_query($dbhandle, "SELECT `total_loginattempts` FROM `authentication` WHERE `username`='$user'");
        $row2 = mysqli_fetch_array($result2);
        $total_loginAttempts1 = $row2['total_loginattempts'];
        $total_loginAttempts1++;
        $now = date("Y-m-d H:i:s");
        mysqli_query($dbhandle, "UPDATE `authentication` SET `total_loginattempts` = '$total_loginAttempts1', `lastlogin_ip` = '$iptocheck' WHERE `username` = '$user'");
        mysqli_query($dbhandle, "UPDATE `authentication` SET `last_login` = '$now' WHERE `username` = '$user'");
        //Generate unique signature of the user based on IP address
        //and the browser then append it to session
        //This will be used to authenticate the user session
        //To make sure it belongs to an authorized user and not to anyone else.
        //generate random salt
        function genRandomString($length = 50) {
          $str = "";
          $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
          $max = count($characters) - 1;
          for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
          }
          return $str;
        }
        $random = genRandomString();
        $salt_ip = substr($random, 0, $length_salt);
        //hash the ip address, user-agent and the salt
        $useragent = $_SERVER["HTTP_USER_AGENT"];
        $hash_user = sha1($salt_ip . $iptocheck . $useragent);
        //concatenate the salt and the hash to form a signature
        $signature = $salt_ip . $hash_user;
        //Regenerate session id prior to setting any session variable
        //to mitigate session fixation attacks
        session_regenerate_id();
        //Finally store user unique signature in the session
        //and set logged_in to TRUE as well as start activity time
        $_SESSION['signature'] = $signature;
        $_SESSION['logged_in'] = TRUE;
        $_SESSION['LAST_ACTIVITY'] = time();
    }
}


function debug_to_console( $data ) {
  $output = $data;
  if ( is_array( $output ) )
      $output = implode( ',', $output);

  echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

if (!$_SESSION['logged_in']):
?>

<!DOCTYPE html>
<html lang="en">
<div class="loginBG">
<head>
    <title>Newtelco Maintenance | Login</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  </head>

  <body>
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <form class="md-float-material form-material" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="text-center">
                            <img src="assets/images/newtelco_full2_lightgray2.png" style="opacity:0.7" alt="newtelco_full_lightgray2.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Sign In</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" id="user" name="user" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Username</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="pass" name="pass" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                  <?php if ($validationresults == FALSE && $verifiedEmail == FALSE)
                                    echo '<div class="row m-t-25 text-left">
                                      <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                          <label>
                                            <span class="error-text">Email not verified - please check your inbox.</span>
                                          </label>
                                        </div>
                                      </div>
                                    </div>'; ?>
                                  <?php if ($validationresults == FALSE)
                                    echo '<div class="row m-t-25 text-left">
                                      <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                          <label>
                                            <span class="error-text">Please enter valid username or password.</span>
                                          </label>
                                        </div>
                                      </div>
                                    </div>'; ?>
                                <div class="row m-t-30">
                                  <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                                    <div class="col-md-12">
                                        <input type="submit" value=" Sign In " class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"></input>

                                    </div>
                                </div>
                                <p class="text-inverse text-left">Don't have an account?<a href="auth-sign-up-social.html"> <b>Register here </b></a>!</p>
                            </div>
                        </div>
                    </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
</body>
</div>
</html>
<?php
    exit();
endif;
?>
