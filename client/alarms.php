<?php
// Turn off all error reporting
error_reporting(0);

/*
 * alarms is the cron scheduled for uploading data every 10 miutes.
 * */

$data = null;
if(isset($_GET['request'])) $data= $_GET['request'];

if ($data == "") {
    $data = <<<EOD
{
    "request": [
        {
            "name": "updateAlarms",
            "parameters": {}
        },
        {
            "name": "getAlarmsDZero",
            "parameters": {}
        }
    ]
}
EOD;
}

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

// $data = $_POST['request'];

$testCallresponse = makeCall($data);






function makeCall($data)
{



    $start = microtime(true);

//Recupero il valore del parametro "$code"
// $data = $_POST['request'];
//    echo '*********** send: ', '</br>';
    //   echo $data;

    $postdata = $data; //http_build_query($data);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => ["content-type: application/json",
            "access_token: Bearer 1970"
          ],
            'content' => $postdata
        )
    );


    require __DIR__ . '/../api/conf/environment.conf.php';


   //  $url = "http://localhost/sibilla/api/post.php";
   // $url = "https://pasteurian-visitors.000webhostapp.com/sibilla/api/post.php";
$url = apiEntryPoint;


    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        exit("Unable to update data at $url");
    }


    if (JSON_ERROR_NONE !== json_last_error()) {
        exit("Failed to parse json: " . json_last_error_msg());
    }


    // var_dump($response);

    $response = json_decode($response);

    // $myData = $response['response'];

    $ciccio = $response->response;


    $count = count($ciccio);
    //  var_dump($ciccio[5]);
  //  var_dump($count);

    foreach ($ciccio as $chiave => $responseItem) {

        if ($responseItem->from == 'getDZero') {
            echo("Alarms, current data; <br>");
            $data = $responseItem->values;

            echo "<head><style>table, th, td {border: 1px solid black;}</style></head>";
      			echo "<table style=\"width:100%\">";
            echo "<tr><th style=\"width:30%\">key</th><th>value</th></tr>";


            foreach ($data as $key => $value){
            //     var_dump($value[0][0]);
                $derivataZero = $value[0][0];
                // echo "<br>" . "<b>$key</b> is at $derivataZero"  ;
                echo "<tr><td><b>$key :</b></td><td>$derivataZero</td></tr>"  ;

            }
            echo "</table>";


        }
    }

    $end = microtime(true);

    $duration = $end - $start;
    echo "<br><br><br> **** Duration is at: $duration"  ;
    die();


}
