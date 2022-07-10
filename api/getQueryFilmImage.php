<?php

include_once './sqlAction.php';

$debug= false;
if($debug){
$name="staseraInTv18_la7D_image_link";
$string= getQueryFilmImage($name);

print_r($string);

die();
}

function getQueryFilmImage($name)
{



$channel =   preg_split("/_image_link/", $name);



     // $GLOBALS['babboDiMinchia'] .= '"":""}},';
$tvQueryByText  = "select value from syb_alarms_history   WHERE `data` = '$channel[0]' order by id desc limit 1";


  $internalAction['parameters']['query'] = $tvQueryByText;


$testCallresponse = sql($internalAction)[0][0];
//  return $testCallresponse;
$testCallresponse1= $testCallresponse;
// $testCallresponse1=  substr($testCallresponse, 0, 200);
//$testCallresponse2 = preg_replace('/\s\s+/', '',   $testCallresponse1);
$testCallresponse2 = preg_replace('/([0-9]|0[0-9]|1[0-9]|2[0-3]).[0-5][0-9]/', '',   $testCallresponse1);

$testCallresponse3 = preg_replace('/"/',' ', $testCallresponse2);

$testCallresponse4 = preg_replace('/\'/'," ", $testCallresponse3);

 $testCallresponse5=  substr($testCallresponse4, 0, 90);

//  $testCallresponse2 = preg_replace('/ /','%20', $testCallresponse1);

  //$testCallresponse3 = preg_split("/[\s,]+/",  $testCallresponse1);
  //$testCallresponse2 = preg_replace('/\s\s+/', '',   $testCallresponse1);
  //$keywords = $testCallresponse3;
 // var_dump($testCallresponse);
 // var_dump($keywords[0]);
//  var_dump(urlencode($testCallresponse));
// $ret=urlencode($testCallresponse);
  // $ret= $keywords[0] . "%20" . $keywords[1] . "%20" . $keywords[2] . "%20" . $keywords[3] . "%20" . $keywords[4] . "%20" . $keywords[5] . "%20tv" ;
$ret =urlencode($testCallresponse5);
// $testCallresponse3 = preg_replace('/ /','%20', $testCallresponse2);
// $ret=$testCallresponse2;
//  var_dump($ret);
//  die();
    return $ret;


}


/*

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
*/
