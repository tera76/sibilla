<?php

class alarmsAction
{

    public function __construct()
    {

    }

    function alarms($action)
    {
    }

    function updateAlarms($action)
    {



        if (!isset($action["parameters"]["name"])) {

            $allAlarms = $this->getAllAlarmsInDb();
            $this->saveDataHistory($allAlarms);
        } else {

            $parameterName = $action["parameters"]["name"];

            $Alarms = $this->getAlarmInDb($parameterName);


            $this->saveDataHistory($Alarms);
        }


    }


    function getAlarmsDZero()
    {
        $allAlarms = $this->getAllAlarmsInDb();
        $this->getDZero($allAlarms);


    }

    function getAlarmsTotalView()
    {
        $response['from'] = "getAlarmsTotalView";
        $response['values']["total_views"] = $totalView = $this->countName("current_time");


        array_push($GLOBALS['babboDiMinchia']['response'], $response);
    }


    function getAlarms_current_time_link()
    {
        $response['from'] = "getAlarms_current_time_link";
        $response['values']["url"] = $this->getUrlByNameMap("current_time");


        array_push($GLOBALS['babboDiMinchia']['response'], $response);
    }

    function getAlarms_source_link($action)
    {
        $value = $action["parameters"]["name"];

        $response['from'] = "getAlarms_source_json_$value";
        $response['values']["url"] = $this->getUrlByNameMap($value);


        array_push($GLOBALS['babboDiMinchia']['response'], $response);
    }


    function countName($name)
    {

        $query = "SELECT count(*) from syb_alarms_history where data = '$name';";


        $internalAction['parameters']['query'] = $query;


        return sql($internalAction);


    }


    function getUrlByNameMap($name)
    {

        $query = "SELECT url from syb_alarms_map where name = '$name';";


        $internalAction['parameters']['query'] = $query;


        return sql($internalAction);


    }


    function getDZero($allAlarms)
    {

        $response['from'] = "getDZero";


        $array = null;


        foreach ($allAlarms as $item) {
            $name = $item[0];

            $value = $this->getDZeroForName($name);


            $array[$name] = $value;
            $response['values'][$name] = $value;
//            $response[$name] = $value;
            //       array_push($GLOBALS['babboDiMinchia']['response'], $response);

        }
        //  $response['values']  = "ciccio";


        array_push($GLOBALS['babboDiMinchia']['response'], $response);

        return $array;
    }


    function getDZeroForName($name)
    {
        $query = "SELECT value from syb_alarms_history where data = '$name' order by id desc limit 1;";


        $internalAction['parameters']['query'] = $query;


        return sql($internalAction);

    }


    function saveDataHistory($allAlarms)
    {


        foreach ($allAlarms as $item) {

            $name = $item[0];
            $url = $item[1];
            $locator = $item[2];
            $locatorType = $item[3];

            if ($locator != 'localAction') {

                if ($locatorType == '' || $locatorType == 'json') {
                    //    var_dump("*******************************" . $locatorType);
                    $internalAction = '{"parameters": {';
                    $internalAction .= '"externalUrl": "' . $url . '",';
                    $internalAction .= '"get": {';
                    $internalAction .= '"' . $name . '": "' . $locator . '"}}}';

                    $internalAction_decoded = json_decode($internalAction, true);

                    $externalServiceGetAction = externalServiceGetAction($internalAction_decoded);

                    $value = $externalServiceGetAction[$name];

                    $this->saveAlarmsOnDb($name, $value);
                } else if ($locatorType == 'xpath' || $locatorType == 'html') {
                    //   var_dump("*******************************" . $locatorType);

                    $internalAction = '{"parameters": {';
                    $internalAction .= '"externalUrl": "' . $url . '",';
                    $internalAction .= '"get": {';
                    $internalAction .= '"' . $name . '": "' . $locator . '"}}}';

                    $internalAction_decoded = json_decode($internalAction, true);

                    $externalServiceGetAction = externalPageGetAction($internalAction_decoded);

                    $value = $externalServiceGetAction[$name];

                    $this->saveAlarmsOnDb($name, $value);


                }
            }
        }

    }


    function getAllAlarmsInDb()
    {
        $query = "SELECT name as 'name', url as 'url', locator as 'locator', locatorType as 'locatorType' from syb_alarms_map where active ='1';";

        $internalAction['parameters']['query'] = $query;


        return sql($internalAction);

    }

    function getAlarmInDb($name)
    {
        $query = "SELECT name as 'name', url as 'url', locator as 'locator', locatorType as 'locatorType' from syb_alarms_map where name ='$name';";



        $internalAction['parameters']['query'] = $query;




        return sql($internalAction);

    }

    function saveAlarmsOnDb($data, $value)
    {
        // apostrofi
        $value = str_replace("'","’",$value);

        //   $query = "INSERT INTO syb_alarms_history (data,value) VALUES ('" . $data . "','" . $value . "');";
        $query = "INSERT INTO syb_alarms_history (data,value) VALUES ('$data','$value');";


        $internalAction['parameters']['query'] = $query;
        sql($internalAction);


    }
}
