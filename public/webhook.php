<?php

require_once '../vendor/autoload.php';

use Google\Cloud\Core\Exception\AbortedException;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\MessageSentReport;

include_once "base.php";
include_once "config.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=configs/maintenanceapp-1dd9507b2c22.json');

$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("gmailMsg.txt","\n\n",FILE_APPEND);
file_put_contents("gmailMsg.txt",json_encode($data),FILE_APPEND);
$jsonencoded = json_encode($data);
//file_put_contents("webhookphp2.txt",$jsonencoded,FILE_APPEND);

$b64decoded = base64_decode($data['message']['data']);
file_put_contents("gmailMsg.txt","\n\n",FILE_APPEND);
file_put_contents("gmailMsg.txt",$b64decoded,FILE_APPEND);
$jsondecodedMessage = json_decode($b64decoded,true);

//file_put_contents("gmailMsg.txt","\n",FILE_APPEND);
//file_put_contents("gmailMsg.txt",$jsondecodedMessage,FILE_APPEND);
$historyid =  $jsondecodedMessage['historyId'];
//file_put_contents("gmailMsg.txt","\n",FILE_APPEND);
//file_put_contents("gmailMsg.txt",$historyid,FILE_APPEND);

//file_put_contents("webhookphp2.txt","\n\n",FILE_APPEND);
// to-do get gmail history id from data base64 encoded, 
// then insert incoming to new db table
// then push it into dynamically create js
// to push as notification to all clients

header("HTTP/1.1 202 OK");
//var_dump(http_response_code(202));
function getHeader($headers, $name) {
    foreach ($headers as $header) {
        if ($header['name'] == $name) {
            return $header['value'];
        }
    }
}

function getGoogleClient() {
    return getServiceAccountClient();
}

