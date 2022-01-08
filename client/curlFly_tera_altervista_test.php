<?php

$start = microtime(true);

/*
 *  Sibills
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET altervista:",
        "parameters": {
            "url": "http://tera.altervista.org/analisi-spettrale-dei-numeri-interi/",
			"method": "GET",
            "header": [
						"content-type: text/html; charset=UTF-8",
						"Connection: keep-alive",
	"Cache-Control: max-age=0",
	"Upgrade-Insecure-Requests: 1",
	"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36",
	"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
	"Accept-Encoding: gzip, deflate"],
		"data": {}
		}
	}
}
EOD;


for ($i=0; $i < 2; $i++) {
	// code...


$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];


printErrorCode($testCallresponseCode);
printStepMessage("response from GET content in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));
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

 var_dump(gzdecode($curlResponse));
	// header("content-type:application/json");
	$response_decode = json_decode($curlResponse, true);


	$response['responseJson'] = $response_decode;

	$response['responseCode'] = $http_response_header[0];


	return $response;

}
