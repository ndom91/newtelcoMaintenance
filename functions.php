<?php

function &getConnection(){
  $username = 'ndomino';
  $password = 'Miney91*';
  $host = '94.249.164.180';
  $db = 'maintenance';
  $connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  /* check connection */
  if ($connection->connect_errno) {
      return $connection->connect_error;
      exit();
  }

  return $connection;
}

function closeConnection ($db){
    $db = NULL;
}
