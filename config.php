<?php

    $domain = "https://".$_SERVER['SERVER_NAME'];

    $privatekey = "6LfBa20UAAAAANLBlKD6YnxrgSC62vFe58A7kiYA";
    $publickey = "6LfBa20UAAAAAKhZPzEvB8oiLtMUcBpfHeuhuO1f";

    function db_connect() {

      static $connection;

      if(!isset($connection)) {
        $dbconfig = parse_ini_file('configs/dbconfig_newtelcondo.ini');

        $username = $dbconfig['username'];
        $password = $dbconfig['password'];
        $hostname = $dbconfig['hostname'];
        $database = $dbconfig['database'];

        $connection = mysqli_connect($hostname, $username, $password, $database);
        mysqli_set_charset($connection, 'utf8');
      }
      if($connection === false) {
        return mysqli_connect_error();
      }
      return $connection;
    }

    $dbhandle = db_connect();

?>
