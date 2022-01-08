<?php
// Turn off all error reporting
error_reporting(0);

$data = <<<EOD
{
	"request": [{
		"name": "sql",
		"from": "todaytv",
		"parameters": {
			"query": "¢"
		}
	}]
}
EOD;


$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

$testCallresponse = todayInTv($data);


function todayInTv($data)
{
    $start = microtime(true);



    $postdata = $data; //http_build_query($data);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => ["content-type: application/json",
            "access_token: bearer 1970"
          ],
            'content' => $postdata
        )
    );


    require __DIR__ . '/../api/conf/environment.conf.php';

    $url = apiEntryPoint;


    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        exit("Unable to update data at $url");
    }


    if (JSON_ERROR_NONE !== json_last_error()) {
        exit("Failed to parse json: " . json_last_error_msg());
    }



    $response = json_decode($response);

    $ciccio = $response->response;
    $starting_data = null;
    $tv = null;
    echo "<h2>Che Danno Stasera?</h2>";

foreach ($ciccio as $chiave => $responseItem) {

    if ($responseItem->from == 'todaytv') {

        $tv = $responseItem->values ;
        // echo   $tv;

    }


}


    // initialize var used in the page


    printf($tv[0][0]);
    echo "<br>";
    printf($tv[0][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[1][0]);
    echo "<br>";
    printf($tv[1][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[2][0]);
    echo "<br>";
    printf($tv[2][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[3][0]);
    echo "<br>";
    printf($tv[3][1]);
   // die();





    $data = <<<EOD

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>Hello Work Report</title>
    <link href="http://bit.ly/GPvP5H" rel="stylesheet" type="text/css">
</head>

<body>

<h1>The Sibilla Report</h1>



Hello world, <br>


<br>Stasera in tv:  <b>$tv[0][0][0]</b> danno  <b>$tv[0][1]</b> <br>





EOD;
    echo "$data";
    /*
     *  Terminate suite
     */

    $end = microtime(true);
    $duration = $end - $start;
    echo "**** Duration: " .  $duration . " sec.";
}
