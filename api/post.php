<?php


include_once './callToAction.php';
include_once './logAction.php';
include_once './loginAction.php';
include_once './checkAccessToken.php';

$GLOBALS['babboDiMinchia']['response'] = array();

$input_json = file_get_contents('php://input'); //($_POST doesn't work here)

$decoded_json = json_decode($input_json, true); // decoding received JSON to array
$actions = $decoded_json['request'];

$headers = getallheaders();
$headers_tolower = array_change_key_case($headers, CASE_LOWER);

if(isset($headers_tolower['access_token'])) {

$access_token = $headers_tolower['access_token'];



checkAccessToken($access_token);
}
else {

  # login, verifica only the presence of login function in the request
  if (loginAction == true) {

      $loginPresent = false;
 
      foreach ($actions as $action) {

          if ($action['name'] == 'login') $loginPresent = true;

      }
      if ($loginPresent === false) loginAction(null);

  }
}



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
