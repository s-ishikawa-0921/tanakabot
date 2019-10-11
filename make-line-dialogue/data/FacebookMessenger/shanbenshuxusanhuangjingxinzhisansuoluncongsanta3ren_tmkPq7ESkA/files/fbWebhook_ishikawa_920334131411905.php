<?php
$access_token = "EAAHGrligKQYBAK9SqED7NHBrsKZCjaMiOyrUDmn2kBaLbFRaDMbtqO8rWaoM5JH1lP3HOPBq4brATUy0LunQZBJZB3qpKyA6lK7HGBYePS0jwVmf1R9IpXV6lyaQtA0ZByNHcqOcrpYhKF6biE7XfELETZCJ7lLQcNOfsLYJEAQZDZD";
$verify_token = "fbbot";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}
