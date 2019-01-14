<?php

require('authenticate_google.php');

function getAttachment($messageId, $partId, $userId) {
    global $clientService;
    try {
        $gmail = new Google_Service_Gmail($clientService);
        $message = $gmail->users_messages->get($userId, $messageId);
        $message_payload_details = $message->getPayload()->getParts();
        $attachmentDetails = array();
        $attachmentDetails['attachmentId'] = $message_payload_details[$partId]['body']['attachmentId'];
        $attachmentDetails['headers'] = $message_payload_details[$partId]['headers'];
        $attachment = $gmail->users_messages_attachments->get($userId, $messageId, $attachmentDetails['attachmentId']);
        $attachmentDetails['data'] = $attachment->data;
        return ['status' => true, 'data' => $attachmentDetails];
    } catch (\Google_Service_Exception $e) {
        return ['status' => false, 'message' => $e->getMessage()];
    }
}

    function base64_to_jpeg($base64_string, $content_type) {
        $find = ["_","-"]; $replace = ["/","+"];
        $base64_string = str_replace($find,$replace,$base64_string);
        $url_str = 'data:'.$content_type.','.$base64_string;
        $base64_string = "url(".$url_str.")";
        $data = explode(',', $base64_string);
        return base64_decode( $data[ 1 ] );
    }

    // Get the API client and construct the service object.
    $service = new Google_Service_Gmail($clientService);
    $opt_param = array();
    $opt_param['labelIds'] =  'INBOX';
    $opt_param['maxResults'] = 1;
    $messages = $service->users_messages->listUsersMessages($user, $opt_param);

    foreach ($messages as $message_thread) {
            $message = $service->users_messages->get($user, $message_thread['id']);
            $message_parts = $message->getPayload()->getParts();
            $files = array();
            $attachId = $message_parts[1]['body']['attachmentId'];
            $attach = $service->users_messages_attachments->get($user, $message['id'], $attachId);
            foreach ($message_parts as $key => $value) {
                if ( isset($value->body->attachmentId) && !isset($value->body->data)) {
                  array_push($files, $value['partId']);
                }
            }   
    }

    if (isset($_GET['messageId']) && $_GET['part_id']){ // This is After Clicking an Attachment
        $attachment = getAttachment($_GET['messageId'], $_GET['part_id'], $user);
        $content_type = "";
        foreach ($attachment['data']['headers'] as $key => $value) {
            if($value->name == 'Content-Type'){ $content_type = $value->value; }
            header($value->name.':'.$value->value);
        }
        $content_type_val = current(explode("/",$content_type));
        $media_types = ["video", "image", "application"];
        if(in_array($content_type_val, $media_types )){
            echo base64_to_jpeg($attachment['data']['data'], $content_type); // Only for Image files
        } else {
          echo base64_decode($attachment['data']['data']); // Other than Image Files
        }
    } else { // Listing All Attachments
            if(!empty($files)) {
                foreach ($files as $key => $value) {
                   // echo '<a target="_blank" href="getAttachments.php?messageId='.$message['id'].'&part_id='.$value.'">Attachment '.($key+1).'</a><br/>';
                }
            }

    }

?>