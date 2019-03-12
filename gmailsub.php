<?php
    if(isset($token_data)) {
        $activeUser = $token_data['email'];
    } else {
        $activeUser = '';
    }
    $activeUser = strstr($activeUser, '@', TRUE);
    // $activeUser = 'yo';
    // pubsub (gmail push notifications)
    // Imports the Google Cloud client library
    use Google\Cloud\PubSub\PubSubClient;

    // Your Google Cloud Platform project ID
    $projectId = 'maintenanceapp-221917';

    # The name for the new topic
    $topicName = 'maintGmail';
    $debugpubsub = '  Nico Testing: ' . $activeUser;
    $credentialfile = "/var/www/html/maintenancedb/configs/maintenanceapp-1dd9507b2c22.json";

    $pubsub = new PubSubClient([
          'projectId' => $projectId,
          'keyFilePath' => "/var/www/html/maintenancedb/configs/maintenanceapp-1dd9507b2c22.json"
    ]);
    // Creates the new topic
    // $topic = $pubsub->createTopic($topicName);
    function create_subscription($pubsub, $topicName, $subscriptionName) {
      global $debugpubsub;

      $topic = $pubsub->topic($topicName);
      $subscription = $topic->subscription($subscriptionName);
      $subscription->create();

      $debugpubsub = $debugpubsub . 'Subscription created: ' . $subscription->name();
    }
    function list_topics($pubsub1) {
      global $debugpubsub;
      foreach ($pubsub1->topics() as $topic) {
        $debugpubsub = $debugpubsub . ' Topic: ' .$topic->name();
      }
    } 
    function list_subscriptions($pubsub1) {
        global $debugpubsub;
        $subsArray = array();
        foreach ($pubsub1->subscriptions() as $subscription) {
           array_push($subsArray,$subscription->name());
           // $debugpubsub = $debugpubsub . ' Subs: ' .$subscription->name();
        }
        return $subsArray;
    }
    // DEBUG
    // list_topics($pubsub);
    $subscriptionName = 'projects/maintenanceapp-221917/subscriptions/' .$activeUser.'sub';
    $subs = list_subscriptions($pubsub);

    if (in_array($subscriptionName,$subs)) {
        // already exists
        $debugpubsub = $debugpubsub . ' | Sub exists';
    } else {
        create_subscription($pubsub, $topicName, $subscriptionName);
    }

    function watch($serviceAcct) {
        $user = 'fwaleska@newtelco.de';
        $postBody = new Google_Service_Gmail_WatchRequest();
        $postBody->setTopicName('projects/maintenanceapp-221917/topics/maintGmail');
        $postBody->setLabelIds(array('Label_2565420896079443395'));
        $client_pubsub = new Google_Service_Gmail($serviceAcct);
        $watch = $client_pubsub->users->watch($user,$postBody);
        return $watch;
    }
    $watch = '';
    $messages = '';

    if(!isset($_COOKIE['pswatch'])){
        // watch 1x per day, set cookie when watch is called
        global $watch;
        $watch = watch($clientService);
        setcookie('pswatch','set',time()+60*60*24*1);
    }

    function getMessages($pubsub) {
        global $subscriptionName;
        $subscription = $pubsub->subscription($subscriptionName);
        $pullMessages = [];
        $messages = [];
        foreach ($subscription->pull(['returnImmediately' => true]) as $pullMessage) {
            $pullMessages[] = $pullMessage;
            $messages[] = $pullMessage->data();
        }
        // ack PULL
        if ($pullMessages) {
            $subscription->acknowledgeBatch($pullMessages);
        }
        return $messages;
    }

    $messages = getMessages($pubsub);

?>