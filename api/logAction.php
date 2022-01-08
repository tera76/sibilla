<?php
# require __DIR__ . '/conf/environment.conf.php';

class logAction
{

    public function __construct()
    {


    }


    function logAction($actions)
    {

        $request_encoded = json_encode($actions);

        $response['from'] = "log";
        $response['values']['message'] = "logged action performed";

        array_push($GLOBALS['babboDiMinchia']['response'], $response);
        $response_encoded = json_encode($GLOBALS['babboDiMinchia']);




        $query = "INSERT INTO syb_log (request,response) VALUES ('$request_encoded','$response_encoded');";
        $internalAction['parameters']['query'] = $query;
        sql($internalAction);


    }


    function getLogAction($action)
    {

        $limit = $action["parameters"]["limit"];

        $query = "SELECT id,timestamp, request, response from  syb_log order by id desc limit $limit;";

        $internalAction['parameters']['query'] = $query;

        $value = sql($internalAction);

        $response['from'] = "getLog";
        $response['values'] = $value;

        array_push($GLOBALS['babboDiMinchia']['response'], $response);

    }
}