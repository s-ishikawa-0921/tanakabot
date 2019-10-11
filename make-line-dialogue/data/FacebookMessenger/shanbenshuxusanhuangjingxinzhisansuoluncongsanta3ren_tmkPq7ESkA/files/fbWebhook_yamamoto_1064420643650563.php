<?php
$access_token = "EAAW7WGohZAmYBANJN9LntYxPHcA4R5cD3zEorxr1lZANcAZCWvz5XxJZBPArk6EVEKozF89JJCF0EAs8eIOIFJU01Ms5RkEmFj5IzXar02vk0CDDhfM3OHNuIUYUxFC8QDIxDyhY8xg8aMKx1a2Ypy93TlfOE6IfxtRBSV38FQZDZD";
$verify_token = "fbbot";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
