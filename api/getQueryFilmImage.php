<?php


/*
$name="staseraInTv18_rai1_image_link";
$string= getQueryFilmImage($name);

print_r($string);


die();
*/

function getQueryFilmImage($name)
{
$channel =   preg_split("/_image_link/", $name);
     // $GLOBALS['babboDiMinchia'] .= '"":""}},';
$tvQueryByText  = "select value from syb_alarms_history   WHERE `data` = '$channel[0]' order by id desc limit 1";


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
		"from": "tvQueryByText",
		"parameters": {
		"query": "$tvQueryByText"
		}
	}]
}
EOD;

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

$testCallresponse = queryStringFormatted($data);
//  return $testCallresponse;

$keywords = (array) null;
$keywords = preg_split("/[\s,]+/",  $testCallresponse);

$ret= $keywords[1] . "%20" . $keywords[2] . "%20" . $keywords[3] . "%20" . $keywords[4] . "%20tv" ;




    return $ret;


}




function queryStringFormatted($data)
{



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
 return $ciccio[0]->values[0][0];
//    echo "<h3>Che Danno Stasera?</h3>";






}
