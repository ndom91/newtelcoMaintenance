<?php
header('HTTP/1.1 403 Forbidden');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Newtelco Maintenance | Forbidden</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Favicon icon -->
      <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
      <!-- Google font-->
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
      
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <link rel='stylesheet' href='assets/css/material.blue_grey-light_green.css'>
  </head>

  <body >
  <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Login card start -->
                    <form class="md-float-material form-material">
                        <div class="text-center">
                            <img style="width: 240px; height: auto;" src="assets/images/newtelco_full2_lightgray2.png" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="text-center"><i class="icofont icofont-lock text-primary f-80"></i></h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                  <font size="3">You have been denied access because of the following reasons:<br /><br /></font>
                                  <font size="2">
                                  1.) Too many failed login attempts, so you are likely brute forcing through logins.<br />
                                  2.) You have been accessing an authorized user account login through a stolen or hijacked session.<br /><br /></font>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                      <a href="sessiondestroy.php">
                                        <button type="button" class="btn btn-newtelco btn-md btn-block waves-effect text-center m-b-20"><i style="color: #67B246 !important" class="icofont icofont-lock text-newtelco"></i> Back to Login </button>
                                      </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Thank you.</p>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="assets/images/favicon-32x32.png" alt="nt-logo.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Login card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
</body>

</html>
