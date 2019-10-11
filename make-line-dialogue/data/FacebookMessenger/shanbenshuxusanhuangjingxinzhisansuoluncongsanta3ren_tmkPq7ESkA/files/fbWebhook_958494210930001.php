<?php
$access_token = "EAAHQPANUD9IBAIRZC1ItOQ1ZAOtqF51iNB0yIghjfmpo8egymW80Tu2MWWY2mRz4tR1RgtZAtfGaFW6qrQycNhKZCgQxH3AcSIT5qUk95KKkNef6sU6tqLuVzvumgZBgghhhzPxCKSXZCb5yxFzfVeRDiKZCw6IFt8Faas5Vpi3GQZDZD";
$verify_token = "fbbot";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
