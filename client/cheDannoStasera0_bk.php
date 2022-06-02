<?php



// Turn off all error reporting
/*

1984  docker start f461d2e10460
1985  history | grep mysql
1988  docker ps -a
1989  docker exec -it f461d2e10460 bash

1991  vim /etc/hosts

2001  mysql -h db --port 3306 -uroot -p
use my_andreamatera;
	CREATE TABLE `syb_tv_all` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `start_at` text,
	  `title` text,
		`channel` text
		UNIQUE KEY `syb_tv_all_uindex` (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=4650 DEFAULT CHARSET=latin1;

*/
error_reporting(0);
$tvQueryAll  = "select distinct data,value from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) >= CURDATE()  order by timestamp desc) as h    ";
$tvQueryPreferred = "select distinct data,value from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) = CURDATE()  order by timestamp desc) as h  join syb_tv_preferred as p where  instr(lower(value),lower(p.`keys`)) ";

$data = <<<EOD
{
	"request": [{
		"name": "sql",
		"from": "todaytv",
		"parameters": {
		"query": "$tvQueryAll"
		}
	}]
}
EOD;

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);



$data_preferred = <<<EOD
{
	"request": [{
		"name": "sql",
		"from": "todaytv",
		"parameters": {
		"query": "$tvQueryPreferred"
		}
	}]
}
EOD;

$dataToarray_preferred = json_decode($data_preferred);
$data_preferred = json_encode($dataToarray_preferred, JSON_PRETTY_PRINT);


$testCallresponse = todayInTv_preferred($data_preferred);
$testCallresponse = todayInTv($data);

die();


/*
 *  Terminate suite
 */

$end = microtime(true);
$duration = $end - $start;
echo "**** Duration: " .  $duration . " sec.";
die();

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


			echo("Alarms, current data: <br>");
			$data = $responseItem->values;
			foreach ($data as $key => $value){
			//     var_dump($value[0][0]);
					$channel = $value[0];
					$program = $value[1];
					echo "<br>" . "<b>	$channel</b> play: $program"  ;
			}

    }


}



}

function todayInTv_preferred($data)
{
    $start = microtime(true);
echo "<br><br><br><br>" . "CONSIGLIATI PER TE</b>"  ;


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


			echo("Alarms, current data!: <br>");
			$data = $responseItem->values;
			foreach ($data as $key => $value){
			//     var_dump($value[0][0]);
					$channel = $value[0];
					$program = $value[1];
					echo "<br>" . "<b>	$channel</b> play: $program"  ;
			}

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
    <title>TV Report</title>
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
