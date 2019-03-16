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

  function checkCompanyExist($companyName,$dbhandle) {
    $companyName = trim($companyName);
    $kundenQ = mysqli_query($dbhandle, "SELECT id FROM companies WHERE name LIKE '$companyName'") or die(mysqli_error($dbhandle));
    if ($fetchK = mysqli_fetch_array($kundenQ)) {
      $companyID = $fetchK[0];
      return $companyID;
    } else {
      $kundenIQ = mysqli_query($dbhandle, "INSERT INTO companies (name) VALUES ('$companyName')") or die(mysqli_error($dbhandle));
      return '0';
    }
  }

  if (isset($_GET['kunden'])) {

    /**********************
     * SETTINGS - KUNDEN
     *********************/

    $kundenQ = mysqli_query($dbhandle, "SELECT kundenCID.id, kundenCID.kundenCID, kundenCID.protected, lieferantCID.derenCID, companies.name FROM kundenCID LEFT JOIN companies ON kundenCID.kunde = companies.id LEFT JOIN lieferantCID ON kundenCID.lieferantCID = lieferantCID.id") or die(mysqli_error($dbhandle));

    $kundenArray = array();

    while($kundenResults = mysqli_fetch_assoc($kundenQ)) {
      $kundenArray[] = $kundenResults;
    }

    echo json_encode($kundenArray);

  } elseif (isset($_GET['updateFirmen'])) {

    /***************************
     * SETTINGS - UPDATE FIRMEN
     ***************************/
    $firmenID = mysqli_real_escape_string($dbhandle,$_GET['id']);
    $firmenName = mysqli_real_escape_string($dbhandle,$_GET['name']);
    $firmenMailDomain = mysqli_real_escape_string($dbhandle,$_GET['mailDomain']);
    $firmenMaintenanceRecipient = mysqli_real_escape_string($dbhandle,$_GET['maintenanceRecipient']);

    $kundenQ = mysqli_query($dbhandle, "UPDATE companies SET companies.name = '" . $firmenName . "', companies.mailDomain = '" . $firmenMailDomain . "', companies.maintenanceRecipient = '" . $firmenMaintenanceRecipient . "' WHERE companies.id like '$firmenID'") or die(mysqli_error($dbhandle));

    if ($kundenQ == 'TRUE'){
      $hideResults['updated'] = 1;
    } else {
      $hideResults['updated'] = 0;
    }

    echo json_encode($hideResults);

  } elseif (isset($_GET['rmReschedule'])) {

    /***************************
     * SETTINGS - UPDATE FIRMEN
     ***************************/
    $rescheduleNum = mysqli_real_escape_string($dbhandle,$_GET['rmReschedule']);
    $activeMID = mysqli_real_escape_string($dbhandle,$_GET['mid']);

    $rid = 'NT'.$activeMID.'_'.$rescheduleNum;

    $removeRsQuery = mysqli_query($dbhandle, "UPDATE reschedule SET reschedule.active = '0' WHERE reschedule.rid like '$rid'") or die(mysqli_error($dbhandle));

    if ($removeRsQuery == 'TRUE'){
      $rmResults['removed'] = 1;
    } else {
      $rmResults['removed'] = 0;
    }

    echo json_encode($rmResults);

  } elseif (isset($_GET['mRead'])) {

    /***************************
     * INCOMING (DELETE) - MARK AS READ
     **************************/

    $mID_read = mysqli_real_escape_string($dbhandle,$_GET['mRead']);

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

    $doneVal = mysqli_real_escape_string($dbhandle,$_GET['d']);
    $msaVal = mysqli_real_escape_string($dbhandle,$_GET['msa']);
    $mid = mysqli_real_escape_string($dbhandle,$_GET['id']);
    $rmail = mysqli_real_escape_string($dbhandle,$_GET['gid']);

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

  } elseif (isset($_GET['updateLieferanten'])) {

    /**************************
     * UPDATE LIEFERANTEN  
     *************************/

    $id = mysqli_real_escape_string($dbhandle, $_GET['id']);
    $name = mysqli_real_escape_string($dbhandle, $_GET['name']);
    $derenCID = mysqli_real_escape_string($dbhandle, $_GET['derenCID']);

    $firmenQ1 = mysqli_query($dbhandle, "SELECT companies.id, companies.name FROM companies WHERE companies.name LIKE '".$name."';") or die(mysqli_error($dbhandle));   
     
    $firmenArray2 = array();
     
    while($firmenResults = mysqli_fetch_array($firmenQ1)) {
      $firmenArray2[] = $firmenResults;
    }
     
    $selectedCompanyID = $firmenArray2[0][0];

    $firmenQ2 = mysqli_query($dbhandle, "UPDATE lieferantCID SET lieferantCID.lieferant = '" . $selectedCompanyID . "', lieferantCID.derenCID = '" . $derenCID . "' WHERE lieferantCID.id like '$id'") or die(mysqli_error($dbhandle));

    if ($firmenQ2 == 'TRUE'){
      $lieferantResults['updated'] = 1;
    } else {
      $lieferantResults['updated'] = 0;
    }

    echo json_encode($lieferantResults);


  } elseif (isset($_GET['updateKunden'])) {

    /**************************
     * UPDATE KUNDEN  
     *************************/
    
    $id = mysqli_real_escape_string($dbhandle, $_GET['id']);
    $name = mysqli_real_escape_string($dbhandle, $_GET['name']);
    $kundenCID = mysqli_real_escape_string($dbhandle, $_GET['kundenCID']);
    $protected = mysqli_real_escape_string($dbhandle, $_GET['protected']);
    $derenCID = mysqli_real_escape_string($dbhandle, $_GET['derenCID']);
    
    if ($protected == 'Protected') {
      $protected = "1";
    } elseif ($protected == "Unprotected") {
      $protected = "0";
    } else {
      $protected = "";
    }

    // Select company ID based on name

    $kundenQ1 = mysqli_query($dbhandle, "SELECT companies.id FROM companies WHERE companies.name LIKE '".$name."';") or die(mysqli_error($dbhandle));   
     
    $kundenArray2 = array();
     
    while($kundenResults1 = mysqli_fetch_array($kundenQ1)) {
      $kundenArray2[] = $kundenResults1;
    }
     
    $selectedCompanyID = $kundenArray2[0][0];

    // select lieferantID based on name 

    $kundenQ3 = mysqli_query($dbhandle, "SELECT lieferantCID.id FROM lieferantCID WHERE lieferantCID.derenCID LIKE '".$derenCID."';") or die(mysqli_error($dbhandle));   
     
    $kundenArray3 = array();
     
    while($kundenResults2 = mysqli_fetch_array($kundenQ3)) {
      $kundenArray3[] = $kundenResults2;
    }
     
    $selectedLieferantID = $kundenArray3[0][0];

    $kundenQ4 = mysqli_query($dbhandle, "UPDATE kundenCID SET kundenCID.lieferantCID = '" . $selectedLieferantID . "', kundenCID.kunde = '" . $selectedCompanyID . "', kundenCID.protected = '" . $protected . "', kundenCID.kundenCID = '" . $kundenCID . "' WHERE kundenCID.id like '$id'") or die(mysqli_error($dbhandle));

    if ($kundenQ4 == 'TRUE'){
      $kundenResults['updated'] = 1;
    } else {
      $kundenResults['updated'] = 0;
    }

    echo json_encode($kundenResults);

  } elseif (isset($_GET['dCID'])) {

    /*****************************************
     * ADDEDIT - dCID SHOW LIST OF KundenCID
     *****************************************/

    $dCID = mysqli_real_escape_string($dbhandle, $_GET['dCID']);
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

    $mid = mysqli_real_escape_string($dbhandle, $_GET['mid']);
    
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

    $result = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.startDateTime as 'start', maintenancedb.endDateTime as 'end', companies.name as 'content', maintenancedb.betroffeneKunden as 'title' FROM maintenancedb LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.done = '1' AND maintenancedb.cancelled = '0' AND maintenancedb.active = '1' AND (DATE_SUB(NOW(), INTERVAL 14 DAY)) < maintenancedb.startDateTime;") or die(mysqli_error($dbhandle));

    $array2 = array();

    while($resultsrows = mysqli_fetch_assoc($result)) {
      $array2[] = $resultsrows;
    }

    echo json_encode($array2);

  } elseif (isset($_GET['completedLine'])) {

    /*****************************************
     * INDEX - get line chart data
     *****************************************/

    $result = mysqli_query($dbhandle, "SELECT id, bearbeitetvon, DATE(updatedAt) as day FROM maintenancedb WHERE maintenancedb.done LIKE '1' AND DATE(maileingang) >= curdate() - INTERVAL DAYOFWEEK(curdate())+14 DAY ORDER BY id desc") or die(mysqli_error($dbhandle));

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

  } elseif (isset($_GET['overview'])) {
    
    $overviewQuery = mysqli_query($dbhandle, "SELECT maintenancedb.id, maintenancedb.maileingang, maintenancedb.receivedmail, companies.name, lieferantCID.derenCID, maintenancedb.bearbeitetvon, maintenancedb.betroffeneKunden, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.postponed, maintenancedb.notes, maintenancedb.mailSentAt, maintenancedb.updatedAt, maintenancedb.betroffeneCIDs, maintenancedb.done, maintenancedb.cancelled, companies.mailDomain FROM maintenancedb LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id LEFT JOIN companies ON maintenancedb.lieferant = companies.id WHERE maintenancedb.active = 1") or die (mysqli_error($dbhandle));

    $overviewArray = array();

    while($resultsrows = mysqli_fetch_assoc($overviewQuery)) {
      $overviewArray[] = $resultsrows;
    }

    echo json_encode($overviewArray);
    
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

    $result = mysqli_query($dbhandle, "SELECT id, bearbeitetvon, DATE(updatedAt) as day FROM maintenancedb WHERE maintenancedb.active LIKE '1' AND maintenancedb.done LIKE '1' ;") or die(mysqli_error($dbhandle));

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

    $liefDomain = mysqli_real_escape_string($dbhandle, $_GET['liefName']);

    $result0 = mysqli_query($dbhandle, "SELECT companies.id FROM companies WHERE companies.mailDomain LIKE '$liefDomain'") or die(mysqli_error($dbhandle));

    if ($fetch = mysqli_fetch_array($result0)) {
      //Found a company - now show all maintenances for company
      $company_id = $fetch[0];
      $result = mysqli_query($dbhandle, "SELECT maintenancedb.maileingang, maintenancedb.startDateTime, maintenancedb.endDateTime, maintenancedb.done, maintenancedb.id, maintenancedb.receivedmail, maintenancedb.betroffeneCIDs, lieferantCID.derenCID, companies.name FROM maintenancedb LEFT JOIN companies ON maintenancedb.lieferant = companies.id LEFT JOIN lieferantCID ON maintenancedb.derenCIDid = lieferantCID.id WHERE maintenancedb.lieferant LIKE '$company_id' AND maintenancedb.active = '1';") or die(mysqli_error($dbhandle));

        $array2 = array();

        while ($resultsrows = mysqli_fetch_assoc($result)) {
          $array2[] = $resultsrows;
        }
        echo json_encode($array2);

    } else {
      $jsonArrayObject = array(array('maileingang' => 'no such company in DB yet', 'startDateTime' => 'no such company in DB yet', 'endDateTime' => '', 'done' => '', 'id' => '', 'receivedmail' => '','betroffeneCIDs' => '','derenCID'=>'', 'name' => ''));
      echo json_encode($jsonArrayObject);
      exit;
    }
  } elseif (isset($_GET['addSub'])){
    $data = file_get_contents("php://input");
    $jsonData = json_decode($data, true);
    
    $user = mysqli_real_escape_string($dbhandle, $_GET['user']);
    $endpoint = $jsonData['endpoint'];
    $p256dh = $jsonData['keys']['p256dh'];
    $auth = $jsonData['keys']['auth'];

    $checkUserQuery = mysqli_query($dbhandle, "SELECT username FROM notificationSubs WHERE username LIKE '$user';");

    if(mysqli_fetch_array($checkUserQuery)) {
      $updateSubQuery = mysqli_query($dbhandle, "UPDATE notificationSubs SET endpoint = '$endpoint', p256dh = '$p256dh', auth = '$auth' WHERE username LIKE '$user';") or die (mysqli_error($dbhandle));
    } else {
      $insertSubQuery = mysqli_query($dbhandle, "INSERT INTO notificationSubs SET username = '$user', endpoint = '$endpoint', p256dh = '$p256dh', auth = '$auth';") or die(mysqli_error($dbhandle));
    }

  } elseif (isset($_GET['rmSub'])) {
    $user = mysqli_real_escape_string($dbhandle, $_GET['user']);

    $rmUserQuery = mysqli_query($dbhandle, "DELETE FROM notificationSubs WHERE username LIKE '$user';") or die (mysqli_error($dbhandle));

    $result = array();

    if($rmUserQuery == 1) {
      $result['removed'] = '1';
    } else {
      $result['removed'] = '0';
    }

    echo json_encode($result);
  
  } elseif (isset($_POST['data'])) {

    /**************************
     * ADDEDIT - ADD / UPDATE
     **************************/

    $fields=$_POST['data'];
    $rescheduleCount = sizeof($fields); 

    $addeditA = array();
    $addeditA['rescheduleCount'] = $rescheduleCount;

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
    $oloc = mysqli_real_escape_string($dbhandle, $fields[0]['oloc']);
    $oimp = mysqli_real_escape_string($dbhandle, $fields[0]['oimp']);
    $oreas = mysqli_real_escape_string($dbhandle, $fields[0]['oreas']);
    //$omailankunde = mysqli_real_escape_string($dbhandle, $fields[0]['omailankunde']);
    //$ocal = mysqli_real_escape_string($dbhandle, $fields[0]['ocal']);
    $onotes = mysqli_real_escape_string($dbhandle, $fields[0]['onotes']);
    $odone = mysqli_real_escape_string($dbhandle, $fields[0]['odone']);
    $cancelled = mysqli_real_escape_string($dbhandle, $fields[0]['cancelled']);
    $mailSentAt = mysqli_real_escape_string($dbhandle, $fields[0]['mailSentAt']);
    $mailDomain = mysqli_real_escape_string($dbhandle, $fields[0]['mailDomain']);
    $kundenCompanies = mysqli_real_escape_string($dbhandle, $fields[0]['kundenCompanies']);
    $kundenCIDs = mysqli_real_escape_string($dbhandle, $fields[0]['kundenCIDs']);

    $rescheduleCount = $rescheduleCount - 1;

    if($rescheduleCount > 0) {
      for($r=1;$r <= $rescheduleCount;$r++) {
        ${'rUser'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rUser']);
        // $rUser1 = mysqli_real_escape_string($dbhandle,$fields[$r]['rUser']);
        ${'rEditTime'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rEditTime']);
        ${'rSdt'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rSdt']);
        ${'rEdt'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rEdt']);
        ${'rReas'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rReas']);
        ${'rLoc'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rLoc']);
        ${'rImp'.$r} = mysqli_real_escape_string($dbhandle,$fields[$r]['rImp']);
      }
    }

    // $addeditA['rReas1'] = $rReas1;
    // $addeditA['rReas2'] = $rReas2;

    $update = mysqli_real_escape_string($dbhandle, $fields[0]['update']);
    $updatedBy = mysqli_real_escape_string($dbhandle, $fields[0]['updatedBy']);
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
      if(strpos($oreceivedmail,'NT-') === false){
        $service3 = new Google_Service_Gmail($clientService);
        modifyMessage($service3, "fwaleska@newtelco.de", $oreceivedmail, ["Label_2533604283317145521"], ["Label_2565420896079443395"]);
      }
    }

    if ($update == '1') {
      $resultx = mysqli_query($dbhandle, "UPDATE maintenancedb SET maileingang = '$omaileingang', receivedmail = '$oreceivedmail', bearbeitetvon = '$obearbeitetvon', lieferant = '$olieferantid', derenCIDid = '$oderenCIDid', startDateTime = '$ostartdatetime', endDateTime = '$oenddatetime', notes = '$onotes', reason = '$oreas', impact = '$oimp', location = '$oloc', mailSentAt = '$mailSentAt', updatedBy = '$updatedBy', betroffeneKunden = '$kundenCompanies', betroffeneCIDs = '$kundenCIDs', done = '$odone', cancelled = '$cancelled' WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

      $resultx2 = mysqli_query($dbhandle, "SELECT id FROM maintenancedb WHERE id LIKE '$omaintid'") or die(mysqli_error($dbhandle));

      if ($fetchID1 = mysqli_fetch_array($resultx2)) {
        $oupdatedID = $fetchID1[0];
      }
       
      // check if reschedule[$r] already exists for this maintenance
      $rescheduleCheckQ = mysqli_query($dbhandle, "SELECT MAX(reschedule.rcounter) FROM reschedule WHERE reschedule.maintenanceid LIKE '$omaintid'");
      $addeditA['omaintid'] = $omaintid;
      $fetchReschedule = mysqli_fetch_array($rescheduleCheckQ);
      $lastSavedRS = $fetchReschedule[0];

      if(!is_null($lastSavedRS)) {
        // reschedules exist for this maintenance, count then update
        // maintenance Resch. exists - lets check which ones..
        $addeditA['lastSavedRS'] = $lastSavedRS;

        for ($i=1;$i<=$lastSavedRS;$i++) {

          // TODO add RID
          $reschedRID = 'NT'.$omaintid.'_'.$i;
          $rescheduleUpdateQuery = mysqli_query($dbhandle, "UPDATE reschedule SET sdt = '${'rSdt'.$i}', edt = '${'rEdt'.$i}', reason = '${'rReas'.$i}', location = '${'rLoc'.$i}', impact = '${'rImp'.$i}' WHERE rid LIKE '$reschedRID';");
          $rescheduleUpdateQueryResults = mysqli_fetch_array($rescheduleUpdateQuery);
          $addeditA['rsuqr'] = $rescheduleUpdateQueryResults;
        }
        $addeditA['reschExists'] = 1;
      } else {
        // reschedules dont exist, insert them
        // update RID
        $rcounter = 1;
        $reschedRID = 'NT'.$omaintid.'_'.$rcounter;
        for ($i=0;$i<$rescheduleCount;$i++) {
          $rescheduleInsertQuery = mysqli_query($dbhandle, "INSERT INTO reschedule (rid,maintenanceid,rcounter,user,datetime,sdt,edt,reason,location,impact,active) VALUES ('$reschedRID','$omaintid','$rcounter','${'rUser'.$rcounter}','${'rEditTime'.$rcounter}','${'rSdt'.$rcounter}','${'rEdt'.$rcounter}','${'rReas'.$rcounter}','${'rLoc'.$rcounter}','${'rImp'.$rcounter}','1')");
          $rcounter = $rcounter + 1;
        }
        $addeditA['reschExists'] = 0;
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
        $olieferant = trim($olieferant);

        $olieferantid = checkCompanyExist($olieferant,$dbhandle);
        // $kundenQ = mysqli_query($dbhandle, "SELECT id FROM companies WHERE name LIKE '$olieferant'") or die(mysqli_error($dbhandle));
        // if ($fetchK = mysqli_fetch_array($kundenQ)) {
        //   $olieferantid = $fetchK[0];
        // } else {
        //   $kundenIQ = mysqli_query($dbhandle, "INSERT INTO companies (name, mailDomain) VALUES ('$olieferant', '$mailDomain')") or die(mysqli_error($dbhandle));
        // }

        $resultx = mysqli_query($dbhandle, "INSERT INTO maintenancedb (id, maileingang, receivedmail, bearbeitetvon, lieferant, derenCIDid, startDateTime, endDateTime, notes, mailSentAt, updatedBy, betroffeneKunden, betroffeneCIDs, done, cancelled, location, reason, impact)
        VALUES ('$lastID', '$omaileingang', '$oreceivedmail', '$obearbeitetvon', '$olieferantid', '$oderenCIDid', '$ostartdatetime', '$oenddatetime', '$onotes', '$mailSentAt', '$updatedBy', '$kundenCompanies', '$kundenCIDs', '$odone', '$cancelled', '$oloc', '$oreas', '$oimp')")  or die(mysqli_error($dbhandle));

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

    $selectedUser = mysqli_real_escape_string($dbhandle, $_GET['userMails']);
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