function getServiceAccountClient() {
  //$user = 'ndomino@newtelco.de';
    global $user;

    try {
        // Create and configure a new client object.
        $client2 = new Google_Client();
        $client2->useApplicationDefaultCredentials();
        $client2->setScopes(['https://mail.google.com/','https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.modify','https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/gmail.metadata','https://www.googleapis.com/auth/gmail.labels']);
        //$client2->setAccessType('offline');
        $client2->setSubject('fwaleska@newtelco.de');
        return $client2;
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

$clientService = getGoogleClient();
$gmailService = new Google_Service_Gmail($clientService);

// TODO: latest historyId doesnt return anything because there is nothing before it, only second to last does, for example. So I need to store the second to last everytime and grab those details?

// setcookie('lastHistoryID',$historyid,time()+60*60*24*1);

$lastHistoryFile = file_get_contents('lastHistoryId.txt');
file_put_contents("lastHistoryId.txt",$historyid);
if($lastHistoryFile !== '') {
  $historyid = $lastHistoryFile;
}
// $history1 = $historyid;
// $startHistoryId = $history1;

function listHistory($service, $userId, $startHistoryId) {
    $opt_param = array('startHistoryId' => $startHistoryId, 'labelId' => 'Label_2565420896079443395');
    $pageToken = NULL;
    $histories = array();
  
    do {
      try {
        if ($pageToken) {
          $opt_param['pageToken'] = $pageToken;
        }
        $historyResponse = $service->users_history->listUsersHistory($userId, $opt_param);
        var_dump(json_encode($historyResponse));
        // file_put_contents("lastHistoryId_Resp.txt",$historyResponse);
        if ($historyResponse->getHistory()) {
          $histories = array_merge($histories, $historyResponse->getHistory());
          $pageToken = $historyResponse->getNextPageToken();
        }
      } catch (Exception $e) {
        print 'An error occurred: ' . $e->getMessage();
      }
    } while ($pageToken);
  
    return $histories;
  }

file_put_contents("gmailMsg.txt","\n\n",FILE_APPEND);
$listMessageArray = array();
//file_put_contents("gmailMsg.txt",json_encode($listMessageArray),FILE_APPEND);
$listHistory = listHistory($gmailService,'fwaleska@newtelco.de',$historyid);
var_dump($listHistory);
for($i=0;$i<sizeof($listHistory);$i++){
    $listMessages = $listHistory[$i]->messages;
    $listMessage = $listMessages[0]->id;
    //file_put_contents("gmailMsg.txt","\n".json_encode($listMessage),FILE_APPEND);
    array_push($listMessageArray,$listMessage);
}
$listMessageArray = array_unique($listMessageArray);
file_put_contents("gmailMsg.txt","\n".json_encode($listMessageArray),FILE_APPEND);


$optParamsMsg['format'] = 'metadata';
if(sizeof($listMessageArray) > 0) {
  $countLength = max(array_keys($listMessageArray));
  $single_message = $gmailService->users_messages->get('fwaleska@newtelco.de',$listMessageArray[$countLength],$optParamsMsg);

  file_put_contents("gmailMsg.txt",$listMessageArray[$countLength],FILE_APPEND);

  $payload = $single_message->getPayload();
  $headers = $payload->getHeaders();
  $snippet = $single_message->getSnippet();
  $date = json_encode(getHeader($headers, 'Date'));
  $subject = json_encode(getHeader($headers, 'Subject'));
  $from = json_encode(getHeader($headers, 'From'));

  $output = 'Date: ' . $date . ' | Subject: ' . $subject . ' | From: ' . $from;
  //var_dump($output);
}
// file_put_contents("webhookphp2.txt",$listHistory,FILE_APPEND);
// var_dump($listHistory);


$getUsersToNotifyQuery = mysqli_query($dbhandle, "SELECT DISTINCT username FROM notificationSubs;") or die(mysqli_error($dbhandle));

while($getUsersArray = mysqli_fetch_assoc($getUsersToNotifyQuery)) {
  if(is_null($getUserArray)) {
    $notifyUsers = [];
  } else {
    $notifyUsers[] = $getUsersArray;
  }
}

// var_dump($notifyUsers);
for($i=0;$i < sizeof($notifyUsers);$i++) {
  $username = $notifyUsers[$i];
  // var_dump($username);
  $userNotifyDetailsQuery = mysqli_query($dbhandle, "SELECT endpoint, p256dh, auth FROM notificationSubs ;") or die (mysqli_error($dbhandle));
  $userNotifyDetails = mysqli_fetch_assoc($userNotifyDetailsQuery);

  $vapidpriv = '47EHLIK8B0qEK7stCiGipjURVHZg0XSLRn0c9rqlF5s';
  $vapidpub = 'BOoj1c6teeX075bCUjVA3K0LVrDxSTM2eQKjjV_DDDQohscn7wzzrPKRizkzqI2vlodUuKHOUJGXsibl6A5nCVA';
  $authKeys = array(
    'VAPID' => array(
        'subject' => 'mailto:ndomino@newtelco.de',
        'publicKey' => $vapidpub,
        //file_get_contents(__DIR__ . '/../keys/public_key.txt'), // don't forget that your public key also lives in app.js
        'privateKey' => $vapidpriv,
        //file_get_contents(__DIR__ . '/../keys/private_key.txt'), // in the real world, this would be in a secret file
    ),
    'ttl' => 120
  );

  // var_dump($userNotifyDetailsQuery);
  $endpoint = $userNotifyDetails['endpoint'];
  $p256dh = $userNotifyDetails['p256dh'];
  $auth = $userNotifyDetails['auth'];

  // var_dump($endpoint);
  // var_dump($p256dh);
  // var_dump($auth);

  $notification = 
  [
    'subscription' => Subscription::create([ 
    "endpoint" => $endpoint,
        "keys" => [
            'p256dh' => $p256dh,
            'auth' => $auth
        ],
    ]),
    'payload' => '{
      "title":"' . $subject . '",
      "body":"' . $from . '",
      "tag":"nt-maint"
    }',
    //  took this out of title for now - (' . $date . ')",
  ];

  // var_dump($notification);
  // var_dump($authKeys);

  // TODO: send webpush only when, i.e. "Subject" != ''
  if($subject != '') {
    $webPush = new WebPush($authKeys);
    // var_dump($webPush);
    $sent = $webPush->sendNotification(
      $notification['subscription'],
      $notification['payload'], // optional (defaults null)
      true // optional (defaults false)
    );
    foreach ($webPush->flush() as $report) {
      $endpoint = $report->getRequest()->getUri()->__toString();

      if ($report->isSuccess()) {
          echo "[v] Message sent successfully for subscription {$endpoint}.";
      } else {
          echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
      }
    }
  }
  // var_dump($sent);
}

?>