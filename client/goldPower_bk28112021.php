<?php

$data = <<<EOD
{
	"request": [{
		"name": "login",
		"parameters": {
			"authenticationCode": "1976"
		}
	}, {
		"name": "sql",
		"from": "getDate",
		"parameters": {
			"query": "select timestamp from syb_alarms_history order by id asc limit 1 "
		}
	}]
}
EOD;


$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

$testCallresponse = goldPrice($data);


function goldPrice($data)
{



    $postdata = $data; //http_build_query($data);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );


    require __DIR__ . '/../api/conf/environment.conf.php';

    $url = apiEntryPoint;
	var_dump(  $url  );

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

		var_dump(  $response  );
		die();
    $starting_data = null;

foreach ($ciccio as $chiave => $responseItem) {

    if ($responseItem->from == 'getDate') {

        $start_time = $responseItem->values[0];




    }


}


    // initialize var used in the page

    $arrayList = $response->response;
    var_dump($arrayList);
    die();





    $data = <<<EOD

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>Hello Work Report</title>
    <link href="http://bit.ly/GPvP5H" rel="stylesheet" type="text/css">
</head>

<body>

<h1>The Sibilla test Report</h1>



Hello world, <br>
today is the <a href='$current_date_link'><b>$current_date</b></a>, see the hyperlink to json api!<br><br>


The actual population is about <a href='$total_population_link'><b>$total_population</b></a> piglets. <br>
Very congratulation! It is increasing! <br> <br>

First topic in the general classifica is: '<a href='$corriere_topic_totalViews_link'><b>$current_topic</b></a>' <br>
with more than <a href='$corriere_topic_totalViews_link'><b>$corriere_topic_totalViews</b></a> total views <br>

<br>Gold is at <b>$metal_price_current</b> euro for grams. <br>


<br>In the music hit parade is the title <b>$classifica_dischi_italiani</b> for now. <br>

<br>Using an html source with xpath locator we have <a href='$cicciolina_altezza_link'><b>$cicciolina_altezza</b></a> for cicciolina height, last news from ansa is <b>$ansa_news</b><br>

<br>The Coronavirus give yous <a href='$coronaVirus_Total_confirmed_link'<b>$coronaVirus_Total_confirmed</b></a> confirmed cases but we are working on the cure.<br>
<br>Last comment on this article is: '<b>$last_comment</b>', <br>





 <br> Thank you and goodbye! Kiss!<br>
   <br><br> The duration of this request (response time) is approx: <b>$duration</b> seconds!
    <br>You are the viewer number <b>$total_views</b> of this call. <br><br>

EOD;
    echo "$data";

}


?>

<form method=”get”>
    <div>
        <br>
        <legend>Please, write a short comment on this article...and press enter:</legend>
        <div align="left"><input rows="5" cols="30" name="comment"></input>
            <div>
                <button type="submit" name="submit" value="send">send</button>
            </div>
        </div>
    </div>


</form>
