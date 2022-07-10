<?php

$debug= false;
if($debug){
$action["parameters"]["externalUrl"]="https://www.googleapis.com/customsearch/v1?key=AIzaSyCqQ4gssseK6C2NlhapDw_iOfNHBV_50E0&cx=02c284d1e5e214401&limit=1&totalResults=1&q=++Grey%E2%80%99s+Anatomy++4+episodi++%28TELEFILM%29%0A++++++++Drammatico-ospedalie";
$action["parameters"]["get"]["key"]="staseraInTv18_la7D_image_link";
// $action["parameters"]["get"]["value"]="items[?(@.pagemap.cse_image !=    '')]";
$action["parameters"]["get"]["value"]="items.0.pagemap.cse_image.0.src";
$string= externalServiceGetAction($action);
  var_dump($string);
die();
}


function externalServiceGetAction($action)
{

    $response['from'] = "externalServiceGet";


    $externalGetCall = $action["parameters"]["externalUrl"];
    $gets = $action["parameters"]["get"];


    //  $GLOBALS['babboDiMinchia'] .= "{\"from\":\"externalServiceGetAction\",\"values\": {";


    $externalJson = file_get_contents($externalGetCall);
    $decoded_externalJson = json_decode($externalJson, true); // decoding received JSON to array


    $returnArray = array();

    foreach ($gets as $key => $value) {

        $explodedGetTree = explode(".", $value);
        $jsonChild = $decoded_externalJson;

        foreach ($explodedGetTree as $child) {

            $jsonChild = $jsonChild[$child];

        }


        //  $GLOBALS['babboDiMinchia'] .= '"' . $key . '":"' . $jsonChild . '",';

        $returnArray[$key] = $jsonChild;

        $response['values'][$key] = $jsonChild;

    }
    array_push($GLOBALS['babboDiMinchia']['response'], $response);
    // $GLOBALS['babboDiMinchia'] .= '"":""}},';

    return $returnArray;
    // die();

}
