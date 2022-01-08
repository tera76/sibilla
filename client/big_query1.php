<?php
/*
 *  set test parameters
 */
$start = microtime(true);

$baseUrl="https://clients6.google.com/bigquery/v2internal/projects/wise-main-dev/queries";
$userId = "wiseman4";
$password = "wiseman4";



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
				"userId": "__USERID__",
				"password": "__PASSWORD__",
				"fromApp": true
			}
		}
	}
}
EOD;
$request = preg_replace('/__USERID__/', $userId, $request);
$request = preg_replace('/__PASSWORD__/', $password, $request);

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
 *  big query
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET QUERY:",
        "parameters": {
            "url": "__BASEURL__/queries/bquxjob_2029c718_17a883718e4?key=AIzaSyCI-zsRP85UVOi0DjtiCwWBwQ1djDy741g&location=EU&maxResults=200&startIndex=0&timeoutMs=10000",
			"method": "GET",
            "header": ["content-type: application/json"
            ],
            "data": {}
		}
	}
}
EOD;
$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from GET content in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));

die();
/*
 *  get vehicle
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET VEHICLE:",
         "parameters": {
            "url": "__BASEURL__/api/v1/vehicle?customerCode=__CUSTOMERCODE__",
			"method": "GET",
            "header": ["content-type: application/json",
                       "Authorization: Bearer __TOKEN__"
            ],
            "data": {}
		}
	}
}
EOD;

$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from GET vehicle in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


/*
 *  get policy
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET POLICY:",
          "parameters": {
            "url": "__BASEURL__/api/v1/policy?customerCode=__CUSTOMERCODE__",
			"method": "GET",
            "header": ["content-type: application/json",
                       "Authorization: Bearer __TOKEN__"
            ],
            "data": {}
		}
	}
}
EOD;

$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from GET policy in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


/*
 *  get saved-quotation
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET SAVED QUOTATION:",
          "parameters": {
            "url": "__BASEURL__/api/v1/saved-quotation?customerCode=__CUSTOMERCODE__",
			"method": "GET",
            "header": ["content-type: application/json",
                       "Authorization: Bearer __TOKEN__"
            ],
            "data": {}
		}
	}
}
EOD;

$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from GET saved quotation in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


/*
 *  get pertner
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST GET PARTNER:",
          "parameters": {
            "url": "__BASEURL__/api/v1/partner?customerCode=__CUSTOMERCODE__",
			"method": "GET",
            "header": ["content-type: application/json",
                       "Authorization: Bearer __TOKEN__"
            ],
            "data": {}
		}
	}
}
EOD;
$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from GET partners json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


/*
 *  post quotation
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST POST QUOTATION:",
		"parameters": {
			"url": "__BASEURL__/api/v2/quotation/broker?customerCode=__CUSTOMERCODE__",
			"method": "POST",
			"header": ["content-type: application/json",
				"Authorization: Bearer __TOKEN__"
			],
			"data": {
				"ownerBirthday": "__BIRTHDATE__",
				"drivingType": "more_than_26",
				"licensePlate": "__PLATE__"
			}
		}
	}
}
EOD;
$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__PLATE__/', $plate, $request);
$request = preg_replace('/__BIRTHDATE__/', $ownerBirthday, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from POST quotation in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));

$quotationId = $testCallresponse['id'];
printStepMessage("quotation id is", $quotationId);




/*
 *  post save quotation
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST POST SAVE QUOTATION:",
		"parameters": {
			"url": "__BASEURL__/api/v1/saved-quotation/broker?customerCode=__CUSTOMERCODE__",
			"method": "POST",
			"header": ["content-type: application/json",
				"Authorization: Bearer __TOKEN__"
			],
			"data": {
				"guarantees": [{
					"guaranteeCode": "rca",
					"limitCode": "rca_limit_6_07"
				}],
				"paymentFrequency": "YEARLY",
				"quotationId": "__QUOTATIONID__",
				"telepassServices": [{
					"code": "already_wow",
					"title": "Assistenza Stradale"
				}]
			}
		}
	}
}
EOD;
$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$request = preg_replace('/__QUOTATIONID__/', $quotationId, $request);

$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from POST save quotation in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


/*
 *  post save quotation bis
 */

$request = <<<EOD
{
	"request": {
		"name": "TEST POST SAVE QUOTATION BIS:",
		"parameters": {
			"url": "__BASEURL__/api/v1/saved-quotation/broker?customerCode=__CUSTOMERCODE__",
			"method": "POST",
			"header": ["content-type: application/json",
				"Authorization: Bearer __TOKEN__"
			],
			"data": {
				"guarantees": [{
					"guaranteeCode": "rca",
					"limitCode": "rca_limit_6_07"
				}],
				"paymentFrequency": "YEARLY",
				"quotationId": "__QUOTATIONID__",
				"telepassServices": [{
					"code": "already_wow",
					"title": "Assistenza Stradale"
				}]
			}
		}
	}
}
EOD;
$request = preg_replace('/__BASEURL__/', $baseUrl, $request);
$request = preg_replace('/__CUSTOMERCODE__/', $customerCode, $request);
$request = preg_replace('/__TOKEN__/', $token, $request);
$request = preg_replace('/__QUOTATIONID__/', $quotationId, $request);

$dataToArray = json_decode($request);
$title = $dataToArray->request->name;
printTitle($title);

$testCallresponseJsonAndCode = arrayFromCurl($dataToArray->request->parameters);
$testCallresponse = $testCallresponseJsonAndCode['responseJson'];;
$testCallresponseCode = $testCallresponseJsonAndCode['responseCode'];

printErrorCode($testCallresponseCode);
printStepMessage("response from POST save quotation in json", substr(json_encode($testCallresponse, JSON_PRETTY_PRINT), 0, 1250));


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
