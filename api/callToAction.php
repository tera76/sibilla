<?php

include_once './testAction.php';
include_once './identityAction.php';
include_once './sqlAction.php';
include_once './loginAction.php';
include_once './externalServiceGetAction.php';
include_once './externalServiceGetCorriereFixedParamAction.php';
include_once './getTitleSubstringFromCorriereAction.php';
include_once './logAction.php';
include_once './alarmsAction.php';
include_once './externalPageGetAction.php';
include_once './diagramStatusAction.php';
include_once './curlAction.php';

function
callToAction($action)
{


    $error_code = '"errorCode":"404",';
    $ko_mesage = '"callToActionStatus":"false",';

    // gestione degli errori

    $name = $action["name"];


    switch ($name) {
        case "getLog":
            $logs = new logAction();
            $logs->getLogAction($action);
            break;
        case "log":
#   delegate to post
            break;
        case "login":
            loginAction($action);
            break;
        case "test":
            testAction();
            break;
        case "identity":
            identityAction($action);
            break;
        case "sql":
            sql($action);
            break;
        case "externalServiceGetCorriereFixedParam":
            externalServiceGetCorriereFixedParamAction($action);
            break;
        case "externalServiceGet":
            externalServiceGetAction($action);
            break;
        case "getTitleSubstringFromCorriere":
            getTitleSubstringFromCorriereAction($action);
            break;
        case "updateAlarms":
            $alarms = new alarmsAction();
            $alarms->updateAlarms($action);
            break;
        case "getAlarmsDZero":
            $alarms = new alarmsAction();
            $alarms->getAlarmsDZero();
            break;
        case "getAlarmsTotalView":
            $alarms = new alarmsAction();
            $alarms->getAlarmsTotalView();
            break;
        case "getAlarms_current_time_link":
            $alarms = new alarmsAction();
            $alarms->getAlarms_current_time_link();
            break;
        case "getAlarms_source_link":
            $alarms = new alarmsAction();
            $alarms->getAlarms_source_link($action);
            break;
        case "externalPageGet":
            externalPageGetAction($action);
            break;
            // gojs diagrams
        case "getDiagramStatus":
            $diagram = new  diagramStatusAction();
            $diagram->getDiagramStatus($action);
            break;
        case "saveDiagramStatus":
            $diagram = new  diagramStatusAction();
            $diagram->saveDiagramStatus($action);
            break;
        case "getCurlResponse":
            $curl = new  curlAction();
            $curl->getResponseJson($action);
            break;
        default:

            # general logging

            $response['from'] = "callToAction";
            $response['values']['errorOrigin'] = $name;
            $response['values']['callToActionStatus'] = "false";
            $response['values']['errorCode'] = "404";
            array_push($GLOBALS['babboDiMinchia']['response'], $response);
            echo json_encode($GLOBALS['babboDiMinchia']);
            die();

    }


}

