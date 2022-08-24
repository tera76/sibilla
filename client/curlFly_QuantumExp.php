<?php

$start = microtime(true);

/*
 *  Sibills
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST QE:",
		"parameters": {
			"url": "https://quantum-computing.ibm.com/api/graphql/",
			"method": "POST",
			"header": [
				"Content-Type: application/json"
			],
			"data": {
				"query": "query runSimulator(\$qasm: String!, \$seed: Int, \$shots: Int) {  runSimulator(qasm: \$qasm, seed: \$seed, shots: \$shots) {    statevector    counts {      state      count    }  }}",
				"variables": {
					"qasm": "OPENQASM 2.0;include \"qelib1.inc\";qreg q[2];creg c[2];reset q[0];reset q[1];rx(pi*1/(3-1)) q[0];cx q[0],q[1];measure q[0] -> c[0];measure q[1] -> c[1];",
					"seed": 32,
					"shots": 1024
				}
			}
		}
	}
}
EOD;


$dataToArray = json_decode($request);

$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);

$testCallresponse = $testCallresponseJsonAndCode['responseJson'];

$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];


printErrorCode($testCallresponseCode);
printStepMessage("response in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));



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

$html_ouput=gzdecode($curlResponse);
 echo $html_ouput ; // (gzdecode($curlResponse));
	// header("content-type:application/json");
	$response_decode = json_decode($curlResponse, true);


	$response['responseJson'] = $response_decode;

	$response['responseCode'] = $http_response_header[0];


	return $response;

}
