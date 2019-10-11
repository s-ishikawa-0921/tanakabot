<?php
$access_token = "EAAY6yfqkwFgBAOc0iiU7fVzho2WAznZCQEsMGjyuZBxHj14KKWhclfc7QZB52nOQCpCjki8jwAGelqFSrBKXvSLyg2wmyWNnUkrWLIwey3boa6fX0HFQBgZBwkPBrfR9WmhSwLovVhwOKi2c2ATNHbLMuZC38Hk2bIpDcZCcMVVQZDZD"

";
$verify_token = "fbbot";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
