<?php

$start = microtime(true);
$primes =
    array(
        2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997


);

$mumber = 100;




for ($x = 2; $x <= $mumber; $x++) {
     echo "<br> $x is the number"  ;
    $isPrime = true;

    foreach ($primes as &$value) {
        $factor = 0;
if ($value < $x) {

        $resto = $x % $value ;

        if ($resto==0 ) {

            $isPrime=false;;
            $factor= $factor+1;
            echo $factor;
        }
        else echo "<span style='color: white'>0</span>";


         }

    }
    if ($isPrime==true) echo "<span style='color: green'> is prime</span>";
}


$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Duration", $duration);

die();
for ($x = 2; $x <= $mumber; $x++) {
   // echo "<br>"  ;
    $isPrime = true;


      for($y=2; $y < $x; $y++){
       echo "The y is: $y <br>";
        $resto = $x % $y ;
       //  echo "The module $x diviso $y is: $resto <br>";

        if ($resto===0 ) {
            // echo "1";
            $isPrime=false;}
        else{
            // echo "<span style='color: white'>0</span>";
            }
    }
    if ($isPrime==true) echo " " . $y . ",";
}


$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Duration", $duration);

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





