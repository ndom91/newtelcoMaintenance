<?php

  //require('authenticate_google.php');
  require_once('config.php');

  header('Content-Type: application/json');

  if (isset($_GET['kunden'])) {

    /**********************
     *  SETTINGS - KUNDEN
     *********************/

    $kundenQ = mysqli_query($dbhandle, "SELECT kunden.id, kunden.derenCID, kunden.unsereCID, companies.name FROM kunden LEFT JOIN companies ON kunden.kunde = companies.id;") or die(mysqli_error($dbhandle));          //query

    $kundenArray = array();

    while($kundenResults = mysqli_fetch_assoc($kundenQ)) {
      $kundenArray[] = $kundenResults;
    }

    echo json_encode($kundenArray);

  } elseif (isset($_GET['firmen'])) {

    /**********************
     *  SETTINGS - FIRMEN
     *********************/

    $firmenQ = mysqli_query($dbhandle, "SELECT * FROM companies;") or die(mysqli_error($dbhandle));          //query

    $firmenArray = array();

    while($firmenResults = mysqli_fetch_assoc($firmenQ)) {
      $firmenArray[] = $firmenResults;
    }

    echo json_encode($firmenArray);

  } elseif (isset($_GET['dCID'])) {

    /**************************
     * INCOMING - dCID SHOW
     **************************/

    $dCID = $_GET['dCID'];

    $result = mysqli_query($dbhandle, "SELECT kunden.id, kunden.derenCID, kunden.unsereCID, companies.name, companies.maintenanceRecipient, maintenancedb.startDateTime, maintenancedb.endDateTime FROM kunden LEFT JOIN companies ON kunden.kunde = companies.id LEFT JOIN maintenancedb ON kunden.id = maintenancedb.derenCIDid WHERE kunden.derenCID LIKE '$dCID'") or die(mysqli_error($dbhandle));          //query

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['dKName'])) {

    /**************************
     * INCOMING - dCID SHOW
     **************************/

    $dCID = $_GET['dKName'];

    $result0 = mysqli_query($dbhandle, "SELECT companies.id FROM companies WHERE companies.name LIKE '$dCID'") or die(mysqli_error($dbhandle));

    if ($fetch = mysqli_fetch_array($result0)) {
        //Found a companyn - now show all maintenances for company
        $company_id = $fetch[0];
        $result = mysqli_query($dbhandle, "SELECT kunden.id, kunden.derenCID, kunden.unsereCID, companies.name FROM companies LEFT JOIN kunden ON companies.id = kunden.kunde WHERE companies.id LIKE '$company_id'") or die(mysqli_error($dbhandle));
    }

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_POST['data'])) {

    /**************************
     * ADDEDIT - ADD / UPDATE
     **************************/

    $fields=$_POST['data'];

    $addeditA = array();

    $omaintid = $fields[0]['omaintid'];
    $omaileingang = mysqli_real_escape_string($dbhandle, $fields[0]['omaileingang']);
    $oreceivedmail = mysqli_real_escape_string($dbhandle, $fields[0]['oreceivedmail']);
    $olieferant = mysqli_real_escape_string($dbhandle, $fields[0]['olieferant']);
    $olieferantid = mysqli_real_escape_string($dbhandle, $fields[0]['olieferantid']);
    $oderenCIDid = mysqli_real_escape_string($dbhandle, $fields[0]['oderenCIDid']);
    $obearbeitetvon = mysqli_real_escape_string($dbhandle, $fields[0]['obearbeitetvon']);
    $omaintenancedate = mysqli_real_escape_string($dbhandle, $fields[0]['omaintenancedate']);
    $ostartdatetime = mysqli_real_escape_string($dbhandle, $fields[0]['ostartdatetime']);
    $oenddatetime = mysqli_real_escape_string($dbhandle, $fields[0]['oenddatetime']);
    $opostponed = mysqli_real_escape_string($dbhandle, $fields[0]['opostponed']);
    $onotes = mysqli_real_escape_string($dbhandle, $fields[0]['onotes']);
    //$omailankunde = mysqli_real_escape_string($dbhandle, $fields[0]['omailankunde']);
    //$ocal = mysqli_real_escape_string($dbhandle, $fields[0]['ocal']);
    $odone = mysqli_real_escape_string($dbhandle, $fields[0]['odone']);
    $mailSentAt = mysqli_real_escape_string($dbhandle, $fields[0]['mailSentAt']);
    $update = $fields[0]['update'];
    $updatedBy = $fields[0]['updatedBy'];


    //$existingrmailA =
    if ($update == '1') {
      $resultx = mysqli_query($dbhandle, "UPDATE maintenancedb SET maileingang = '$omaileingang', receivedmail = '$oreceivedmail', bearbeitetvon = '$obearbeitetvon', lieferant = '$olieferantid', derenCIDid = '$oderenCIDid', maintenancedate = '$omaintenancedate', startDateTime = '$ostartdatetime', endDateTime = '$oenddatetime', postponed = '$opostponed', notes = '$onotes', mailSentAt = '$mailSentAt', updatedBy = '$updatedBy', done = '$odone' WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

      if ($resultx == 'TRUE'){
          $addeditA['updated'] = 1;
      } else {
          $addeditA['updated'] = 0;
      }
    } else {
      $existingrmailQ =  mysqli_query($dbhandle, "SELECT receivedmail, derenCIDid FROM maintenancedb WHERE receivedmail LIKE '$oreceivedmail'") or die(mysqli_error($dbhandle));
      if (mysqli_fetch_array($existingrmailQ)) {
        $addeditA['exist'] = 1;
      } else {
        $lastIDQ =  mysqli_query($dbhandle, "SELECT MAX(id) FROM maintenancedb") or die(mysqli_error($dbhandle));
        $fetchID = mysqli_fetch_array($lastIDQ);
        $lastID = $fetchID[0] + 1;

        $kundenQ = mysqli_query($dbhandle, "SELECT id FROM companies WHERE name LIKE '$olieferant' OR mailDomain LIKE '$olieferant'") or die(mysqli_error($dbhandle));
        if ($fetchK = mysqli_fetch_array($kundenQ)) {
          $olieferantid = $fetchK[0];
        } else {
          $kundenIQ = mysqli_query($dbhandle, "INSERT INTO companies (name, mailDomain) VALUES ('$olieferant', '$olieferant')") or die(mysqli_error($dbhandle));
        }

        $resultx = mysqli_query($dbhandle, "INSERT INTO maintenancedb (id, maileingang, receivedmail, bearbeitetvon, lieferant, derenCIDid, maintenancedate, startDateTime, endDateTime, postponed, notes, mailSentAt, updatedBy, done)
        VALUES ('$lastID', '$omaileingang', '$oreceivedmail', '$obearbeitetvon', '$olieferantid', '$oderenCIDid', '$omaintenancedate', '$ostartdatetime', '$oenddatetime', '$opostponed', '$onotes', '$mailSentAt', '$updatedBy', '$odone')")  or die(mysqli_error($dbhandle));

        if ($resultx == 'TRUE'){
            $addeditA['added'] = 1;
        } else {
            $addeditA['added'] = 0;
        }

      }
    }
    echo json_encode($addeditA);

  } else {

    echo json_encode('fukc you');

  }
?>
