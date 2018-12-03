<?php

//require user configuration and database connection parameters

require('config.php');

//pre-define validation parameters

$usernamenotempty = TRUE;
$usernamevalidate = TRUE;
$usernamenotduplicate = TRUE;
$passwordnotempty = TRUE;
$passwordmatch = TRUE;
$passwordvalidate = TRUE;
$captchavalidation = TRUE;
$namenotempty = TRUE;
$namevalidate = TRUE;
$lnamenotempty = TRUE;
$lnamevalidate = TRUE;
$emailnotempty = TRUE;
$emailvalidate = TRUE;
$registration_suc = FALSE;

//Check if user submitted the desired password and username
if ((isset($_POST["desired_password"])) && (isset($_POST["desired_username"])) && (isset($_POST["desired_password1"])) && (isset($_POST["desired_name"])) && (isset($_POST["desired_lname"])) && (isset($_POST["desired_email"]))) {

//Username and Password has been submitted by the user
//Receive and validate the submitted information
//sanitize user inputs

    function sanitize($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        //$data = mysqli_real_escape_string($dbhandle, $data);
        return $data;
    }

    $desired_username = sanitize($_POST["desired_username"]);
    $desired_password = sanitize($_POST["desired_password"]);
    $desired_password1 = sanitize($_POST["desired_password1"]);
    $desired_name = sanitize($_POST["desired_name"]);
    $desired_lname = sanitize($_POST["desired_lname"]);
    $desired_email = sanitize($_POST["desired_email"]);

    // validate first name

    if (empty($desired_name)) {
        $namenotempty = FALSE;
    } else {
        $namenotempty = TRUE;
    }

    if ((!(ctype_alnum($desired_name))) || ((strlen($desired_name)) > 12)) {
        $namevalidate = FALSE;
    } else {
        $namevalidate = TRUE;
    }

    // validate last name

    if (empty($desired_lname)) {
        $lnamenotempty = FALSE;
    } else {
        $lnamenotempty = TRUE;
    }

    if ((!(ctype_alnum($desired_lname))) || ((strlen($desired_lname)) > 12)) {
        $lnamevalidate = FALSE;
    } else {
        $lnamevalidate = TRUE;
    }

    // validate email

    if (empty($desired_email)) {
        $emailnotempty = FALSE;
    } else {
        $emailnotempty = TRUE;
    }

    $middleemail = strlen($desired_email)-12;

    if (substr($desired_email,strlen($desired_email)-12,12) <> '@newtelco.de') {
        $emailvalidate = FALSE;
    } else {
        $emailvalidate = TRUE;
    }

    //validate username

    if (empty($desired_username)) {
        $usernamenotempty = FALSE;
    } else {
        $usernamenotempty = TRUE;
    }

    if ((!(ctype_alnum($desired_username))) || ((strlen($desired_username)) > 12)) {
        $usernamevalidate = FALSE;
    } else {
        $usernamevalidate = TRUE;
    }

    if (!($fetch = mysqli_fetch_array(mysqli_query($dbhandle, "SELECT `username` FROM `authentication` WHERE `username`='$desired_username'")))) {
      //no records for this user in the MySQL database
        $usernamenotduplicate = TRUE;
    } else {
        $usernamenotduplicate = FALSE;
    }

    //validate password

    if (empty($desired_password)) {
        $passwordnotempty = FALSE;
    } else {
        $passwordnotempty = TRUE;
    }

    if (strlen($desired_password) < 8) {
        $passwordvalidate = FALSE;
    } else {
        $passwordvalidate = TRUE;
    }

    if ($desired_password == $desired_password1) {
        $passwordmatch = TRUE;
    } else {
        $passwordmatch = FALSE;
    }

    $captchavalidation = TRUE;
    //Validate recaptcha
    /*require_once('recaptchalib.php');
    $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
    //captcha validation fails
        $captchavalidation = FALSE;
    } else {
        $captchavalidation = TRUE;
    }*/

    if (($usernamenotempty == TRUE)
        && ($usernamevalidate == TRUE)
        && ($usernamenotduplicate == TRUE)
        && ($passwordnotempty == TRUE)
        && ($passwordmatch == TRUE)
        && ($passwordvalidate == TRUE)
        && ($namevalidate == TRUE)
        && ($lnamevalidate == TRUE)
        && ($emailvalidate == TRUE)
        && ($captchavalidation == TRUE)) {


        //The username, password and recaptcha validation succeeds.
        //Hash the password
        //This is very important for security reasons because once the password has been compromised,
        //The attacker cannot still get the plain text password equivalent without brute force.

        function HashPassword($input) {
          //Credits: http://crackstation.net/hashing-security.html
          //This is secure hashing the consist of strong hash algorithm sha 256 and using highly random salt
            $salt = bin2hex(random_bytes(32));
            $hash = hash("sha256", $salt . $input);
            $final = $salt . $hash;
            return $final;
        }

        $hashedpassword = HashPassword($desired_password);
        $activation_code = 'abc';
        $activation_code = md5(rand());

        //Insert username and the hashed password to MySQL database
        $max_id = mysqli_query($dbhandle, "SELECT MAX(id) FROM authentication");
        $row1 = mysqli_fetch_array($max_id);
        $max_id1 = $row1[0];
        $max_id1++;
        $unverified_string = "unverified";
        mysqli_query($dbhandle, "INSERT INTO `authentication` (`id`,`username`, `password`, `fname`, `lname`, `email`, `user_activation_code`, `user_email_status`) VALUES ('$max_id1', '$desired_username', '$hashedpassword', '$desired_name', '$desired_lname', '$desired_email', '$activation_code', '$unverified_string')") or die(mysqli_error($dbhandle));
        //Send notification to webmaster
        //$message = "New member has just registered: $desired_username";
        //mail($email, $subject, $message, $from);
        //redirect to login page
        //$message = "wrong answer";

        $_SESSION['registration_true'] = true;

        $base_url = "https://maintenance.newtelco.de/";
        $mail_body = "
        <p>Hi ".$desired_username.",</p>
        <p>Thanks for Registration. Your login will only work after you verify your registration via the link below:<br>
        <p>Please Open this link to verified your email address - <a href=".$base_url."email_verification.php?activation_code=".$activation_code.">
        ".$base_url."email_verification.php?activation_code=".$activation_code."</a>
        <p>Best Regards,<br />Newtelco GmbH</p>
        ";
        require 'class/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();        //Sets Mailer to send message using SMTP
        $mail->Host = 'mail-120.cloud4partner.net';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
        $mail->Port = '25';        //Sets the default SMTP server port
        $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
        $mail->Username = 'cloud@new-telco.de';     //Sets SMTP username
        $mail->Password = 'N3wt3lco';     //Sets SMTP password
        $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
        $mail->From = 'cloud@new-telco.de';   //Sets the From email address for the message
        $mail->FromName = 'Newtelco';     //Sets the From name of the message
        $mail->AddAddress($desired_email, $desired_username);  //Adds a "To" address
        $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
        $mail->IsHTML(true);       //Sets message type to HTML
        $mail->Subject = '[Newtelco IT] Email Verification';   //Sets the Subject of the message
        $mail->Body = $mail_body;       //An HTML or plain text message body

        if($mail->Send())        //Send an Email. Return true on success or false on error
        {
            echo "<label class='text-success'>Register Done, Please check your mail.</label>";
            header(sprintf("Location: %s", $loginpage_url));
        }
        exit;
    }
}
?>
<!DOCTYPE HTML>
<html>
   <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="application-name" content="Newtelco IT Links">
  <title>Newtelco Maintenance | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
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
  <!-- Google font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:200,400,500,700" type="text/css">

  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <!-- material design -->
  <link rel="stylesheet" href="assets/css/material.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="assets/js/material.min.js"></script>
        <style type="text/css">
            .invalid {
              border: 1px solid #000;
              box-shadow: 0px 0px 15px rgba(255,0,0,0.8);
              background: rgba(255,0,0,0.2);
            }
            .registerHeader {
              text-align:center;
              color: rgba(103, 178, 54, 0.9);
              text-shadow: 0px 0px 15px rgba(255, 255, 255, 0.5);
              font-family: Ubuntu Mono;
            }
            input[type="text"], input[type="password"] {
              border-radius: 5px;
              align: center;
              width: 100%;
            }
            input[type="text"]::placeholder, input[type="password"]::placeholder {
              color: rgba(103, 178, 54, 0.5);
              font-size: 14px;
              font-weight: 600;
              font-family: Ubuntu Mono;
            }
            .error_text {
              color: rgba(255, 0, 0, 0.5);
              text-shadow: 0px 0px 15px rgba(255, 0, 0, 0.5);
            }
        </style>
    </head>
    <body>
  <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
      <header class="mdl-layout__header mdl-color--light-green-nt">
        <div class="mdl-layout__header-row">

          <span class="mdl-layout-title">Newtelco Maintenance</span>
          <div class="mdl-layout-spacer"></div>
            <?php if (isset($_SESSION['logged_in'])) { ?>
              <a href="logout.php?signature=<?php echo $_SESSION['signature']; ?>">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"><font color="white">Logout</font></button>
              </a>
            <?php } ?>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Maintenance</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.php">Home</a>
          <a class="mdl-navigation__link" href="overview.php">Overview</a>
          <a class="mdl-navigation__link" href="incoming.php">Incoming</a>
          <a class="mdl-navigation__link" target="_blank" href="https://crm.newtelco.de">CRM</a>
        </nav>
      </div>
        <main class="mdl-layout__content">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
            <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-phone mdl-typography--text-center">
            <h2>IT Admin Registration</h2>
            <br />
            Hi! This private website is restricted to public access. <br>
            Please register with your <code>@newtelco.de</code> email address below.
            <br><br>After successful registration, you will be redirected to the login page.
            <br /><br />

            <!-- Start of registration form -->
            <div class="login-box-body" style="background:rgba(255, 255, 255, 0.6);">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                <!-- First Name: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input type="text" class="mdl-textfield__input <?php if (($namenotempty == FALSE) || ($namevalidate == FALSE)) echo "invalid"; ?>" id="desired_name" name="desired_name">
                  <label class="mdl-textfield__label" for="desired_name">First Name</label>
                </div>

                <?php if ($namenotempty == FALSE)
                        echo '<span class="error_text">You have entered an empty first name.</span><br />'; ?>
                <?php if ($namevalidate == FALSE)
                        echo '<span class="error_text">Your first name should be alphanumeric and less than 12 characters.</span><br />'; ?><br />

                <!-- Last Name: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input type="text" class="mdl-textfield__input <?php if (($lnamenotempty == FALSE) || ($lnamevalidate == FALSE)) echo "invalid"; ?>" id="desired_lname" name="desired_lname">
                  <label class="mdl-textfield__label" for="desired_lname">Last Name</label>
                </div>

                <?php if ($lnamenotempty == FALSE)
                        echo '<span class="error_text">You have entered an empty last name.</span><br />'; ?>
                <?php if ($lnamevalidate == FALSE)
                        echo '<span class="error_text">Your last name should be alphanumeric and less than 12 characters.</span><br />'; ?><br />

                <!-- Email: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input type="text" class="mdl-textfield__input <?php if (($emailnotempty == FALSE) || ($emailvalidate == FALSE)) echo "invalid"; ?>" id="desired_email" name="desired_email">
                  <label class="mdl-textfield__label" for="desired_email">Email</label>
                </div>

                <?php if ($emailnotempty == FALSE)
                        echo '<span class="error_text">You have entered an empty email address.</span><br />'; ?>
                <?php if ($emailvalidate == FALSE)
                        echo '<span class="error_text">You are not using an @newtelco.de email address.</span><br />'; ?><br />

                <!-- Username: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input type="text" class="mdl-textfield__input <?php if (($usernamenotempty == FALSE) || ($usernamevalidate == FALSE) || ($usernamenotduplicate == FALSE)) echo "invalid"; ?>" id="desired_username" name="desired_username">
                  <label class="mdl-textfield__label" for="desired_username">Username</label>
                </div>

                <?php if ($usernamenotempty == FALSE)
                        echo '<span class="error_text">You have entered an empty username.</span><br />'; ?>
                <?php if ($usernamevalidate == FALSE)
                        echo '<span class="error_text">Your username should be alphanumeric and less than 12 characters.</span><br />'; ?>
                <?php if ($usernamenotduplicate == FALSE)
                        echo '<span class="error_text">Please choose another username, your username is already used.</span><br />'; ?><br />

                <!-- Password: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input name="desired_password" type="password" class="mdl-textfield__input <?php if (($passwordnotempty == FALSE) || ($passwordmatch == FALSE) || ($passwordvalidate == FALSE)) echo "invalid"; ?>" id="desired_password" >
                  <label class="mdl-textfield__label" for="desired_password">Password</label>
                </div>

                <br />
                <!-- Repeat Password: -->
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input name="desired_password1" type="password" class="mdl-textfield__input <?php if (($passwordnotempty == FALSE) || ($passwordmatch == FALSE) || ($passwordvalidate == FALSE)) echo "invalid"; ?>" id="desired_password1" >
                  <label class="mdl-textfield__label" for="desired_password1">Password</label>
                </div>

                <?php if ($passwordnotempty == FALSE)
                        echo '<span class="error_text">Your password is empty.</span><br />'; ?>
                <?php if ($passwordmatch == FALSE)
                        echo '<span class="error_text">Your password does not match.</span><br />'; ?>
                <?php if ($passwordvalidate == FALSE)
                        echo '<span class="error_text">Your password should be alphanumeric and greater 8 characters.</span><br />'; ?><br />

                <br />

                <input type="submit"  value="Register" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">

                <a href="index.php"><input type="back" value="Back to Login" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"></a>

              </div>
                <!-- Display validation errors -->
                <?php if ($captchavalidation == FALSE)
                        echo '<font color="red">Please enter correct captcha</font><br />'; ?>
                <?php if ($captchavalidation == FALSE)
                        echo '<font color="red">Your captcha is invalid.</font><br />'; ?>
            </form>
        </div>

        <div class="mdl-cell mdl-cell--3-col mdl-cell--0-col-phone"></div>
        </div>
        <!-- End of registration form -->
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
