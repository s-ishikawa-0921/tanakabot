<?php
$access_token = "EAAY6yfqkwFgBAOc0iiU7fVzho2WAznZCQEsMGjyuZBxHj14KKWhclfc7QZB52nOQCpCjki8jwAGelqFSrBKXvSLyg2wmyWNnUkrWLIwey3boa6fX0HFQBgZBwkPBrfR9WmhSwLovVhwOKi2c2ATNHbLMuZC38Hk2bIpDcZCcMVVQZDZD";
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$messaging = $json_object->entry{0}->messaging{0};

if(isset($messaging->message)) {
    $id = $messaging->sender->id;
    $message = $messaging->message->text;
    $answer =  $message.'田中さん神';

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
