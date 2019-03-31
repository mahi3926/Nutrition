#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
  include('account.php');
  $mydb = new mysqli($dbserver,$dbuser,$dbpass,$dbname);

  if ($mydb->errno != 0) 
  { echo "failed to connect to database: ". $mydb->error . PHP_EOL; exit(0); }
  else { echo "successfully connected to database".PHP_EOL; }

  $query = mysqli_query($mydb,"SELECT * FROM users WHERE username = '$username' AND password = '$password' ");
  $count = mysqli_num_rows($query);

  //Check if credentials match the database
  if ($count == 1)
  { echo "USERS CREDENTIALS VERIFIED"; return true; }
  else { echo "User Credential did not match!!!!"; return false; }

  if ($mydb->errno != 0)
  {
    echo "failed to execute query:".PHP_EOL;
    echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
    exit(0);
  }
}


function doregister($firstname,$lastname,$username,$password)
{
  include('account.php');
  $mydb = new mysqli($dbserver,$dbuser,$dbpass,$dbname);

  if ($mydb->errno != 0)
  { echo "failed to connect to database: ". $mydb->error . PHP_EOL; exit(0); }
  else { echo "successfully connected to database".PHP_EOL; }

  $query = mysqli_query($mydb,"SELECT * FROM users WHERE username = '$username'");
  $count = mysqli_num_rows($query);

 //Check if credentials match the database
  if ($count > 0)
  { echo "<br><br>Please register with differernt username"; return false; }
  else 
  { 
    $query = mysqli_query($mydb,"INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname','$lastname','$username','$password')");
    echo "Register Successful!!!!";
    return true;
  }

  if ($mydb->errno != 0)
  {
    echo "failed to execute query:".PHP_EOL;
    echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
    exit(0);
  }

}

function doSuccess($username)
{
  include('account.php');
  $mydb = new mysqli($dbserver,$dbuser,$dbpass,$dbname);
  
  if ($mydb->errno != 0) 
  { echo "failed to connect to database: ". $mydb->error . PHP_EOL; exit(0); }
  else { echo "successfully connected to database".PHP_EOL; }

  $query = mysqli_query($mydb,"SELECT * FROM users WHERE username = '$username'");
  $count = mysqli_num_rows($query);

  //Check if credentials match the database
  if ($count == 1)
  { 
      echo "USERS CREDENTIALS VERIFIED"; 
      while($r = mysqli_fetch_array ($query))
      {
	$username = $r["username"];
	$firstname = $r["firstname"];
	$lastname = $r["lastname"];
      }
    
    return $firstname." ".$lastname; 
   }
  else { echo "User Credential did not match!!!!"; return false; }
}

function addFav($username, $item, $calories){
	include('account.php');
	$mydb = new mysqli($dbserver,$dbuser,$dbpass,$dbname);

	if ($mydb->errno != 0) { echo "failed to connect to database: ". $mydb->error . PHP_EOL; exit(0); }
 	else { echo "successfully connected to database".PHP_EOL; }
	
}

/*
function fetchItem($item)
{
   $curl = curl_init();
   curl_setopt_array($curl, array(
   			CURLOPT_URL => "https://api.nutritionix.com/v1_1/search/'.$item.'?results=0:20&fields=item_name,item_id,nf_calories,nf_protein,nf_sugars,nf_sodium&appId=93504f94&appKey=7df6de5740084c54cf4fb20d3dd81b4d",
  		
   			CURLOPT_RETURNTRANSFER => true,
   			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
   			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	                CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array("Postman-Token: eb158d0e-a543-4895-8d47-e4e0f967be96", 
							"cache-control: no-cache"),));

   $response = curl_exec($curl);
   $err = curl_error($curl);

   curl_close($curl);

   if($err) { echo "CURL ERROR #:".$err; }
   else{
          echo $response;
          $result = json_decode($response, true);
	  $hits = $result['hits'];
	  $item_info = $hits['0'];

          $_SESSION['test'] = $item_info;

	  print_r($item_info);
	  return $item_info;	
       }

}
*/

function requestProcessor($request)
{
  echo ", received request".PHP_EOL;
  var_dump($request);

  if(!isset($request['type'])) { return "ERROR: unsupported message type"; }

  switch ($request['type'])
  {
    case "login":
         return doLogin($request['username'],$request['password']);
	 break;
    case "register":
         return doregister($request ['firstname'],$request['lastname'],$request['username'],$request['password']);
     	 break;
    case "success":
         return doSuccess($request['username']);
	 break;
    case "addfav";
	return addFav($request['username'],$request['item']);
	break;
    case "validate_session":
         return doValidate($request['sessionId']);
	 break;
  }

  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "rabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "rabbitMQServer END".PHP_EOL;
exit();



?>
