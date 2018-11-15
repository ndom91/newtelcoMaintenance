<?php

  //require('authenticate_google.php');
  require_once('config.php');
  
  header('Content-Type: application/json');
  
  $dCID = $_GET['dCID'];

  $result = mysqli_query($dbhandle, "SELECT * FROM kunden WHERE derenCID LIKE '$dCID'");          //query
  
  $array2 = array();
  //$array = array("data", $array2);
  
  while($resultsrows = mysqli_fetch_row($result)) {
    $array2[] = $resultsrows;
  }

  echo json_encode($array2);
?>