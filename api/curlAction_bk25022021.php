<?php

class curlAction
{




    function getResponseJson($action)
    {
        $method = $action["parameters"]["method"];
        $header = $action["parameters"]["header"];
        $data=  $action["parameters"]["data"];
// $header="content-type: application/json\r\n" . "x-sistema-chiamante: aci";
// var_dump( array_values($header)[0]);
    //    $header=   array_values($header)[0];
//               'header'  => "content-type: application/json\r\n" . "x-sistema-chiamante: aci",
      var_dump("ciccsssssio");
 die();ss


        $data = <<<EOD
{
        "registraAccesso":true,
        "userId":"wiseman4",
        "password":"wiseman4",
        "fromApp":true
  }
  
  
EOD;

        var_dump($data);
        die();
        $opts = array('http' =>
            array(
                'method'  => $method,
                'header'  => $header,
                'content' => $data
            )
        );

   //    var_dump($header);
     //   echo "ciccio";
 // var_dump( $header);

        $context  = stream_context_create($opts);
        $result = file_get_contents('https://ws-test.telepass.com/TelepassKTB_REST/ktb/utente/login', false, $context);

        $code= "22000"  ;







        header("content-type:application/json");

        $response['from'] = "curl";
        $response_decode = json_decode($result, true);
        $response['response'] = $response_decode;


        $response['token'] =$response['response']['jwtToken'];
        array_push($GLOBALS['babboDiMinchia']['response'], $response);

        return $data;
    }


}
