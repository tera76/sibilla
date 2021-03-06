<?php

$start = microtime(true);


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
$newsQueryAll  =      "select max(`timestamp`) as ttt ,   max(value)  FROM syb_alarms_history x WHERE `data` = 'corriere_primaPosClassifica_title' GROUP by value ORDER BY  ttt desc limit 50";


;

$data = <<<EOD
{
	"request": [        {
            "name": "login",
            "parameters": {
                "email": "ciccio",
                "keyCode1": "1970"
            }
        },{
		"name": "sql",
		"from": "cheSuccede",
		"parameters": {
		"query": "$newsQueryAll"
		}
	}]
}
EOD;

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);
echo "<h1>Che succede! </h1>";

echo "<h2>Scelto per te: </h2>";
$testCallresponse = cheSuccede($data);


/*
 *  Terminate suite
 */

$end = microtime(true);
$duration = $end - $start;
echo "**** Duration: " .  $duration . " sec.";
die();



//
//
//
//


function cheSuccede($data)
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
//    echo "<h3>Che Danno Stasera?</h3>";

foreach ($ciccio as $chiave => $responseItem) {

    if ($responseItem->from == 'cheSuccede') {



	//		echo("Alarms, current data: <br>");
			$data = $responseItem->values;

			echo "<head><style>table, th, td {border: 1px solid black;}</style></head>";
			echo "<table style=\"width:100%\">";

			echo "<tr><th style=\"width:30%\">source</th><th>title</th></tr>";


			foreach ($data as $key => $value){
			//     var_dump($value[0][0]);
					$channel = $value[0];
					$program = $value[1];
						echo "<tr><td><b>$channel </b></td><td>$program</td></tr>"  ;
			//		echo "<br>" . "<span><b>	$channel</b> play:" . "\t" .$program .<span>""  ;
      //    echo "<br><strong>" . $channel . "aa \t\t\t\t\t\t" . ":  </strong>" . "\t\t\t" . $program . "\t";
					}
echo "</table>";
    }


}



}
