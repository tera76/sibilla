<?php


function identityAction($action)
{


    // $json_encode = json_encode($action);
    //  $GLOBALS['babboDiMinchia'] .= $json_encode;
    //  $GLOBALS['babboDiMinchia'] .= ",";


    $response['from'] = "identity";
    $response['values'] = $action;
    array_push($GLOBALS['babboDiMinchia']['response'], $response);

}

