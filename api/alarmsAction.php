<?php
# remove todo include_once "./getQueryFilmImage.php";
include_once "./saveDataHistoryAction.php";

$debug=false;
if ($debug==true){

$action = "{}";


echo "response" . "<br>";
$class = new alarmsAction();
$response = $class->updateAlarms($action);

var_dump($response) ;
echo  "<br>" . "fineeee" . "<br>";
die();
}


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


        if (!isset($action["parameters"]["name"]))
        {

            $allAlarms = $this->getAllAlarmsInDb($action);
            $this->saveDataHistory($allAlarms);
        }
        else
        {
            $parameterName = $action["parameters"]["name"];

            $Alarms = $this->getAlarmInDb($parameterName);

            $this->saveDataHistory($Alarms);
        }
    }

    function getAlarmsDZero($action)
    {
        $allAlarms = $this->getAllAlarmsInDb($action);
        $this->getDZero($allAlarms);
    }

    function getAlarmsTotalView()
    {
        $response["from"] = "getAlarmsTotalView";
        $response["values"]["total_views"] = $totalView = $this->countName("current_time");

        array_push($GLOBALS["babboDiMinchia"]["response"], $response);
    }

    function getAlarms_current_time_link()
    {
        $response["from"] = "getAlarms_current_time_link";
        $response["values"]["url"] = $this->getUrlByNameMap("current_time");

        array_push($GLOBALS["babboDiMinchia"]["response"], $response);
    }

    function getAlarms_source_link($action)
    {
        $value = $action["parameters"]["name"];

        $response["from"] = "getAlarms_source_json_$value";
        $response["values"]["url"] = $this->getUrlByNameMap($value);

        array_push($GLOBALS["babboDiMinchia"]["response"], $response);
    }

    function countName($name)
    {
        $query = "SELECT count(*) from syb_alarms_history where data = '$name';";

        $internalAction["parameters"]["query"] = $query;
        $class = new sqlAction();
        $response = $class->sql($internalAction);

        return $response ;
    }

    function getUrlByNameMap($name)
    {
        $query = "SELECT url from syb_alarms_map where name = '$name';";

        $internalAction["parameters"]["query"] = $query;

        $class = new sqlAction();
        $response = $class->sql($internalAction);

        return $response;
    }

    function getDZero($allAlarms)
    {
        $response["from"] = "getDZero";

        $array = null;

        foreach ($allAlarms as $item)
        {
            $name = $item[0];

            $value = $this->getDZeroForName($name);

            $array[$name] = $value;
            $response["values"][$name] = $value;
            //            $response[$name] = $value;
            //       array_push($GLOBALS['babboDiMinchia']['response'], $response);

        }
        //  $response['values']  = "ciccio";
        array_push($GLOBALS["babboDiMinchia"]["response"], $response);

        return $array;
    }

    function getDZeroForName($name)
    {
        $query = "SELECT value from syb_alarms_history where data = '$name' order by id desc limit 1;";

        $internalAction["parameters"]["query"] = $query;
        $class = new sqlAction();
        $response = $class->sql($internalAction);

        return $response;

    }

    function saveDataHistory($allAlarms)
    {
    $class = new saveDataHistoryAction();
    $response = $class->saveDataHistoryAction($allAlarms);
    }

    function getAllAlarmsInDb($action)
    {

      if(!isset($action["parameters"]["batch"]))   {
        $batch=999;}
else $batch= $action["parameters"]["batch"];


if( $batch == 999)   {
        $query = "SELECT name as 'name', url as 'url', locator as 'locator', locatorType as 'locatorType' from syb_alarms_map where active >0;";
}
else {  $query = "SELECT name as 'name', url as 'url', locator as 'locator', locatorType as 'locatorType' from syb_alarms_map where active = $batch;";}
        $internalAction["parameters"]["query"] = $query;
        $class = new sqlAction();
        $response = $class->sql($internalAction);

        return $response;

    }

    function getAlarmInDb($name)
    {
        $query = "SELECT name as 'name', url as 'url', locator as 'locator', locatorType as 'locatorType' from syb_alarms_map where name ='$name';";

        $internalAction["parameters"]["query"] = $query;
        $class = new sqlAction();
        $response = $class->sql($internalAction);

        return $response;

    }


}
