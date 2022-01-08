<?php


function externalServiceGetCorriereFixedParamAction($action)
{


    $response['from'] = "externalServiceGetCorriereFixedParam";


    $externalGetCall = $action["parameters"]["externalUrl"];

    //  $GLOBALS['babboDiMinchia'] .= "{\"from\":\"externalServiceGetAction\",\"values\": {";


    $externalJson = file_get_contents($externalGetCall);
    $decoded_externalJson = json_decode($externalJson, true); // decoding received JSON to array

    $firstPositionJson = $decoded_externalJson['classifica']['dettaglioClassifica'][0];
    $position = $firstPositionJson['position'];
    $totViews = $firstPositionJson['totViews'];
    $title = $firstPositionJson['title'];


    $titleSubstring = substr($title, 0, 8);

    $response['values']['position'] = $position;


    $response['values']['totViews'] = $totViews;
    $response['values']['titleSubstring'] = $titleSubstring;

    //  $GLOBALS['babboDiMinchia'] .= '"position":"' . $position . '",';
    //  $GLOBALS['babboDiMinchia'] .= '"totViews":"' . $totViews . '",';
    //  $GLOBALS['babboDiMinchia'] .= '"titleSubstring":"' . $titleSubstring . '"';


    //  $GLOBALS['babboDiMinchia'] .= "}},";
    $GLOBALS['babboDiMinchia'] = array_merge($GLOBALS['babboDiMinchia']['response'], $response);

}

