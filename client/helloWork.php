<?php
// Turn off all error reporting
error_reporting(0);

// $tvQuery  = "select data,value from (select  timestamp, data,value  from syb_alarms_history WHERE data like `staseraInTv%` and DATE(`timestamp`) = CURDATE() GROUP BY data  ORDER BY  max(timestamp) desc ) as h ,  syb_tv_preferred as p where  instr(lower(value),lower(p.`keys`)) limit 5";
// $tvQuery  = "select distinct h.data, h.value  from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) >= CURDATE() order by timestamp desc) as h  join  (select  id,  data    from (select  max(id) as id, max(timestamp) , max(data) as data  from syb_alarms_history where data like 'staseraInTv%'  GROUP by data ) as h  ) as d join  (select `keys` from syb_tv_preferred ) as p where h.id = d.id and  instr(lower(value),lower(p.`keys`))";

$data = <<<EOD
{
	"request": [        {
            "name": "login",
            "parameters": {
                "email": "ciccio",
                "keyCode1": "1970"
            }
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
		},
		{
			"name": "getAlarms_source_link",
			"parameters": {
				"name": "coronaVirus_Total_confirmed"
			}
		},
		{
			"name": "getAlarms_source_link",
			"parameters": {
				"name": "cicciolina_altezza"
			}
		},
		{
			"name": "getAlarms_source_link",
			"parameters": {
				"name": "gold_price"
			}
		},
		{
			"name": "getAlarms_source_link",
			"parameters": {
				"name": "gold_price_goldavenue_kg"
			}
		},
		{
			"name": "getAlarms_source_link",
			"parameters": {
				"name": "classifica_dischi_italiani"
			}
		},
		{
			"name": "sql",
			"from": "getDataFrom",
			"parameters": {
				"query": "select timestamp from syb_alarms_history order by id asc limit 1 "
			}
		},
		{
			"name": "sql",
			"from": "getDataTo",
			"parameters": {
				"query": "select timestamp from syb_alarms_history order by id desc limit 1 "
			}
		}
	]
}
EOD;



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
            'header' => ["content-type: application/json",
            "access_token: bearer 1970"
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

    // initialize var used in the page

    $ciccio = $response->response;
    $count = count($ciccio);
    $current_date = null;
    $total_population = null;
    $total_population_link = null;
    $current_topic = null;
    $corriere_topic_totalViews = null;
    $coronaVirus_Total_confirmed = null;
    $last_comment = null;
    $total_views = null;
    $corriere_topic_totalViews_link = null;
    $current_date_link = null;
    $source_link = null;
    $coronaVirus_Total_confirmed_link = null;
    $cicciolina_altezza = null;
    $cicciolina_altezza_link = null;
    $ansa_news = null;
    $getDataFrom = null;
    $getDataTo = null;
    $classifica_dischi_italiani = null;
    $metal_price_current = null;
    $metal_price_current_kg = null;
    $metal_price_current_link= null;
    $metal_price_current_kg_link= null;
    $classifica_dischi_italiani_link= null;
		$euroDollarChange= null;

    foreach ($ciccio as $chiave => $responseItem) {

        if ($responseItem->from == 'getDZero') {

            $total_population = $responseItem->values->total_population[0][0];
            $current_date = $responseItem->values->current_time[0][0];
            $current_topic = $responseItem->values->corriere_primaPosClassifica_title[0][0];
            $corriere_topic_totalViews = $responseItem->values->corriere_primaPosClassifica_totView[0][0];

            $coronaVirus_Total_confirmed = $responseItem->values->coronaVirus_Total_confirmed[0][0];
						if ($coronaVirus_Total_confirmed==null ) $coronaVirus_Total_confirmed = "--not defined--";

            $last_comment = $responseItem->values->comment_this[0][0];

            $cicciolina_altezza = $responseItem->values->cicciolina_altezza[0][0];
						if ($cicciolina_altezza==null ) $cicciolina_altezza = "--not defined--";

            $ansa_news = $responseItem->values->ansa_news[0][0];
            if ($ansa_news==null ) $ansa_news = "--not defined--";

            $classifica_dischi_italiani = $responseItem->values->classifica_dischi_italiani[0][0];
            if ($classifica_dischi_italiani==null ) $classifica_dischi_italiani = "--not defined--";

            $metal_price_current = $responseItem->values->gold_price[0][0];
            if ($metal_price_current==null ) $metal_price_current = "--not defined--";

            $metal_price_current_kg = $responseItem->values->gold_price_goldavenue_kg[0][0];
            if ($metal_price_current_kg==null ) $metal_price_current_kg = "--not defined--";


					 $euroDollarChange = $responseItem->values->euroDollarChange[0][0];
  			   if ($euroDollarChange==null ) $euroDollarChange = "--not defined--";

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
        if ($responseItem->from == 'getAlarms_source_json_gold_price_goldavenue_kg') {


            $metal_price_current_kg_link = $responseItem->values->url[0][0];

        }


        if ($responseItem->from == 'getAlarms_source_json_coronaVirus_Total_confirmed') {


            $coronaVirus_Total_confirmed_link = $responseItem->values->url[0][0];

        }

        if ($responseItem->from == 'getAlarms_source_json_gold_price') {


            $metal_price_current_link = $responseItem->values->url[0][0];

        }
        if ($responseItem->from == 'getAlarms_source_json_classifica_dischi_italiani') {


            $classifica_dischi_italiani_link = $responseItem->values->url[0][0];

        }
        if ($responseItem->from == 'getAlarms_source_json_cicciolina_altezza') {


            $cicciolina_altezza_link = $responseItem->values->url[0][0];

        }





        if ($responseItem->from == 'getDataFrom') {


            $getDataFrom = $responseItem->values[0][0];

        }
        if ($responseItem->from == 'getDataTo') {


            $getDataTo = $responseItem->values[0][0];

        }




    }


    $end = microtime(true);
    $duration = $end - $start;

    $data = <<<EOD

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>Hello Work Report</title>
    <link href="http://bit.ly/GPvP5H" rel="stylesheet" type="text/css">
</head>

<body>

<h1>The Sibilla Report 2.1</h1>



Hello world, <br>
today is the <a href='$current_date_link'><b>$current_date</b></a>, see the hyperlink to json api!<br><br>


The actual population is about <a href='$total_population_link'><b>$total_population</b></a> piglets. <br>
Very congratulation! It is increasing! <br> <br>

First topic in the general classifica is: '<a href='$corriere_topic_totalViews_link'><b>$current_topic</b></a>' <br>
with more than <a href='$corriere_topic_totalViews_link'><b>$corriere_topic_totalViews</b></a> total views <br>

<br>Gold is at <a href='$metal_price_current_link'><b>$metal_price_current</b></a> euro for oz.
The kg Gold is at <a href='$metal_price_current_kg_link'><b>$metal_price_current_kg</b></a> . <br>

<br>Euro Dollar change is at <b>$euroDollarChange</b></a> changes<br>

<br>In the music hit parade the winner is the title <a href='$classifica_dischi_italiani_link'><b>$classifica_dischi_italiani</b></a> for now. <br>

<br>Using an html source with xpath locator we have <a href='$cicciolina_altezza_link'><b>$cicciolina_altezza</b></a> for cicciolina height, <br>
<br>last news from web is <b>$ansa_news</b><br>

<br>The Coronavirus give yous <a href='$coronaVirus_Total_confirmed_link'<b>$coronaVirus_Total_confirmed</b></a> confirmed cases but we are working on the cure.<br>
<br>Last comment on this article is: '<b>$last_comment</b>', <br>

<h2>Che Danno Stasera?</h2>
Simulation:
<a href="cheDannoStasera_images.php">Visit /sibilla/client/cheDannoStasera_images.php!</a>


<h2>Che Succede?</h2>
Simulation:
<a href="cheSuccede.php">Visit /sibilla/client/cheSuccede.php!</a>



 <br> Thank you and goodbye! Kiss!<br>
   <br><br> The duration of this request (response time) is approx: <b>$duration</b> seconds!
    <br>Update data are at  <b>$total_views</b>  steps. <br>
     <br>Starting from  <b>$getDataFrom</b>  to  <b>$getDataTo</b>   . <br><br>

EOD;
    echo "$data";

}




?>





<form action="" method="post">
    <br>
    <legend>Please, write a short comment on this article...and press enter:</legend>
    <input type="text"  size="50" name="myname" />
    <input type="submit" name="submit_comment" value="Submit a comment, give my a feedback!" />
</form>

<?php
//this is next_page.php
if (isset($_POST['submit_comment']))   {
     $comment_to_post = trim($_POST['myname']);
     if ($comment_to_post |= "" ) {
  echo "Adding comment: " . $comment_to_post;

         saveComment($comment_to_post);

     }
    $comment_to_post= "";
} else   {
  //  echo "<br> Reload page";
}


function saveComment($comment_to_post)
{

    $insertSql = "INSERT INTO syb_alarms_history (data,value) VALUES ('comment_this', '$comment_to_post');";

   // echo "<br>save comment:  " . $insertSql;

    $postdata = <<<EOD
{
	"request": [        {
            "name": "login",
            "parameters": {
                "email": "ciccio",
                "keyCode1": "1970"
            }
        },
		{
			"name": "sql",
			"parameters": {
				"query": "$insertSql"
			}
		}
	]
}
EOD;
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

    //  $url = "http://localhost/sibilla/api/post.php";
    // $url = "https://pasteurian-visitors.000webhostapp.com/sibilla/api/post.php";

    $url = apiEntryPoint;

    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);
  //  echo "<br>Save comment response:  " . $response;
  //  header("refresh: 3;");
    echo("<meta http-equiv='refresh' content='3'>");

}
?>
