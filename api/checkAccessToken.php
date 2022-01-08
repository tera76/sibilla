<?php


function checkAccessToken($access_token)
{

   $authenticationCode = strtolower($access_token);
   switch ($authenticationCode) {
       case "bearer 1970":
           break;
       default:
            header("HTTP/1.1 401 Unauthorized by sibilla");
            $response['from'] = "checkAccessToken";
            $response['values']['authenticationStatus'] = "false";
            array_push($GLOBALS['babboDiMinchia']['response'], $response);
            echo json_encode($GLOBALS['babboDiMinchia']);
           die();
   }


 }
