<?php
$access_token = "EAAW7WGohZAmYBANJN9LntYxPHcA4R5cD3zEorxr1lZANcAZCWvz5XxJZBPArk6EVEKozF89JJCF0EAs8eIOIFJU01Ms5RkEmFj5IzXar02vk0CDDhfM3OHNuIUYUxFC8QDIxDyhY8xg8aMKx1a2Ypy93TlfOE6IfxtRBSV38FQZDZD";
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$messaging = $json_object->entry{0}->messaging{0};

if(isset($messaging->message)) {
    $id = $messaging->sender->id;
    $message = $messaging->message->text;
    $answer =  $message.'ふぁ嗚呼ああああああああああああああああああああああああああ亜ああああああああああああああああああああああああ';

    $post = <<< EOM
    {
        "recipient":{
            "id":"{$id}"
        },
        "message":{
            "text":"{$answer}"
        }
    }
EOM;
    api_send_request($access_token, $post);
}

function api_send_request($access_token, $post) {
    error_log("api_get_message_content_request start");
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token={$access_token}";
    $headers = array(
            "Content-Type: application/json"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);
    
}
