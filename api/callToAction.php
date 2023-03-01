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


class callToAction {

      public function __construct()
      {


      }

function callToAction($action)
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
            $class = new sqlAction();
            $response = $class->sql($action);
            break;
        case "externalServiceGetCorriereFixedParam":
            externalServiceGetCorriereFixedParamAction($action);
            break;
        case "externalServiceGet":
            $class = new externalServiceGetAction();
            $class->externalServiceGetAction($action);
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
            $alarms->getAlarmsDZero($action);
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
        case "tvQueryPreferredWithImages":
        $tvQueryPreferredWithImages_query  =     "select
CONCAT( SUBSTRING_INDEX(SUBSTRING_INDEX(cf.data, '_', 2), '_', -1) , ' - ',
SUBSTRING_INDEX(SUBSTRING_INDEX(cf.data, '_', 4), '_', -1) ) as data, cf.value, (select  value as link from syb_alarms_history where data like concat(cf.data,'%_image_link') and value !='' order by id desc limit 1 ) as image_link from (select * from ( select distinct h.data, h.value from (select * from syb_alarms_history where data like 'staseraInTv%' and data not like '%_image_link' and DATE(`timestamp`) >= CURDATE() order by timestamp desc) as h join (select id, data from (select max(id) as id, max(timestamp) , max(data) as data from syb_alarms_history where data like 'staseraInTv%' GROUP by data ) as h ) as d join (select `keys` from syb_tv_preferred ) as p where h.id = d.id and instr(lower(h.value),lower(p.`keys`) ) > 0 ) as aaa where value not in ( select h.value from (select * from syb_alarms_history where data like 'staseraInTv%' and DATE(`timestamp`) >= CURDATE() order by timestamp desc) as h join (select id, data from (select max(id) as id, max(timestamp) , max(data) as data from syb_alarms_history where data like 'staseraInTv%' GROUP by data ) as h ) as d join (select `keys` from syb_tv_notPreferred ) as np where h.id = d.id and instr(lower(h.value),lower(np.`keys`) ) > 0 ) ) as cf ";

            $action["parameters"]["query"] = $tvQueryPreferredWithImages_query;

            $class = new sqlAction();
            $sql = $class->sql($action);

            break;

        case "tvQueryWithImages":
        $tvQueryWithImages_query = "select
CONCAT( SUBSTRING_INDEX(SUBSTRING_INDEX(cf.data, '_', 2), '_', -1) , ' - ',
SUBSTRING_INDEX(SUBSTRING_INDEX(cf.data, '_', 4), '_', -1) ) as data,
cf.value, (select  value as link from syb_alarms_history where data = concat(cf.data,'_image_link') and value !='' order by id desc limit 1 ) as image_link from (select distinct h.data, h.value  from (select  * from syb_alarms_history where  data like 'staseraInTv%' and data not like '%_image_link' and  DATE(`timestamp`) >= CURDATE() order by timestamp desc) as h join (select  id,  data    from (select  max(id) as id, max(timestamp) , max(data) as data  from syb_alarms_history where data like 'staseraInTv%'  GROUP by data ) as h  ) as d where h.id = d.id ) as cf ORDER by cf.data asc";

        $action["parameters"]["query"] = $tvQueryWithImages_query;


                $class = new sqlAction();
                $sql = $class->sql($action);
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


}}
