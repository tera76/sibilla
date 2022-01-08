<?php

$start = microtime(true);
$primes =
    array(
        1 => 2,
        2 => 3,
        3 => 5,
        4 => 7

);

$input= 7;

$idStart = 0;
$idEnd = 0 ;

$idEnd= count($primes);

echo "count: " .  $idEnd;

var_dump($primes);

foreach ($primes as $ciccio ) {

   echo "ciccio: " . $ciccio;
}



var_dump($input);
die();






/*
 *  Login call to get token
 */
$request = <<<EOD
{
	"request":{

		"name": "TEST POST LOGIN:",
		"parameters": {
			"url": "https://ws-test.telepass.com/TelepassKTB_REST/ktb/utente/login",
			"method": "POST",
			"header": ["content-type: application/json",
				"x-sistema-chiamante: aci"
			],
			"data": {
				"registraAccesso": true,
				"userId": "wiseman4",
				"password": "wiseman4",
				"fromApp": true
			}
		}
	}
}
EOD;

$dataToArray = json_decode($request);
$title = $dataToArray->request->name;

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];


printTitle($title);
printErrorCode($testCallresponseCode);

$token = $testCallresponse['jwtToken'];
printStepMessage("token from login", $token);


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
    $data = json_encode($data);


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


    // header("content-type:application/json");
    $response_decode = json_decode($curlResponse, true);
    $response['responseJson'] = $response_decode;
    $response['responseCode'] = $http_response_header[0];


    return $response;

}





