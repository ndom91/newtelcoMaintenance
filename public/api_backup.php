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

    $kundenQ = mysqli_query($dbhandle, "SELECT kundenCID.id, kundenCID.kundenCID, kundenCID.protected, companies.name FROM kundenCID LEFT JOIN companies ON kundenCID.kunde = companies.id") or die(mysqli_error($dbhandle));

    $kundenArray = array();

    while($kundenResults = mysqli_fetch_assoc($kundenQ)) {
      $kundenArray[] = $kundenResults;
    }

    echo json_encode($kundenArray);

  } elseif (isset($_GET['mRead'])) {

    /***************************
     * INCOMING (DELETE) - MARK AS READ
     **************************/

    $mID_read = $_GET['mRead'];

    $gmailLabelRemove1 = 'UNREAD';

    $service4 = new Google_Service_Gmail($clientService);

    $sUserQ3 = mysqli_query($dbhandle, "SELECT id, serviceuser FROM persistence WHERE id LIKE 0") or die(mysqli_error($dbhandle));
    if ($fetchUQ1 = mysqli_fetch_array($sUserQ3)) {
      $existingSelectedUser1 = $fetchUQ1[1];
      modifyMessage($service4, $existingSelectedUser1, $mID_read, [], [$gmailLabelRemove1]);
    } 

    echo json_encode('Done?');

  } elseif (isset($_GET['doneEvent'])) {

    /***************************
     * ADDEDIT - DONE SLIDER
     **************************/

    $doneVal = $_GET['d'];
    $msaVal = $_GET['msa'];
    $mid = $_GET['id'];
    $rmail = $_GET['gid'];

    $result = mysqli_query($dbhandle, "UPDATE maintenancedb SET maintenancedb.done = '" . $doneVal . "', maintenancedb.mailSentAt = '" . $msaVal . "' WHERE maintenancedb.id LIKE '$mid'") or die(mysqli_error($dbhandle));

    $service3 = new Google_Service_Gmail($clientService);
    modifyMessage($service3, "fwaleska@newtelco.de", $rmail, ["Label_2533604283317145521"], ["Label_2565420896079443395"]);
   

    if ($result == 'TRUE'){
      $doneResult['updated'] = 1;
    } else {
      $doneResult['updated'] = 0;
    }

    echo json_encode($doneResult);

  } elseif (isset($_GET['lieferanten'])) {

    /***************************
     * SETTINGS - LIEFERANTEN
     **************************/

    $lieferantenQ = mysqli_query($dbhandle, "SELECT lieferantCID.id, companies.name, lieferantCID.derenCID  FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id") or die(mysqli_error($dbhandle));

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
    if ($_GET['sfirmen'] == 1) {
      // sfirmen = 1 - FIRMEN

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
    } elseif ($_GET['sfirmen'] == 2) {
      // sfirmen = 2 - LIEFERANTEN

      // get existing state from DB
      $lieferantQ1 = mysqli_query($dbhandle, "SELECT lieferantCID.id, companies.name, lieferantCID.derenCID FROM lieferantCID LEFT JOIN companies  ON lieferantCID.lieferant = companies.id;") or die(mysqli_error($dbhandle));
      $lieferantArray2 = array();
      while($lieferantResults = mysqli_fetch_array($lieferantQ1)) {
        $lieferantArray2[] = $lieferantResults;
      }
      // get new state from xhr request
      $request_body = file_get_contents('php://input');
      $data = array();
      $data = json_decode($request_body, true);
      $arraySize = sizeof($data);

      $updateArray = array();

      // loop through all rows (based on xhr row size) to compare db state to xhr data
      for ($row = 0; $row < $arraySize; $row++) {
        $idToSearch = $lieferantArray2[$row][0];
        $keys = array_search($idToSearch, array_column($data, '0'));

        // check each row for changes, mark rows that have changes in $updateArray
        for ($col = 0; $col < 3; $col++) {
          $needsUpdate = 0;
          if ($lieferantArray2[$row][$col] != $data[$keys][$col]) {
            array_push($updateArray,$data[$keys][0]);
          }
        }
      }

      // check if $updateArray has any queued changes, if so - commit them
      $arraySize2 = sizeof($updateArray);
      $updateLieferant = array();
      if ($arraySize2 > 0) {
        for ($i = 0; $i < $arraySize2; $i++) {
          $row = $updateArray[$i];
          $row2 = array_search($row, array_column($data, '0'));
          //$updateQ = 'UPDATE lieferantCID SET name = "' . $data[$row2][1] . '",  mailDomain = "' . $data[$row2][2] . '", maintenanceRecipient = "' . $data[$row2][3] . '" WHERE id LIKE "' . $data[$row2][0] . '"';
          //$lieferantQ2 = mysqli_query($dbhandle, $updateQ) or die(mysqli_error($dbhandle));
          //if ($lieferantQ2 == 'TRUE'){
          //  $updateLieferant['updated'] = $updateLieferant['updated'] + 1;
          //}
        echo json_encode('lief updated: ' . $data[$row2][0]);
        }
      } else {
        $updateLieferant['updated'] = -1;
        echo json_encode('lief NOT updated: ' . $data);
      }


    }
  } elseif (isset($_GET['dCID'])) {

    /*****************************************
     * ADDEDIT - dCID SHOW LIST OF KundenCID
     *****************************************/

    $dCID = $_GET['dCID'];
    //var_dump($dCID);
    //$dCID = preg_replace("/#.*?\n/", "\n", $dCID);
    $dCID = str_replace(",","','",$dCID);

    $result = mysqli_query($dbhandle, "SELECT kundenCID.kundenCID, kundenCID.protected, companies.name, kundenCID.kunde, companies.maintenanceRecipient FROM kundenCID LEFT JOIN companies ON kundenCID.kunde = companies.id LEFT JOIN lieferantCID ON lieferantCID.id = kundenCID.lieferantCID WHERE lieferantCID.id IN ('$dCID')") or die(mysqli_error($dbhandle));

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['hider'])) {

    /*****************************************
     * OVERVIEW - maintenance hider
     *****************************************/

    $mid = $_GET['mid'];
    
    $result = mysqli_query($dbhandle, "UPDATE maintenancedb SET maintenancedb.active = '0' WHERE maintenancedb.id LIKE '$mid'") or die(mysqli_error($dbhandle));

    if ($result == 'TRUE'){
      $hideResults['updated'] = 1;
    } else {
      $hideResults['updated'] = 0;
    }

    echo json_encode($hideResults);

  } elseif (isset($_GET['timeline'])) {
    
    /*****************************************
     * OVERVIEW - get timeline data
     *****************************************/

    $result = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.startDateTime as 'start', maintenancedb.endDateTime as 'end', companies.name as 'content', maintenancedb.betroffeneKunden as 'title' FROM maintenancedb LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.done = '1' AND maintenancedb.cancelled = '0' AND maintenancedb.active = '1';") or die(mysqli_error($dbhandle));

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['completedLine'])) {

    /*****************************************
     * INDEX - get line chart data
     *****************************************/

    $result = mysqli_query($dbhandle, "SELECT id, bearbeitetvon, DATE(maileingang) as day FROM maintenancedb WHERE maintenancedb.done LIKE '1' AND DATE(maileingang) >= curdate() - INTERVAL DAYOFWEEK(curdate())+14 DAY ORDER BY day desc") or die(mysqli_error($dbhandle));

    $array3 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array3[] = $resultsrows;
    }

    echo json_encode($array3);
    
  } elseif (isset($_GET['sAddF'])) {

    /*****************************************
     * SETTINGS - ADD COMPANY
     *****************************************/

    $cName = mysqli_real_escape_string($dbhandle, $_GET['sAddF_n']);
    $cDomain = mysqli_real_escape_string($dbhandle, $_GET['sAddF_d']);
    $cRecipients = mysqli_real_escape_string($dbhandle, $_GET['sAddF_r']);
    $addedCompany = array();

    $result = mysqli_query($dbhandle, "INSERT INTO companies (companies.name, companies.mailDomain, companies.maintenanceRecipient) VALUES ('$cName', '$cDomain', '$cRecipients')") or die(mysqli_error($dbhandle));

    if ($result == 'TRUE'){
        $addedCompany['added'] = 1;
    } else {
        $addedCompany['added'] = 0;
    }

    echo json_encode($addedCompany);

  } elseif (isset($_GET['sAddL'])) {

    /*****************************************
     * SETTINGS - ADD Lieferant
     *****************************************/

    $lCompany = mysqli_real_escape_string($dbhandle, $_GET['sAddL_c']);
    $lCID = mysqli_real_escape_string($dbhandle, $_GET['sAddL_i']);
    $addedLieferant = array();

    $result = mysqli_query($dbhandle, "INSERT INTO lieferantCID (lieferant, derenCID) VALUES ('$lCompany', '$lCID')") or die(mysqli_error($dbhandle));

    if ($result == 'TRUE'){
        $addedLieferant['added'] = 1;
    } else {
        $addedLieferant['added'] = 0;
    }

    echo json_encode($addedLieferant);

  } elseif (isset($_GET['sAddK'])) {

    /*****************************************
     * SETTINGS - ADD Kunden
     *****************************************/

    $kCompany = mysqli_real_escape_string($dbhandle, $_GET['sAddK_c']);
    $kdCID= mysqli_real_escape_string($dbhandle, $_GET['sAddK_dc']);
    $kntCID = mysqli_real_escape_string($dbhandle, $_GET['sAddK_nt']);
    $kProt = mysqli_real_escape_string($dbhandle, $_GET['sAddK_p']);
    
    $addedKunden = array();

    $result = mysqli_query($dbhandle, "INSERT INTO kundenCID (lieferantCID, kundenCID, protected, kunde) VALUES ('$kdCID', '$kntCID','$kProt', '$kCompany')") or die(mysqli_error($dbhandle));

    if ($result == 'TRUE'){
        $addedKunden['added'] = 1;
    } else {
        $addedKunden['added'] = 0;
    }

    echo json_encode($addedKunden);

  } elseif (isset($_GET['aedCIDc'])) {

    /*****************************************
     * Add Edit - Get derenCID options
     *****************************************/

    $dCIDcompany = mysqli_real_escape_string($dbhandle, $_GET['aedCIDc']);

    $dCIDcompanyArray = array();

    $result = mysqli_query($dbhandle, "SELECT  lieferantCID.id as id, lieferantCID.derenCID as text FROM lieferantCID LEFT JOIN companies ON lieferantCID.lieferant = companies.id WHERE lieferantCID.lieferant LIKE '$dCIDcompany'") or die(mysqli_error($dbhandle));

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $dCIDcompanyArray[] = $resultsrows;
    }

    echo json_encode($dCIDcompanyArray);

  } elseif (isset($_GET['aedCIDc2'])) {

    /*****************************************
     * Add Edit - Get derenCID selected options
     *****************************************/

    $mid = mysqli_real_escape_string($dbhandle, $_GET['aedCIDc2']);

    $midArray = array();

    $result = mysqli_query($dbhandle, "SELECT maintenancedb.derenCIDid as id, lieferantCID.derenCID as text FROM maintenancedb LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id WHERE maintenancedb.id LIKE '$mid'") or die(mysqli_error($dbhandle));

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $midArray[] = $resultsrows;
    }

    echo json_encode($midArray);

  } elseif (isset($_GET['completedLine1'])) {

    /*****************************************
     * INDEX - get line chart data
     *****************************************/

    $result = mysqli_query($dbhandle, "SELECT id, bearbeitetvon, DATE(mailSentAt) as day FROM maintenancedb WHERE maintenancedb.active LIKE '1' AND maintenancedb.done LIKE '1';") or die(mysqli_error($dbhandle));

    $array3 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array3[] = $resultsrows;
    }

    echo json_encode($array3);

  } elseif (isset($_GET['companies'])) {

    /********************************************
     * SETTINGS - load companies column dropdown
     ********************************************/

    $result = mysqli_query($dbhandle, "SELECT companies.id, companies.name FROM companies;") or die(mysqli_error($dbhandle));

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
      $result = mysqli_query($dbhandle, "SELECT maintenancedb.maileingang, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.done, maintenancedb.id, maintenancedb.receivedmail, maintenancedb.betroffeneCIDs, companies.name FROM maintenancedb LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.lieferant LIKE '$company_id' AND maintenancedb.active = '1';") or die(mysqli_error($dbhandle));

        $array2 = array();

        while ($resultsrows = mysqli_fetch_assoc($result)) {
          $array2[] = $resultsrows;
        }
        echo json_encode($array2);

    } else {
      $jsonArrayObject = array(array('maileingang' => '', 'startDateTime' => '', 'endDateTime' => '', 'done' => '', 'id' => '', 'receivedmail' => '','betroffeneCIDs' => 'no such company in DB yet', 'name' => ''));
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
    $onotes = mysqli_real_escape_string($dbhandle, $fields[0]['onotes']);
    //$omailankunde = mysqli_real_escape_string($dbhandle, $fields[0]['omailankunde']);
    //$ocal = mysqli_real_escape_string($dbhandle, $fields[0]['ocal']);
    $odone = mysqli_real_escape_string($dbhandle, $fields[0]['odone']);
    $cancelled = mysqli_real_escape_string($dbhandle, $fields[0]['cancelled']);
    $mailSentAt = mysqli_real_escape_string($dbhandle, $fields[0]['mailSentAt']);
    $mailDomain = mysqli_real_escape_string($dbhandle, $fields[0]['mailDomain']);
    $kundenCompanies = mysqli_real_escape_string($dbhandle, $fields[0]['kundenCompanies']);
    $kundenCIDs = mysqli_real_escape_string($dbhandle, $fields[0]['kundenCIDs']);

    $update = $fields[0]['update'];
    $updatedBy = $fields[0]['updatedBy'];
    $gmailLabelRemove = $_COOKIE['label'];
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
      $service3 = new Google_Service_Gmail($clientService);
      modifyMessage($service3, "fwaleska@newtelco.de", $oreceivedmail, ["Label_2533604283317145521"], ["Label_2565420896079443395"]);
    }

    if ($update == '1') {
      $resultx = mysqli_query($dbhandle, "UPDATE maintenancedb SET maileingang = '$omaileingang', receivedmail = '$oreceivedmail', bearbeitetvon = '$obearbeitetvon', lieferant = '$olieferantid', derenCIDid = '$oderenCIDid', startDateTime = '$ostartdatetime', endDateTime = '$oenddatetime', postponed = '$opostponed', notes = '$onotes', mailSentAt = '$mailSentAt', updatedBy = '$updatedBy', betroffeneKunden = '$kundenCompanies', betroffeneCIDs = '$kundenCIDs', done = '$odone', cancelled = '$cancelled' WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

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

        $resultx = mysqli_query($dbhandle, "INSERT INTO maintenancedb (id, maileingang, receivedmail, bearbeitetvon, lieferant, derenCIDid, startDateTime, endDateTime, notes, mailSentAt, updatedBy, betroffeneKunden, betroffeneCIDs, done, cancelled)
        VALUES ('$lastID', '$omaileingang', '$oreceivedmail', '$obearbeitetvon', '$olieferantid', '$oderenCIDid', '$ostartdatetime', '$oenddatetime', '$onotes', '$mailSentAt', '$updatedBy', '$kundenCompanies', '$kundenCIDs', '$odone', '$cancelled')")  or die(mysqli_error($dbhandle));

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
