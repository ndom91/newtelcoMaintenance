<?php

  require('authenticate_google.php');

  require_once('config.php');

  header('Content-Type: application/json');

  function modifyMessage($clientService, $userId, $messageId, $labelsToAdd, $labelsToRemove) {
    $mods = new Google_Service_Gmail_ModifyMessageRequest();
    //$mods = new Google_Service_Gmail_ModifyThreadRequest();
    $mods->setAddLabelIds($labelsToAdd);
    $mods->setRemoveLabelIds($labelsToRemove);
    try {
      $message = $clientService->users_messages->modify($userId, $messageId, $mods);
    } catch (Exception $e) {
      print 'An error occurred: ' . $e->getMessage();
    }
  }

  if (isset($_GET['kunden'])) {

    /**********************
     * SETTINGS - KUNDEN
     *********************/

     //var_dump($dbhandle);

    $kundenQ = mysqli_query($dbhandle, "SELECT kundenCID.kundenCID, companies.name FROM kundenCID LEFT JOIN companies ON kundenCID.kunde = companies.id") or die(mysqli_error($dbhandle));

    //var_dump($kundenQ);

    $kundenArray = array();


    while($kundenResults = mysqli_fetch_assoc($kundenQ)) {
      $kundenArray[] = $kundenResults;
      //var_dump($kundenArray);
    }

    echo json_encode($kundenArray);

  } elseif (isset($_GET['lieferanten'])) {

    /***************************
     * SETTINGS - LIEFERANTEN
     **************************/

    $lieferantenQ = mysqli_query($dbhandle, "SELECT companies.name, lieferantCID.derenCID  FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id") or die(mysqli_error($dbhandle));

    $lieferantenArray = array();

    while($lieferantenResults = mysqli_fetch_assoc($lieferantenQ)) {
      //var_dump($lieferantArray);
      $lieferantenArray[] = $lieferantenResults;
    }
    //var_dump($lieferantArray);
    //echo $lieferantArray[1];
    //$lieferantenArray = utf8_encode($lieferantenArray);
    echo json_encode($lieferantenArray);
    //var_dump(json_encode($lieferantArray));

  } elseif (isset($_GET['firmen'])) {

    /**************************
     * LOAD SETTINGS - FIRMEN
     *************************/

    $firmenQ = mysqli_query($dbhandle, "SELECT * FROM companies;") or die(mysqli_error($dbhandle));

    $firmenArray = array();

    while($firmenResults = mysqli_fetch_assoc($firmenQ)) {
      $firmenArray[] = $firmenResults;
    }

    echo json_encode($firmenArray);

  } elseif (isset($_GET['sfirmen'])) {

    /**************************
     * SAVE SETTINGS - FIRMEN
     *************************/

    // get existing state from DB
    $firmenQ1 = mysqli_query($dbhandle, "SELECT * FROM companies;") or die(mysqli_error($dbhandle));
    $firmenArray2 = array();
    while($firmenResults = mysqli_fetch_array($firmenQ1)) {
      $firmenArray2[] = $firmenResults;
    }

    // get new state from xhr request
    $request_body = file_get_contents('php://input');
    $data = array();
    $data = json_decode($request_body, true);
    $arraySize = sizeof($data);

    $updateArray = array();

    // loop through all rows (based on xhr row size) to compare db state to xhr data
    for ($row = 0; $row < $arraySize; $row++) {
      $idToSearch = $firmenArray2[$row][0];
      $keys = array_search($idToSearch, array_column($data, '0'));

      // check each row for changes, mark rows that have changes in $updateArray
      for ($col = 0; $col < 4; $col++) {
        $needsUpdate = 0;
        if ($firmenArray2[$row][$col] != $data[$keys][$col]) {
          array_push($updateArray,$data[$keys][0]);
        }
      }
    }

    // check if $updateArray has any queued changes, if so - commit them
    $arraySize2 = sizeof($updateArray);
    $updateFirmen = array();
    if ($arraySize2 > 0) {
      for ($i = 0; $i < $arraySize2; $i++) {
        $row = $updateArray[$i];
        $row2 = array_search($row, array_column($data, '0'));
        $updateQ = 'UPDATE companies SET name = "' . $data[$row2][1] . '",  mailDomain = "' . $data[$row2][2] . '", maintenanceRecipient = "' . $data[$row2][3] . '" WHERE id LIKE "' . $data[$row2][0] . '"';
        $firmenQ2 = mysqli_query($dbhandle, $updateQ) or die(mysqli_error($dbhandle));
        if ($firmenQ2 == 'TRUE'){
          $updateFirmen['updated'] = $updateFirmen['updated'] + 1;
        }
      }
      echo json_encode($updateFirmen);
    } else {
      $updateFirmen['updated'] = -1;
      echo json_encode($updateFirmen);
    }

  } elseif (isset($_GET['dCID'])) {

    /*****************************************
     * ADDEDIT - dCID SHOW LIST OF KundenCID
     *****************************************/

    $dCID = $_GET['dCID'];

    $result = mysqli_query($dbhandle, "SELECT kundenCID.kundenCID, companies.name, kundenCID.kunde, companies.maintenanceRecipient FROM kundenCID LEFT JOIN companies ON kundenCID.kunde = companies.id LEFT JOIN lieferantCID ON lieferantCID.id = kundenCID.lieferantCID WHERE lieferantCID.derenCID LIKE '$dCID'") or die(mysqli_error($dbhandle));

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['timeline'])) {

    /*****************************************
     * OVERVIEW - get timeline data
     *****************************************/

    $result = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.startDateTime as 'start', maintenancedb.endDateTime as 'end', companies.name as 'content', maintenancedb.notes as 'title' FROM maintenancedb LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.done = '1'") or die(mysqli_error($dbhandle));

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['liefName'])) {

    /**************************************
     * INCOMING - liefName SHOW MAINTENANCES
     **************************************/

    $liefDomain = $_GET['liefName'];

    $result0 = mysqli_query($dbhandle, "SELECT companies.id FROM companies WHERE companies.mailDomain LIKE '$liefDomain'") or die(mysqli_error($dbhandle));

    if ($fetch = mysqli_fetch_array($result0)) {
      //Found a company - now show all maintenances for company
      $company_id = $fetch[0];
      $result = mysqli_query($dbhandle, "SELECT maintenancedb.maileingang, maintenancedb.startDateTime, maintenancedb.done, maintenancedb.id, maintenancedb.receivedmail FROM maintenancedb WHERE maintenancedb.lieferant LIKE '$company_id'") or die(mysqli_error($dbhandle));

        $array2 = array();

        while ($resultsrows = mysqli_fetch_assoc($result)) {
          $array2[] = $resultsrows;
        }
        echo json_encode($array2);

    } else {
      $jsonArrayObject = array(array('maileingang' => 'no such company in DB yet', 'startDateTime' => '', 'done' => '', 'id' => '', 'receivedmail' => ''));
      echo json_encode($jsonArrayObject);
      exit;
    }

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
    //$omaintenancedate = mysqli_real_escape_string($dbhandle, $fields[0]['omaintenancedate']);
    $ostartdatetime = mysqli_real_escape_string($dbhandle, $fields[0]['ostartdatetime']);
    $oenddatetime = mysqli_real_escape_string($dbhandle, $fields[0]['oenddatetime']);
    $opostponed = mysqli_real_escape_string($dbhandle, $fields[0]['opostponed']);
    $onotes = mysqli_real_escape_string($dbhandle, $fields[0]['onotes']);
    //$omailankunde = mysqli_real_escape_string($dbhandle, $fields[0]['omailankunde']);
    //$ocal = mysqli_real_escape_string($dbhandle, $fields[0]['ocal']);
    $odone = mysqli_real_escape_string($dbhandle, $fields[0]['odone']);
    $mailSentAt = mysqli_real_escape_string($dbhandle, $fields[0]['mailSentAt']);
    $mailDomain = mysqli_real_escape_string($dbhandle, $fields[0]['mailDomain']);
    $update = $fields[0]['update'];
    $updatedBy = $fields[0]['updatedBy'];
    $gmailLabelRemove = $fields[0]['gmailLabel'];
    $gmailLabelRemove_ar = ["$gmailLabelRemove"];
    if (isset($_SESSION['endlabel'])) {
      $gmailLabelAdd = $_SESSION['endlabel'];
    } else if(isset($_COOKIE['endlabel'])){
      $gmailLabelAdd = $_COOKIE['endlabel'];
    } else {
      $gmailLabelAdd = 'Choose \"complete\" label in settings!';
    }
    $gmailLabelAdd_ar = ["$gmailLabelAdd"];

    // label lookup: https://developers.google.com/gmail/api/v1/reference/users/labels/list

    if ($odone == '1') {
      $sUserQ2 = mysqli_query($dbhandle, "SELECT id, serviceuser FROM persistence WHERE id LIKE 0") or die(mysqli_error($dbhandle));
      if ($fetchUQ = mysqli_fetch_array($sUserQ2)) {
        $existingSelectedUser = $fetchUQ[1];
        $service3 = new Google_Service_Gmail($clientService);
        modifyMessage($service3, $existingSelectedUser, $oreceivedmail, [$gmailLabelAdd], [$gmailLabelRemove]);
      }
    }

    if ($update == '1') {
      $resultx = mysqli_query($dbhandle, "UPDATE maintenancedb SET maileingang = '$omaileingang', receivedmail = '$oreceivedmail', bearbeitetvon = '$obearbeitetvon', lieferant = '$olieferantid', derenCIDid = '$oderenCIDid', startDateTime = '$ostartdatetime', endDateTime = '$oenddatetime', postponed = '$opostponed', notes = '$onotes', mailSentAt = '$mailSentAt', updatedBy = '$updatedBy', done = '$odone' WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

      $resultx2 = mysqli_query($dbhandle, "SELECT id FROM maintenancedb WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

      if ($fetchID1 = mysqli_fetch_array($resultx2)) {
        $oupdatedID = $fetchID1[0];
      }

      if ($resultx == 'TRUE'){
          $addeditA['updated'] = 1;
          $addeditA['updatedID'] = $oupdatedID;
      } else {
          $addeditA['updated'] = 0;
          $addeditA['updatedID'] = '';
      }
    } else {
      $existingrmailQ =  mysqli_query($dbhandle, "SELECT receivedmail, derenCIDid FROM maintenancedb WHERE receivedmail LIKE '$oreceivedmail'") or die(mysqli_error($dbhandle));
      if (mysqli_fetch_array($existingrmailQ)) {
        $addeditA['exist'] = 1;
        $addeditA['updatedID'] = '';
      } else {
        $lastIDQ =  mysqli_query($dbhandle, "SELECT MAX(id) FROM maintenancedb") or die(mysqli_error($dbhandle));
        $fetchID = mysqli_fetch_array($lastIDQ);
        $lastID = $fetchID[0] + 1;

        $kundenQ = mysqli_query($dbhandle, "SELECT id FROM companies WHERE name LIKE '$olieferant'") or die(mysqli_error($dbhandle));
        if ($fetchK = mysqli_fetch_array($kundenQ)) {
          $olieferantid = $fetchK[0];
        } else {
          $kundenIQ = mysqli_query($dbhandle, "INSERT INTO companies (name, mailDomain) VALUES ('$olieferant', '$mailDomain')") or die(mysqli_error($dbhandle));
        }

        $resultx = mysqli_query($dbhandle, "INSERT INTO maintenancedb (id, maileingang, receivedmail, bearbeitetvon, lieferant, derenCIDid, startDateTime, endDateTime, postponed, notes, mailSentAt, updatedBy, done)
        VALUES ('$lastID', '$omaileingang', '$oreceivedmail', '$obearbeitetvon', '$olieferantid', '$oderenCIDid', '$ostartdatetime', '$oenddatetime', '$opostponed', '$onotes', '$mailSentAt', '$updatedBy', '$odone')")  or die(mysqli_error($dbhandle));

        if ($resultx == 'TRUE'){
            $addeditA['added'] = 1;
            $addeditA['updatedID'] = $lastID;
        } else {
            $addeditA['added'] = 0;
            $addeditA['updatedID'] = '';
        }

      }
    }
    echo json_encode($addeditA);

  } elseif (isset($_GET['userMails'])){

    /***************************
     * SETTINGS - SERVICE USER
     **************************/

    $selectedUser = $_GET['userMails'];
    $selectedUserOutput = array();

    if ($selectedUser != '') {
      $sUserQ = mysqli_query($dbhandle, "SELECT id, serviceuser FROM persistence WHERE id LIKE 0") or die(mysqli_error($dbhandle));

      if ($fetchUQ = mysqli_fetch_array($sUserQ)) {
        $existingSelectedUser = $fetchUQ[1];
        if ($existingSelectedUser == $selectedUser) {
          $selectedUserOutput['same'] = 1;
        } else {
          $sUserU = mysqli_query($dbhandle, "UPDATE persistence set serviceuser = '$selectedUser' where id like 0") or die(mysqli_error($dbhandle));
          $selectedUserOutput['updated'] = 1;
        }
      } else {
        $kundenIQ = mysqli_query($dbhandle, "INSERT INTO persistence (serviceuser) VALUES ('$selectedUser')") or die(mysqli_error($dbhandle));
      }
    } else {
      $selectedUserOutput['empty'] = 1;
    }

    echo json_encode($selectedUserOutput);

  } else {

    echo json_encode('fukc you');

  }
?>
