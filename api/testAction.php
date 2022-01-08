<?php


function testAction()
{
  //  $from['from'] = "test";
 //   $message['testActionStatus'] = "true";
    $response['from'] = "test";
    $response['values']['testActionStatus'] = "true";

  //  var_dump(    $response['response']);
// die();
    //   $GLOBALS['babboDiMinchia'] .= "{\"from\":\"test\",\"values\":";
    //   $GLOBALS['babboDiMinchia'] .= $message;
    //   $GLOBALS['babboDiMinchia'] .=  "},";



      array_push($GLOBALS['babboDiMinchia']['response'], $response);



}

