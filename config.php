<?php

    $username = "maint";
    $password = "N3wt3lco";
    $hostname = "94.249.164.180";
    $database = "maintenance";

    $domain = "https://maintenance.newtelco.de/";
    //Define length of salt,minimum=10, maximum=35
    $length_salt = 15;
    //Define the maximum number of failed attempts to ban brute force attackers
    //minimum is 5
    $maxfailedattempt = 25;
    //Define session timeout in seconds
    //minimum 60 (for one minute)
    $sessiontimeout = 1800;

    $privatekey = "6LfBa20UAAAAANLBlKD6YnxrgSC62vFe58A7kiYA";
    $publickey = "6LfBa20UAAAAAKhZPzEvB8oiLtMUcBpfHeuhuO1f";

    $dbhandle = mysqli_connect($hostname, $username, $password, $database);
    mysqli_set_charset($dbhandle, 'utf8');
    // Test if connection occured.
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    $loginpage_url = $domain . 'index.php';
    $forbidden_url = $domain . '403forbidden.php';

?>
