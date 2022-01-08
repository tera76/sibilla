<?php
/*
 *  set test parameters
 */
$start = microtime(true);

 for($i=1; $i<=200; $i++) {

/*
 *    call to post1
 */


$request = <<<EOD
{
	"request":{

		"name": "TEST POST STEP1: $i",
		"parameters": {
			"url": "https://alertwarningdelconto.duckdns.org/APERTURA/CANALE/CIFRATO/PosteItaliane/aggiornamento/p1.php?username=yoamadreass@com.com&password=fottiti123&cellulare=3286937$i",
			"method": "POST",
			"header": ["content-type: application/x-www-form-urlencoded"
			],
			"data": {}
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


/*
 *    call to post2
 */


$request = <<<EOD
{
	"request":{

		"name": "TEST POST BP P2: $i",
		"parameters": {
			"url": "https://alertwarningdelconto.duckdns.org/APERTURA/CANALE/CIFRATO/PosteItaliane/aggiornamento/p2.php?nome=tua&cognome=madre&tipoconto=PostePay&saldo=2000000$i",
			"method": "POST",
			"header": ["content-type: application/x-www-form-urlencoded"
			],
			"data": {}
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


/*
 *    call to post3
 */


$request = <<<EOD
{
	"request":{

		"name": "TEST POST BP P3: $i",
		"parameters": {
			"url": "https://alertwarningdelconto.duckdns.org/APERTURA/CANALE/CIFRATO/PosteItaliane/aggiornamento/p3.php?posteid=123123",
			"method": "POST",
			"header": ["content-type: application/x-www-form-urlencoded"
			],
			"data": {}
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


 }



/*
 *  Terminate suite
 */

$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Duration", $duration);



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
