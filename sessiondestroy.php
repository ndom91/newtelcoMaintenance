<?php


Session_start();
Session_destroy();
header('Location: '.$_SERVER['SERVER_NAME']);


?>