<?php
$access_token = "EAAHGrligKQYBAK9SqED7NHBrsKZCjaMiOyrUDmn2kBaLbFRaDMbtqO8rWaoM5JH1lP3HOPBq4brATUy0LunQZBJZB3qpKyA6lK7HGBYePS0jwVmf1R9IpXV6lyaQtA0ZByNHcqOcrpYhKF6biE7XfELETZCJ7lLQcNOfsLYJEAQZDZD";
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$messaging = $json_object->entry{0}->messaging{0};

if(isset($messaging->message)) {
    $id = $messaging->sender->id;
    $message = $messaging->message->text;
    
    $answer = file_get_contents('http://54.178.68.2:8787/?q=');
    
    
    //$answer =  $message.'まじ神！神！気をつけろっていってんだろ殺すぞ。ボキャ貧か（笑）。';

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
