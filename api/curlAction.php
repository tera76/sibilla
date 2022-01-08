<?php

class curlAction
{


    function getResponseJson($action)
    {
        $url = $action["parameters"]["url"];
        $method = $action["parameters"]["method"];
        $header = $action["parameters"]["header"];
        $data = $action["parameters"]["data"];
// $header="content-type: application/json\r\n" . "x-sistema-chiamante: aci";
// var_dump( array_values($header)[0]);
        //    $header=   array_values($header)[0];
//               'header'  => "content-type: application/json\r\n" . "x-sistema-chiamante: aci",
        //      var_dump($header);
// die();77      var_dump("ciccssss\sio");

        $data = json_encode($data);
        //N echo $data;
        // die();

        // body

        /*
                $data = <<<EOD
        {
                "registraAccesso":true,
                "userId":"wiseman4",
                "password":"wiseman4",
                "fromApp":true
          }




        EOD;
        */

      //   $data =
        $opts = array('http' =>
            array(
                'url' => $url,
                'method' => $method,
                'header' => $header,
                'content' => $data
            )
        );

        //  $data =$opts;

        //   var_dump($data);
        //  die();


        //    var_dump($header);
        //   echo "ciccio";
        // var_dump( $header);
      //  ini_set('default_socket_timeout', 900);
        ini_set('memory_limit', '256M');
        $context = stream_context_create($opts);

        //   $result = file_get_contents('https://ws-test.telepass.com/TelepassKTB_REST/ktb/utente/login', false, $context);
        $result = file_get_contents($url, false, $context);
     //   var_dump($http_response_header);
      //  $code = "22000";


          header("content-type:application/json");

        $response['from'] = "curl";
        $response_decode = json_decode($result, true);
        $response['responseJson'] = $response_decode;
        $response['responseCode'] =$http_response_header[0];
   //     $response['token'] = $response['response']['jwtToken'];
        array_push($GLOBALS['babboDiMinchia']['response'], $response);

        return $data;
    }


}
