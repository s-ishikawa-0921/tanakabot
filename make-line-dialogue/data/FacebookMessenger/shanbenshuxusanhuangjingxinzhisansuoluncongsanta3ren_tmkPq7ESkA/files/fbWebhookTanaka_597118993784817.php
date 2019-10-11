<?php
$access_token = "EAABg1IqCIiMBAKJAbpEIBPbdP43P9KcofZByGKGS5bIhSehDlM4DJkfxC2mffVm2wcX5HsNqxby90XlJYMVUCBDds4Sdm5GN5jVqDT6iJ5j07aOioq8vwW2KBgbknscFZApHrjjgxtZBiUunadrIvmnkEdH5VjoFupnmBZAohgZDZD";
$verify_token = "fbbot";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
