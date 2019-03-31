<?php

session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}

$username = $_SESSION["username"];
require_once('/home/mihir/git/rabbitMQ/path.inc');
require_once('/home/mihir/git/rabbitMQ/get_host_info.inc');
require_once('/home/mihir/git/rabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/mihir/git/rabbitMQ/testRabbitMQ.ini","apiServer");


if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on search result page"; }

$request = array();
if($request['type'] = "search"){
$request['item'] = $_GET['item'];

$response = $client->send_request($request);
$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

echo"<br><br><br><br><br><br>";
echo (" $space Item -");
echo ucfirst($_GET['item']);
echo "<br><br>";

$iteminfo = $response['fields'];

echo("$space Food Name - ");
echo ($iteminfo['item_name']) ;
//$foodname = $iteminfo['item_name'];
//echo $foodname;
echo"<br><br>";
echo ("$space $item Calories - ");
echo ($iteminfo['nf_calories']);
//$calories = $iteminfo['nf_calories'];
echo $calories;
echo"<br><br>";
echo ("$space $item Sodium - ");
echo ($iteminfo['nf_sodium']);
echo"<br><br>";
echo ("$space $item Sugar - ");
echo ($iteminfo['nf_sugars']);
echo"<br><br>";
echo ("$space $item Protein - ");
echo ($iteminfo['nf_protein']);
echo"<br><br>";
echo ("$space Serving Size Quantity - ");
echo ($iteminfo['nf_serving_size_qty']);
echo"<br><br>";
echo ("$space Serving Size Unit - ");
echo($iteminfo['nf_serving_size_unit']);
echo"<br><br>";
}
$_SESSION['item'] = $item;
/*
if($request['type'] = "addtofav"){
$request['username'] = $username;
$request['foodname'] =
$request['calories'] = $calories;
 
}*/
?>


<!DOCTYPE html>
<html lang="en">
<style>

#header{ min-height: 20px;}

#body
{
   min-height: 130px;
   margin-top: -2%;
}

#b1
{
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:0;
  margin-left:570px;
}
#b2
{
  line-height: 28px;
  width: 100px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:-500px;
  margin-left:1350px;
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
<form>

<div>
  <button id="b1" type="button" onclick="location.href='success.php'">Search Again</button>
</div>

<div>
  <button id="b2" type="button" onclick="location.href='login.html'">Logout</button>
</div>

<div>
  <form class="addfav" action="fav.php" style="margin:top;max-width:600px">
  <input type="hidden" name="addfav" id="addfav">
  <button id="b1" type="button" onclick="location.href='fav.php'">Add To favorite</button>
</div>

</form>
</body>
