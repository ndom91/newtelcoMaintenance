<?php

function &getConnection(){
  $username = 'ndomino';
  $password = 'Miney91*';
  $host = '94.249.164.180';
  $db = 'maintenance';
  $connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);
  return $connection;
}

function closeConnection ($db){
    $db = NULL;
}
