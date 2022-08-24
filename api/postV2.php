<?php
include_once './callToAction.php';
include_once './logAction.php';
include_once './loginAction.php';
include_once './checkAccessToken.php';

$GLOBALS['babboDiMinchia']['response'] = array();

$input_json = file_get_contents('php://input'); //($_POST doesn't work here)

$headers = getallheaders();

$access_token = $headers['access_token'];

checkAccessToken($access_token);


$decoded_json = json_decode($input_json, true); // decoding received JSON to array

$actions = $decoded_json['request'];




# call to action
foreach ($actions as $action) {
    callToAction($action);
    $name = $action["name"];
    if ($name == 'log') {
        $logs = new logAction();
        $logs->logAction($actions);


    }
}


# log on demand
#    foreach ($actions as $action) {
#        if ($action['name'] == 'log') {
#            $logs = new logAction();
#            $logs->logAction($actions);

#        };
#    }

# log in any case if enabled
if (logAction == true) {
    $logs = new logAction();
    $logs->logAction($actions);
}


echo json_encode($GLOBALS['babboDiMinchia']);

die();
