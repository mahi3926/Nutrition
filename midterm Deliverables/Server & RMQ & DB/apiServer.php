#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function fetchItem($item){
	

	$curl = curl_init();
	
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.nutritionix.com/v1_1/search/'.$item.'?results=0:20&fields=item_name,brand_name,item_id,nf_calories,nf_protein,nf_sugars,nf_sodium&appId=93504f94&appKey=7df6de5740084c54cf4fb20d3dd81b4d",
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => "GET",
  		CURLOPT_HTTPHEADER => array(
    		"Postman-Token: eb158d0e-a543-4895-8d47-e4e0f967be96",
    		"cache-control: no-cache"
  		),
));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if($err) {
		echo "CURL ERROR #:".$err;
	}else{
		//echo $response;

		$result = json_decode($response, true);
		$hits = $result['hits'];
		$item_info = $hits['0'];
		print_r($item_info);
		return $item_info;	
	}

}


function requestProcessor($request){

	echo "received request".PHP_EOL;
	var_dump($request);

	if(!isset($request['type'])){ return "Error"; }

	switch($request['type']){
			
		case "search";
			return fetchItem($request['item']);
			break;
	
		}

		echo var_dump($response_msg);
		return $response_msg;

}


$server = new rabbitMQServer("testRabbitMQ.ini", "apiServer");
echo "DMZ Server Begin".PHP_EOL;
$server->process_requests('requestProcessor');
exit();



?>
