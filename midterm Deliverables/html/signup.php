#!/usr/bin/php
<?php

require_once('/home/mihir/git/rabbitMQ/path.inc');
require_once('/home/mihir/git/rabbitMQ/get_host_info.inc');
require_once('/home/mihir/git/rabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/mihir/git/rabbitMQ/testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on signup page"; }

$request = array();
$request['type'] = "register";
$request['firstname'] = $_POST['firstname'];
$request['lastname'] = $_POST['lastname'];
$request['username'] = $_POST['username'];
$request['password'] = $_POST['password'];
$request['message'] = $msg;

$response = $client->send_request($request);
print_r($response);

if ($response == 1 ) { header("location:login.html"); }
else { header("location:error_signup.php" ); }
?>
