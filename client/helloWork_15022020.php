<?php


if (isset($_GET['comment'])) {
    $input_comment = $_GET['comment'];
//    $input_comment = $_GET['comment'];
    $insertSql = "INSERT INTO syb_alarms_history (data,value) VALUES ('comment_this', '$input_comment');";
    $data = <<<EOD
{
    "request": [
        {
            "name": "login",
            "parameters": {
                "authenticationCode": "1976"
            }
        },
        {
            "name": "sql",
            "parameters": {
            "query": "$insertSql" }
        },
        {
            "name": "updateAlarms",
            "parameters": {}
        },
        {
            "name": "getAlarmsDZero",
            "parameters": {}
        },
        {
            "name": "getAlarmsTotalView",
            "parameters": {}
        },
        {
            "name": "getAlarms_current_time_link",
            "parameters": {}
        },
        {
            "name": "getAlarms_link_byName",
            "parameters": {
               "name": "total_population"
                           }
        }
    ]
}
EOD;

} else {


    $data = <<<EOD
{
    "request": [
        {
            "name": "login",
            "parameters": {
                "authenticationCode": "1976"
            }
        },
        {
            "name": "updateAlarms",
            "parameters": {}
        },
        {
            "name": "getAlarmsDZero",
            "parameters": {}
        },
        {
            "name": "getAlarmsTotalView",
            "parameters": {}
        },
        {
            "name": "getAlarms_current_time_link",
            "parameters": {}
        },
        {
            "name": "getAlarms_source_link",
            "parameters": {
               "name": "total_population"
                           }
        },
        {
            "name": "getAlarms_source_link",
            "parameters": {
               "name": "corriere_primaPosClassifica_totView"
                           }
        }
    ]
}
EOD;
}

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

// $data = $_POST['request'];

$testCallresponse = helloWork($data);


function helloWork($data)
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
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $url = "http://localhost/sibilla/api/post.php";
    //  $url = "https://pasteurian-visitors.000webhostapp.com/sibilla/api/post.php";


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

    // initialize var used in the page

    $ciccio = $response->response;
    $count = count($ciccio);
    //  var_dump($ciccio[5]);
    //  var_dump($count);
    $current_date = null;
    $total_population = null;
    $current_topic = null;
    $corriere_topic_totalViews = null;
    $coronaVirus_Total_confirmed = null;
    $last_comment = null;
    $total_views = null;
    $current_date_link = null;
    $source_link = null;

    foreach ($ciccio as $chiave => $responseItem) {

        if ($responseItem->from == 'getDZero') {

            $total_population = $responseItem->values->total_population[0][0];
            $current_date = $responseItem->values->current_time[0][0];
            $current_topic = $responseItem->values->corriere_primaPosClassifica_title[0][0];
            $corriere_topic_totalViews = $responseItem->values->corriere_primaPosClassifica_totView[0][0];
            $coronaVirus_Total_confirmed = $responseItem->values->coronaVirus_Total_confirmed[0][0];
            $last_comment = $responseItem->values->comment_this[0][0];


        }

        if ($responseItem->from == 'getAlarmsTotalView') {


            $total_views = $responseItem->values->total_views[0][0];


        }

        if ($responseItem->from == 'getAlarms_current_time_link') {


            $current_date_link = $responseItem->values->url[0][0];

        }
        if ($responseItem->from == 'getAlarms_source_json_total_population') {


            $total_population_link = $responseItem->values->url[0][0];

        }
        if ($responseItem->from == 'getAlarms_source_json_corriere_primaPosClassifica_totView') {


            $corriere_topic_totalViews_link = $responseItem->values->url[0][0];

        }


    }


    $end = microtime(true);


    $data = <<<EOD

Hello world, <br>
today is the <a href='$current_date_link'><b>$current_date</b></a>, see the hyperlink to json api!<br><br>

You are the viewer number <b>$total_views</b> of this call. <br><br>

The actual population is about <a href='$total_population_link'><b>$total_population</b></a> piglets. <br>
Very congratulation! It is increasing! <br> <br>

First topic in classifica is: '<a href='$corriere_topic_totalViews_link'><b>$current_topic</b></a>' <br>
with more than <a href='$corriere_topic_totalViews_link'><b>$corriere_topic_totalViews</b></a> total views <br>

<br>The Coronavirus give yous <b>$coronaVirus_Total_confirmed</b> confirmed cases but we are working on the cure.<br>
<br>Last comment on this article is: '<b>$last_comment</b>', <br>


EOD;
    echo "$data";


    $duration = $end - $start;
    echo "<br> Thank you and goodbye! Kiss!<br>";
    echo "<br><br> The duration of this request (response time) is approx: <b>$duration</b> seconds!";


}


?>

<form method=”get”>
    <div>
        <br>
        <legend>Please, write a short comment on this article...and press enter:</legend>
        <div align="left"><input rows="5" cols="30" name="comment"></input>
            <div><input type="submit" name="submit" value="send"></div>
        </div>
    </div>


</form>


