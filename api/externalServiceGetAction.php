<?php

$debug= false;
if($debug){

  var_dump("ciccio");
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
