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
$tvQueryAll  =      "select distinct data,value from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) >= CURDATE()  order by timestamp desc) as h    ";
$tvQueryPreferred = "select distinct data,value from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) >= CURDATE()  order by timestamp desc) as h  join syb_tv_preferred as p where  instr(lower(value),lower(p.`keys`)) ";
$tvQueryFilter =  "select id, `keys` FROM syb_tv_preferred";

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
		"from": "todaytv",
		"parameters": {
		"query": "$tvQueryPreferred"
		}
	}]
}
EOD;

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

echo "<h2>Scelto per te: </h2>";
$testCallresponse = todayInTv($data);



$data_preferred = <<<EOD
{
	"request": [        {
            "name": "login",
            "parameters": {
                "email": "ciccio",
                "keyCode1": "1970"
            }
        },{
		"name": "sql",
		"from": "todaytv",
		"parameters": {
		"query": "$tvQueryAll"
		}
	}]
}
EOD;








$dataToarray = json_decode($data_preferred);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);


echo "<h2>Tutti i canali: </h2>";
$testCallresponse = todayInTv($data);

// lista Query

$data_query= <<<EOD
{
	"request": [        {
            "name": "login",
            "parameters": {
                "email": "ciccio",
                "keyCode1": "1970"
            }
        },{
		"name": "sql",
		"from": "todaytv",
		"parameters": {
		"query": "$tvQueryFilter"
		}
	}]
}
EOD;

$dataToarray = json_decode($data_query);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);


echo "<h2>Filter: </h2>";
$testCallresponse = todayInTv($data);
var_dump($testCallresponse);
die();
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
    echo "<h3>Che Danno Stasera?</h3>";

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
