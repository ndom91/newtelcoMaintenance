<?php

  //require('authenticate_google.php');
  require_once('config.php');

  header('Content-Type: application/json');

  if (isset($_GET['dCID'])) {

    $dCID = $_GET['dCID'];

    $result = mysqli_query($dbhandle, "SELECT kunden.id, kunden.derenCID, kunden.unsereCID, companies.name, kunden.mailsend FROM kunden LEFT JOIN companies ON kunden.kunde = companies.id WHERE kunden.derenCID LIKE '$dCID'");          //query

    $array2 = array();

      while($resultsrows = mysqli_fetch_row($result)) {
        $array2[] = $resultsrows;
      }

    echo json_encode($array2);

  } elseif (isset($_POST['data'])) {

    $fields=$_POST['data'];

/*
    $omaileingang = '';
    $oreceivedmail = '';
    $olieferant = '';
    $oderenCIDid = '';
    $obearbeitetvon = '';
    $omaintenancedate = '';
    $ostartdatetime = '';
    $oenddatetime = '';
    $opostponed = '';
    $onotes = '';
    $omailankunde = '';
    $ocal = '';
    $odone = 0;
*/
    $omaileingang = mysqli_real_escape_string($dbhandle, $fields[0]['omaileingang']);
    $oreceivedmail = mysqli_real_escape_string($dbhandle, $fields[0]['oreceivedmail']);
    $olieferant = mysqli_real_escape_string($dbhandle, $fields[0]['olieferant']);
    $oderenCIDid = mysqli_real_escape_string($dbhandle, $fields[0]['oderenCIDid']);
    $obearbeitetvon = mysqli_real_escape_string($dbhandle, $fields[0]['obearbeitetvon']);
    $omaintenancedate = mysqli_real_escape_string($dbhandle, $fields[0]['omaintenancedate']);
    $ostartdatetime = mysqli_real_escape_string($dbhandle, $fields[0]['ostartdatetime']);
    $oenddatetime = mysqli_real_escape_string($dbhandle, $fields[0]['oenddatetime']);
    $opostponed = mysqli_real_escape_string($dbhandle, $fields[0]['opostponed']);
    $onotes = mysqli_real_escape_string($dbhandle, $fields[0]['onotes']);
    $omailankunde = mysqli_real_escape_string($dbhandle, $fields[0]['omailankunde']);
    $ocal = mysqli_real_escape_string($dbhandle, $fields[0]['ocal']);
    $odone = mysqli_real_escape_string($dbhandle, $fields[0]['odone']);

    $lastIDQ =  mysqli_query($dbhandle, "SELECT MAX(id) FROM maintenancedb") or die(mysqli_error($dbhandle));
    $fetchID = mysqli_fetch_array($lastIDQ);
    $lastID = $fetchID[0] + 1;

    $kundenQ = mysqli_query($dbhandle, "SELECT id, name FROM companies WHERE name LIKE '$olieferant'") or die(mysqli_error($dbhandle));
    if ($fetchK = mysqli_fetch_array($kundenQ)) {
      $olieferant = $fetchK[0];
    } else {
      $kundenIQ = mysqli_query($dbhandle, "INSERT INTO companies (name) VALUES ('$olieferant')") or die(mysqli_error($dbhandle));
    }

    $resultx = mysqli_query($dbhandle, "INSERT INTO maintenancedb (id, maileingang, receivedmail, bearbeitetvon, lieferant, derenCIDid, maintenancedate, startDateTime, endDateTime, postponed, notes, mailankunde, cal, done)
    VALUES ('$lastID', '$omaileingang', '$oreceivedmail', '$obearbeitetvon', '$olieferant', '$oderenCIDid', '$omaintenancedate', '$ostartdatetime', '$oenddatetime', '$opostponed', '$onotes', '$omailankunde', '$ocal', '$odone')")  or die(mysqli_error($dbhandle));

    if ($resultx == 'TRUE'){
        echo 1;
    } else {
        echo 0;
    }

    //echo json_encode($oreceivedmail);

  } else {

    echo json_encode('fukc you');

  }
?>
