<?php
session_start();
if(!isset(	$_SESSION['logged'] ) ) 
{
	echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
	header("refresh: 3; url=login.html");
	exit();
}
$username = $_SESSION['username'];
require_once('/home/mihir/git/rabbitMQ/path.inc');
require_once('/home/mihir/git/rabbitMQ/get_host_info.inc');
require_once('/home/mihir/git/rabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/mihir/git/rabbitMQ/testRabbitMQ.ini","testServer");

if (isset($argv[1])) { $msg = $argv[1]; }
else { $msg = "You are on user profile page"; }

  $request = array();
  $request['type'] = "success";
  $request['username']  = $username;
  $request['message']   = $msg;

  $response = $client->send_request($request);

  $welcome = '<font size = "10" color = "coloring"> Welcome';
  echo "<div align='center'><br><br>$welcome $response</div>";	

?>

<!DOCTYPE html>
<html lang="en">
 <style>

 #header{
   min-height: 20px;
 }

 #body{
   min-height: 130px;
   margin-top: -2%;
 }

#button{
line-height: 25px;
width: 100px;
background-color: blue;
color:white;
font-size: 15pt;
margin-top:-550px;
margin-left:1350px;
}
body {
  background-image: url("https://images.pexels.com/photos/616404/pexels-photo-616404.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

</style>

<body>
<head>
     <meta content="text/html; charset=utf-8">
     <title>Welcome! What would you like to search?</title>
</head>

<div id="footer">
<center>
<img hspace="10" src="search.png" width="25%" height="auto">
</center>
</div> 

<center><br>
<font size="6">Please enter the food name below</font> 
<form class="serch" action="search.php" style="margin:top;max-width:600px">
<input type="text" placeholder="Food Name" name="item" id="item">
<button type="submit"> Click here to search for an item</button>
</center>

<div>
  <button id="button" type="button" onclick="location.href='login.html'">Logout</button>
</div>
</form>
</body>
