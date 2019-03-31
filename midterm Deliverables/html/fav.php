!DOCTYPE html>
<html lang="en">
<style>

#header{ min-height: 20px;}

#body
{
   min-height: 130px;
   margin-top: -2%;
}


body 
{
  background-image: url("https://images.pexels.com/photos/616404/pexels-photo-616404.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

</style>
<body>
<div id= "body">

<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
	echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
	header("refresh: 3; url=login.html");
	exit();
}
$username = $_SESSION['username'];
$item = $_GET['item'];
$calories = $_GET($iteminfo['nf_calories']);

echo $username;
echo $item;
echo $calories;

/*
require_once('/home/mihir/git/rabbitMQ/path.inc');
require_once('/home/mihir/git/rabbitMQ/get_host_info.inc');
require_once('/home/mihir/git/rabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/mihir/git/rabbitMQ/testRabbitMQ.ini","testServer");

if (isset($argv[1])) { $msg = $argv[1]; }
else { $msg = "Add to Favorite"; }

  $request = array();
  $request['type'] = "addfav";
  $request['username']  = $username;
  $request['item']  = $item;
  //$request['calories']  = $calories;
  $request['message']   = $msg;

  $response = $client->send_request($request);

*/

?>

</div>
</body>


