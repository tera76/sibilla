<?php
require __DIR__ . '/../api/conf/environment.conf.php';

$url = apiEntryPoint;
var_dump(  $url  );

$start = microtime(true);

/*
 *  Sibills
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST SIBILLA GOLD1:",
		"parameters": {
			"url": "$url",
			"method": "POST",
			"header": [
				"Content-type: application/x-www-form-urlencoded",
				"access_token: Bearer 1970"
			],
			"data": {
				"request": [{
					"name": "sql",
					"from": "getDate",
					"parameters": {
						"query": "select timestamp, value from syb_alarms_history where data like '%gold%g' order by id desc limit 1000 "
					}
				}]
			}
		}
	}
}
EOD;


for ($i=0; $i < 1; $i++) {
	// code...


$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];


printErrorCode($testCallresponseCode);
printStepMessage("response from GET content in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


 echo "<br> test <br>";

$response= $testCallresponse['response'];
$ciccio = $response;

foreach ($ciccio as $chiave => $responseItem) {

if ($responseItem['from'] == 'getDate') {

		$gold_date_value = $responseItem['values'];

}

}






}

/*
 *  golden graph
 */
		error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
$size = sizeof($gold_date_value);

 for ($i=0; $i<  $size; $i++  ) {

$gold_date_value[$i][1]  =  str_replace("€", "", $gold_date_value[$i][1])	;

$scale_value = intval($gold_date_value[$i][1] *10);


echo "<br>" . $gold_date_value[$i][0] ." " . $gold_date_value[$i][1] . " " . $scale_value	  ;

for ($val=400; $val<=  $scale_value ; $val++  ) {
	echo ".";
}
	echo "*";


}







/*
 *  Terminate suite
 */

$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Duration", $duration);
die();









/*
 *  Now we define some standard function for style and print formatting
 * This can be general or defined in each test report
 */


function printTitle($title)
{


    echo "<br><br><strong>" . $title . "</strong><br>";
}

function printErrorCode($code)
{

    if (strpos($code, 'OK') == false && strpos($code, '1.1 200') == false) {
        echo "<p style='color: red'><br><br><strong>!!!!!!!!!!!!! Error in Response code: </strong><br>" . $code . "<p>";
    }

}

function printStepMessage($step, $value)
{

    echo "<br><br><strong>" . $step . ":  </strong><br>" . $value;


}

function arrayFromCurl($input)
{

	$url = $input->url;
	  $method = $input->method;
	  $header = $input->header;
	  $data = $input->data;
	  $dataUrlEncoded = $input->dataUrlEncoded;
	  if(is_null($dataUrlEncoded)) {
	  $data = json_encode($data);}
	  else $data=$dataUrlEncoded;


	  $opts = array('http' =>
	  array(
	    'url' => $url,
	    'method' => $method,
	    'header' => $header,
	    'content' => $data
	  )
	);


	ini_set('memory_limit', '256M');
	$context = stream_context_create($opts);
	$curlResponse = file_get_contents($url, false, $context);

// var_dump(gzdecode($curlResponse));
	// header("content-type:application/json");
	$response_decode = json_decode($curlResponse, true);


	$response['responseJson'] = $response_decode;

	$response['responseCode'] = $http_response_header[0];


	return $response;

}
