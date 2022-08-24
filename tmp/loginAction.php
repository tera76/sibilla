<?php


function loginAction($action)
{


    $authenticationCode = $action["parameters"]["keyCode1"];
    $ko_authentication = '{"authenticationStatus":"false"}';
    $wrong_request = '{"authenticationStatus":"false"},';

    switch ($authenticationCode) {
        case "1970":
        case "1976":
        case "diagrammsPersistence1976":
            break;
        default:
            $response['from'] = "login";
            $response['values']['authenticationStatus'] = "false";

            array_push($GLOBALS['babboDiMinchia']['response'], $response);

            echo json_encode($GLOBALS['babboDiMinchia']);
            die();
    }


}

